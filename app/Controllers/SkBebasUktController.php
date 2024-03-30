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

        $query = $model->where('jenis_surat', JENIS_SK_BEBAS_UKT)
            ->join('users as mahasiswa', 'mahasiswa.id = surat_keterangan.mahasiswa_id', 'left')
            ->join('users as peninjau', 'peninjau.id = surat_keterangan.peninjau_id', 'left')
            ->select('surat_keterangan.*, mahasiswa.username as mahasiswa_name, mahasiswa.nim as mahasiswa_nim, peninjau.username as peninjau_name, peninjau.nip as peninjau_nip');

        if ($search) {
            $query->groupStart();
            $fields = ['nomor_surat', 'mahasiswa.username', 'mahasiswa.nim', 'peninjau.username', 'peninjau.nip', 'tanggal_terbit', 'keterangan', 'surat_keterangan.status'];
            foreach ($fields as $field) {
                $query->orLike($field, $search);
            }
            $query->groupEnd();
        }

        $data = [
            'sk_bebas_ukt' => $query
                ->orderBy('created_at', 'desc')
                ->paginate($perPage),
            'pager' => $model->pager,
        ];

        return view('keuangan/surat_keterangan/index', $data);
    }

    public function show($id = null)
    {
        $model = model('SuratKeteranganModel');

        $data = [
            'sk_bebas_ukt' => $model->find($id),
        ];

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

        $rules = [
            'nama_mahasiswa' => 'required',
            'nim' => 'required',
            // 'program_studi' => 'required',
            'status' => 'required',
            // 'nomor_surat' => 'required',
            // 'tanggal_terbit' => 'required',
            // 'keterangan' => 'required',
            // 'peninjau' => 'required',
        ];

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
            'jenis_surat' => 'sk_bebas_ukt',
            'mahasiswa_id' => $mahasiswa->id,
            'status' => $data['status'],
            'nomor_surat' => $data['nomor_surat'],
            'tanggal_terbit' => $data['tanggal_terbit'],
            'keterangan' => $data['keterangan'],
            'peninjau_id' => $data['peninjau'],
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

        $model->delete($id);

        return redirect()->with('success', 'Data berhasil dihapus')->to('/keuangan/bebas-ukt');
    }
}
