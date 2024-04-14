<?php

namespace App\Controllers;

use App\Entities\YudisiumPendaftaran;
use CodeIgniter\Exceptions\PageNotFoundException;

class YudisiumPendaftaranController extends BaseController
{
    protected $helpers = ['form', 'url'];

    protected function getListPeninjau()
    {
        return model('UserModel')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->where('auth_groups_users.group', 'user_fakultas')
            ->select('users.id, users.username, users.nip')
            ->findAll();
    }

    protected function getListPeriode()
    {
        return model('YudisiumPeriodeModel')->select('id, periode')
        ->orderBy('tanggal_akhir', 'ASC')
        ->findAll();
    }

    public function index()
    {
        /**
         * @var \App\Models\YudisiumPendaftaranModel $model
         */
        $model = model('YudisiumPendaftaranModel')
            ->join('users', 'users.id = yudisium_pendaftaran.mahasiswa_id', 'left')
            ->select('yudisium_pendaftaran.*, users.username, users.nim, users.program_studi');

        if ($this->request->getGet('search')) {
            $model->groupStart();
            $fields = ['nim', 'username', 'program_studi', 'yudisium_pendaftaran.status', 'tanggal_penerimaan', 'keterangan'];
            foreach ($fields as $field) {
                $model->orLike($field, $this->request->getGet('search'));
            }
            $model->groupEnd();
        }

        if ($this->request->getGet('status')) {
            $model->where('yudisium_pendaftaran.status', $this->request->getGet('status'));
        }

        if ($this->request->getGet('periode')) {
            $model->where('yudisium_pendaftaran.yudisium_periode_id', $this->request->getGet('periode'));
        }

        $perPage = $this->request->getGet('per_page') ?? 10;

        return view('fakultas/yudisium_pendaftaran/index', [
            'yudisium_pendaftaran' => $model->paginate($perPage ?? 10),
            'list_peninjau' => $this->getListPeninjau(),
            'list_periode' => $this->getListPeriode(),
            'pager' => $model->pager,
        ]);
    }

    public function show($id = null)
    {
        $model = model('YudisiumPendaftaranModel');

        return view('fakultas/yudisium_pendaftaran/show', [
            'yudisium_pendaftaran' => $model->where('id', $id)->first(),
        ]);
    }

    public function new()
    {
        return view('fakultas/yudisium_pendaftaran/new', [
            'list_peninjau' => $this->getListPeninjau(),
        ]);
    }

    public function create()
    {
        $YudisiumPendaftaranModel = model('YudisiumPendaftaranModel');

        $data = array_map(function ($value) {
            return $value === '' ? null : $value;
        }, $this->request->getPost());

        $files_data = $this->request->getFiles();

        $rules = [
            'nama_mahasiswa' => 'required',
            'nim' => 'required',
            'program_studi' => 'required',
            'status' => 'required',
            'tanggal_penerimaan' => 'permit_empty',
            'keterangan' => 'permit_empty',
            'peninjau_id' => 'permit_empty',
            'berkas_transkrip' => 'permit_empty',
            'berkas_ijazah' => 'permit_empty',
            'berkas_pas_foto' => 'permit_empty',
            'berkas_sertifikat_bahasa_inggris' => 'permit_empty',
            'berkas_akta_kelahiran' => 'permit_empty',
            'berkas_surat_keterangan_mahasiswa' => 'permit_empty',
        ];

        if ($data['status'] !== STATUS_MENUNGGU_VALIDASI) {
            $rules['peninjau_id'] = 'required';
        }

        if ($data['status'] === STATUS_SELESAI) {
            $rules['tanggal_penerimaan'] = 'required';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }
        
        /** @var \App\Models\UserModel $userModel */
        $userModel = model('UserModel');

        $mahasiswa = $userModel->findOrCreateMahasiswa($data['nim'], $data['nama_mahasiswa'], $data['program_studi']);

        if ($userModel->errors()) {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }

        if ($mahasiswa->yudisiumPendaftaran()) {
            return redirect()->back()->withInput()->with('errors', ['Mahasiswa sudah memiliki yudisium pendaftaran']);
        }

        $newYudisiumPendaftaran = new YudisiumPendaftaran($data);

        $newYudisiumPendaftaran->saveUploadedFiles($files_data);

        $YudisiumPendaftaranModel->save($newYudisiumPendaftaran);

        return redirect()->with('success', 'Data berhasil ditambahkan')->to('/fakultas/yudisium-pendaftaran');
    }

    public function edit($id = null)
    {
        $model = model('YudisiumPendaftaranModel');

        return view('fakultas/yudisium_pendaftaran/edit', [
            'yudisium_pendaftaran' => $model->find($id),
            'list_peninjau' => $this->getListPeninjau(),
        ]);
    }

    public function update($id = null)
    {
        
        $model = model('YudisiumPendaftaranModel');

        $data = array_map(function ($value) {
            return $value === '' ? null : $value;
        }, $this->request->getPost());

        $data['id'] = $id;
        
        // dd($data);

        $rules = [
            'status' => 'required',
            'tanggal_penerimaan' => 'permit_empty',
            'keterangan' => 'permit_empty',
            'peninjau_id' => 'permit_empty',
        ];

        if ($data['status'] !== STATUS_MENUNGGU_VALIDASI) {
            $rules['peninjau_id'] = 'required';
        }

        if ($data['status'] === STATUS_SELESAI) {
            $rules['tanggal_penerimaan'] = 'required';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $model->save($data);

        if ($model->errors()) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/fakultas/yudisium-pendaftaran');
    }

    public function delete($id = null)
    {
        $model = model('YudisiumPendaftaranModel');

        $model->delete($id, true);

        return redirect()->with('success', 'Data berhasil dihapus')->to('/fakultas/yudisium-pendaftaran');
    }
}
