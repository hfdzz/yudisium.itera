<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class MahasiswaController extends BaseController
{
    protected $helpers = ['form'];

    public function dashboard()
    {
        // Dashboard for mahasiswa
        return view('dashboard');
    }

    public function daftarYudisium()
    {
        if (! $this->request->is('post')) {
            return view('mahasiswa/daftar_yudisium');
        }

        // Check if periode pendaftaran yudisium is open
        // TODO: Implement this

        // Validate uploaded files

        $rules = [
            'berkas_transkrip' => [
                // required uploaded file (max: 2MB, mime: pdf)
                'rules' => 'uploaded[berkas_transkrip]|max_size[berkas_transkrip,2048]|ext_in[berkas_transkrip,pdf]',
                'errors' => [
                    'uploaded' => 'Transkrip harus diunggah.',
                    'max_size' => 'Ukuran berkas transkrip maksimal 2MB.',
                    'ext_in' => 'Transkrip harus berformat PDF.',
                ],
            ],
            // TODO: uncomment this after the form is ready
            // 'berkas_ijazah' => [
            //     // required uploaded file (max: 2MB, mime: pdf)
            //     'rules' => 'uploaded[berkas_ijazah]|max_size[berkas_ijazah,2048]|ext_in[berkas_ijazah,pdf]',
            //     'errors' => [
            //         'uploaded' => 'Ijazah harus diunggah.',
            //         'max_size' => 'Ukuran berkas ijazah maksimal 2MB.',
            //         'ext_in' => 'Ijazah harus berformat PDF.',
            //     ],
            // ],
            // 'berkas_pas_foto' => [
            //     // required uploaded file (max: 2MB, mime: jpg, jpeg, png)
            //     'rules' => 'uploaded[berkas_pas_foto]|max_size[berkas_pas_foto,2048]|ext_in[berkas_pas_foto,jpg,jpeg,png]',
            //     'errors' => [
            //         'uploaded' => 'Pas foto harus diunggah.',
            //         'max_size' => 'Ukuran berkas pas foto maksimal 2MB.',
            //         'ext_in' => 'Pas foto harus berformat JPG, JPEG, atau PNG.',
            //     ],
            // ],
            // 'berkas_sertifikat_bahasa_inggris' => [
            //     // required uploaded file (max: 2MB, mime: pdf)
            //     'rules' => 'uploaded[berkas_sertifikat_bahasa_inggris]|max_size[berkas_sertifikat_bahasa_inggris,2048]|ext_in[berkas_sertifikat_bahasa_inggris,pdf]',
            //     'errors' => [
            //         'uploaded' => 'Sertifikat bahasa inggris harus diunggah.',
            //         'max_size' => 'Ukuran berkas sertifikat bahasa inggris maksimal 2MB.',
            //         'ext_in' => 'Sertifikat bahasa inggris harus berformat PDF.',
            //     ],
            // ],
            // 'berkas_akta_kelahiran' => [
            //     // required uploaded file (max: 2MB, mime: pdf)
            //     'rules' => 'uploaded[berkas_akta_kelahiran]|max_size[berkas_akta_kelahiran,2048]|ext_in[berkas_akta_kelahiran,pdf]',
            //     'errors' => [
            //         'uploaded' => 'Akta kelahiran harus diunggah.',
            //         'max_size' => 'Ukuran berkas akta kelahiran maksimal 2MB.',
            //         'ext_in' => 'Akta kelahiran harus berformat PDF.',
            //     ],
            // ],
            // 'berkas_surat_keterangan_mahasiswa' => [
            //     // required uploaded file (max: 2MB, mime: pdf)
            //     'rules' => 'max_size[berkas_surat_keterangan_mahasiswa,2048]|ext_in[berkas_surat_keterangan_mahasiswa,pdf]',
            //     'errors' => [
            //         // 'uploaded' => 'Surat keterangan mahasiswa harus diunggah.',
            //         'max_size' => 'Ukuran berkas surat keterangan mahasiswa maksimal 2MB.',
            //         'ext_in' => 'Surat keterangan mahasiswa harus berformat PDF.',
            //     ],
            // ],
        ];

        $data = $this->request->getFiles();

        if (! $this->validateData($data, $rules)) {
            return redirect()->back()->withInput();
        }

        // Check if sk bebas perpustakaan and sk bebas ukt are available
        // TODO: Implement this

        // Check if sk bebas lab is available (using silabor.lab api)
        // TODO: Implement this

        // Create new pendaftaran yudisium
        // Check existing pendaftaran yudisium

        // If exists, update the existing pendaftaran yudisium only if the status is 'ditolak'

        // Save uploaded files to storage

        // Change status to 'menunggu validasi'
        // TODO: Implement this

        // Redirect to mahasiswa dashboard
        return redirect()->route('mahasiswa.dashboard')->with('success', 'Pendaftaran yudisium berhasil diajukan.');
    }

    public function skBebasPerpustakaan()
    {
        if (! $this->request->is('post')) {
            return view('mahasiswa/sk_bebas_perpustakaan');
        }
    }

    public function skBebasUkt()
    {
        if (! $this->request->is('post')) {
            return view('mahasiswa/sk_bebas_ukt');
        }
    }

    public function statusYudisium()
    {
        return view('mahasiswa/status_yudisium');
    }
}
