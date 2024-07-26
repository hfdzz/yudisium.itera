<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * @var \App\Models\SuratKeteranganModel $model
 */
class SkBebasUktController extends BaseController
{
    protected $helpers = ['form'];
    
    public function index()
    {
        $data = $this->request->getGet(); 
        $search = $data['search'] ?? null;
        $perPage = $data['per_page'] ?? 10;

        /** @var \App\Models\SuratKeteranganModel $model */
        $model = model('SuratKeteranganModel');

        $db = db_connect();

        // list of month and year for filter
        $tanggal_pengajuan_month_year_list = $db->table('surat_keterangan')
        ->select('DATE_FORMAT(tanggal_pengajuan, "%m") month, DATE_FORMAT(tanggal_pengajuan, "%Y") year')
        ->where('surat_keterangan.jenis_surat', JENIS_SK_BEBAS_UKT)
        ->groupBy('year(tanggal_pengajuan), month(tanggal_pengajuan)')
        ->orderBy('year(tanggal_pengajuan)', 'desc')
        ->orderBy('month(tanggal_pengajuan)', 'desc')
        ->get()
        ->getResultArray();
    
        // get filter value
        $get_tanggal_pengajuan = (string)$this->request->getGet('tanggal_pengajuan');
        $get_tanggal_pengajuan_array = explode('_', $get_tanggal_pengajuan);
        
        $tanggal_pengajuan_filter = count($get_tanggal_pengajuan_array) === 2 ?
            [['month' => $get_tanggal_pengajuan_array[0], 'year' => $get_tanggal_pengajuan_array[1]]] : null;

        $query = $model->where('jenis_surat', JENIS_SK_BEBAS_UKT)
            // Most recent first 
            ->orderBy('created_at', 'desc')
            ->join('users as mahasiswa', 'mahasiswa.id = surat_keterangan.mahasiswa_id', 'left')
            ->join('users as peninjau', 'peninjau.id = surat_keterangan.peninjau_id', 'left')
            ->select('surat_keterangan.*, mahasiswa.username as mahasiswa_name, mahasiswa.nim as mahasiswa_nim, mahasiswa.program_studi as mahasiswa_program_studi, peninjau.username as peninjau_name, peninjau.nip as peninjau_nip');

        if ($tanggal_pengajuan_filter) {
            $query->where('YEAR(tanggal_pengajuan)', (int)$tanggal_pengajuan_filter[0]['year'])
                ->where('MONTH(tanggal_pengajuan)', (int)$tanggal_pengajuan_filter[0]['month']);
        }

        $data = [
            'sk_bebas_ukt' => $query
                ->orderBy('created_at', 'desc')
                ->findAll(),
            'pager' => $model->pager,
            'tanggal_pengajuan_month_year_list' => $tanggal_pengajuan_month_year_list,
            'tanggal_pengajuan_filter' => $get_tanggal_pengajuan,
        ];

        return view('keuangan/surat_keterangan/index', $data);
    }

    public function show($id = null)
    {
        $model = model('SuratKeteranganModel');

        $data = [
            'sk_bebas_ukt' => $model->find($id),
        ];

        // dd($id);

        return view('keuangan/surat_keterangan/show', $data);
    }

    public function new()
    {
        $data = [
            'list_peninjau' => model('UserModel')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                ->where('auth_groups_users.group', 'user_keuangan')
                ->select('users.id, users.username, users.nip')
                ->findAll(),
        ];

        return view('keuangan/surat_keterangan/new', $data);
    }

    public function create()
    {
        $model = model('SuratKeteranganModel');

        $data = array_map(function ($value) {
            return $value === '' ? null : $value;
        }, $this->request->getPost());

        // set current user as peninjau
        $data['peninjau_id'] = auth()->id();

        $rules = [
            'nama_mahasiswa' => 'required',
            'nim' => 'required',
            'program_studi' => 'required',
            'status' => 'required',
            'tanggal_pengajuan' => 'required',
        ];
        if ($data['status'] == 'selesai') {
            $rules['nomor_surat'] = 'required';
            $rules['tanggal_terbit'] = 'required';
            $rules['peninjau_id'] = 'required';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        /** @var \App\Models\UserModel $userModel */
        $userModel = model('UserModel');

        $mahasiswa = $userModel->findOrCreateMahasiswa($data['nim'], $data['nama_mahasiswa'], $data['program_studi']);

        if ($userModel->errors()) {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }

        if ($mahasiswa->suratKeteranganBebasUkt()) {
            return redirect()->back()->withInput()->with('errors', ['Mahasiswa dengan NIM ' . $data['nim'] . ' sudah memiliki surat keterangan bebas UKT']);
        }


        $model->save([
            ...$data,
            'jenis_surat' => 'sk_bebas_ukt',
            'mahasiswa_id' => $mahasiswa->id,
            // 'status' => $data['status'],
            // 'nomor_surat' => $data['nomor_surat'],
            // 'tanggal_terbit' => $data['tanggal_terbit'],
            // 'keterangan' => $data['keterangan'],
            // 'peninjau_id' => $data['peninjau'],
        ]);

        return redirect()->with('success', 'Data berhasil ditambahkan')->to('/keuangan/bebas-ukt');
    }

    public function edit($id = null)
    {
        $model = model('SuratKeteranganModel');

        /** @var \App\Models\UserModel $userModel */
        $userModel = model('UserModel');

        $listPeninjau = $userModel->join('auth_groups_users', 'auth_groups_users.user_id = users.id')    
            ->where('auth_groups_users.group', 'user_keuangan')
            ->select('users.id, users.username, users.nip')
            ->findAll();

        // dd($listPeninjau);

        $data = [
            'sk_bebas_ukt' => $model->find($id),
            'list_peninjau' => $listPeninjau,
        ];

        return view('keuangan/surat_keterangan/edit', $data);
    }

    public function update($id = null)
    {
        $model = model('SuratKeteranganModel');

        $data = array_map(function ($value) {
            return $value === '' ? null : $value;
        }, $this->request->getPost());

        // set current user as peninjau
        $data['peninjau_id'] = auth()->id();

        $data['id'] = $id;
        // dd($data);

        $model->save($data);

        if ($model->errors()) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->with('success', 'Data berhasil diubah')->to('/keuangan/bebas-ukt');
    }

    public function delete($id = null)
    {
        $model = model('SuratKeteranganModel');

        $model->delete($id, true);

        return redirect()->with('success', 'Data berhasil dihapus')->to('/keuangan/bebas-ukt');
    }
}
