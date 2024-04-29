<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class KeuanganController extends BaseController
{
    public function dashboard()
    {
        // data for dashboard number
        $data = [
            'belum_mengajukan' => 0,
            'menunggu_validasi' => 0,
            'selesai' => 0,
        ];

        /**
         * @var \App\Models\YudisiumPendaftaranModel $pendaftaran_model
         */
        $model = model('suratKeteranganModel');

        $data['belum_mengajukan'] = $model->where('surat_keterangan.jenis_surat', JENIS_SK_BEBAS_UKT)
            ->where('surat_keterangan.status', STATUS_MENUNGGU_VALIDASI)
            ->countAllResults();

        $data['selesai'] = $model->where('surat_keterangan.jenis_surat', JENIS_SK_BEBAS_UKT)
            ->where('surat_keterangan.status', STATUS_SELESAI)
            ->orWhere('surat_keterangan.jenis_surat', STATUS_SELESAI_BEASISWA)
            ->orWhere('surat_keterangan.status', STATUS_DITOLAK)
            ->countAllResults();

        return view('keuangan/dashboard', $data);
    }

    public function validasiSuratKeterangan()
    {
        if (! $this->request->is('post')) {
            /** @var \App\Models\SuratKeteranganModel $suratKeteranganModel */
            $suratKeteranganModel = model('SuratKeteranganModel');

            $data = [
                'surat_keterangan' => $suratKeteranganModel->where('surat_keterangan.jenis_surat', JENIS_SK_BEBAS_UKT)
                    ->where('surat_keterangan.status', STATUS_MENUNGGU_VALIDASI)
                    ->orderBy('created_at', 'desc')
                    ->join('users', 'users.id = surat_keterangan.mahasiswa_id')
                    ->select('surat_keterangan.*, users.username as mahasiswa_username, users.nim as mahasiswa_nim, users.program_studi as mahasiswa_program_studi')
                    // ->paginate(10),
                    ->findAll(),
                'pager' => $suratKeteranganModel->pager,
            ];

            return view('keuangan/validasi_surat_keterangan', $data);
        }

        $data = $this->request->getPost();

        $rules = [
            'id' => 'required|numeric',
            'action' => [
                'rules' => 'required|in_list[validasi,tolak,validasi_beasiswa]',
                'errors' => [
                    'in_list' => 'Invalid action.'
                ]
            ]
        ];

        if ($data['action'] === 'validasi') {
            $rules['nomor_surat'] = [
                'label' => 'Nomor Surat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ];
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        /** @var \App\Entities\SuratKeterangan $skEntity */
        $skEntity = model('SuratKeteranganModel')->find($data['id']);

        $action = $data['action'];

        // dd($action);

        switch ($action) {
            case 'validasi':
                $skEntity->validasi(auth()->user()->id, $data['nomor_surat'], $data['keterangan']);
                break;
            case 'tolak':
                $skEntity->tolak(auth()->user()->id, $data['keterangan']);
                break;
            case 'validasi_beasiswa':
                $skEntity->validasiBeasiswa(auth()->user()->id, $data['keterangan']);
                break;
        }

        if (model('SuratKeteranganModel')->errors()) {
            return redirect()->route('keuangan.validasi_surat_keterangan')->with('errors', model('SuratKeteranganModel')->errors());
        }

        return redirect()->route('keuangan.validasi_surat_keterangan')->with('success', 'Surat keterangan berhasil ' . ($action === 'validasi' ? 'divalidasi' : 'ditolak'));
    }

    public function berkasBebasUkt($id, $jenis_berkas)
    {
        $suratKeteranganModel = model('SuratKeteranganModel');

        $suratKeterangan = $suratKeteranganModel->find($id);

        if (! $suratKeterangan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $file_path = WRITEPATH . 'uploads/' . $suratKeterangan->getBerkasPath($jenis_berkas);

        if (! file_exists($file_path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->download($file_path, null, true)
        ->inline();
    }
}
