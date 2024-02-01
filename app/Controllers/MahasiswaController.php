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
        // TODO: Remove this
        $repo_status = true;


        if (! $this->request->is('post')) {
            /**
             * @var \App\Entities\UserEntity $user
             */
            $user = auth()->user();
            $data = [
                'sk_bebas_perpustakaan' => $user->getSuratKeterangan(JENIS_SK_BEBAS_PERPUSTAKAAN),
                'status_repo' => $repo_status,
            ];
            return view('mahasiswa/sk_bebas_perpustakaan', $data);
        }
        
        // Check if user already has sk bebas perpustakaan
        /**
         * @var \App\Entities\UserEntity $user
         */
        $user = auth()->user();

        $sk_bebas_perpustakaan = $user->getSuratKeterangan(JENIS_SK_BEBAS_PERPUSTAKAAN);

        // only allow if there is no existing sk bebas perpustakaan or the existing sk bebas perpustakaan is rejected
        if ($sk_bebas_perpustakaan && $sk_bebas_perpustakaan->status != STATUS_DITOLAK) {
            $errors = [
                'sk_already_exists' => 'Anda sudah memiliki surat keterangan bebas perpustakaan.',
            ];
            return redirect()->back()->with('error', $errors);
        }

        // Check if user has completed the requirements
        // Check repo.itera
        // TODO: Implement this

        if ( ! $repo_status) {
            $errors = [
                'repo_status' => 'Anda belum menyelesaikan syarat bebas repositori',
            ];
            return redirect()->back()->with('error', $errors);
        }

        // Create new sk bebas perpustakaan
        /**
         * @var \App\Models\SuratKeteranganModel $model_sk
         */
        $model_sk = model('SuratKeteranganModel');

        $data = [
            'jenis_surat' => JENIS_SK_BEBAS_PERPUSTAKAAN,
            'mahasiswa_id' => $user->id,
        ];

        $model_sk->ajukanSuratKeterangan($data);

        if($model_sk->errors()) {
            return redirect()->back()->with('error', $model_sk->errors());
        }

        // Redirect to mahasiswa dashboard
        return redirect()->route('mahasiswa.dashboard')->with('success', 'Surat keterangan bebas perpustakaan berhasil diajukan.');
    }

    public function skBebasUkt()
    {
        if (! $this->request->is('post')) {
            /**
             * @var \App\Entities\UserEntity $user
             */
            $user = auth()->user();
            $data = [
                'sk_bebas_ukt' => $user->getSuratKeterangan(JENIS_SK_BEBAS_UKT)
            ];
            return view('mahasiswa/sk_bebas_ukt', $data);
        }

        $rules = [
            'berkas_ba_sidang' => [
                // required uploaded file (max: 2MB, mime: pdf)
                'rules' => 'uploaded[berkas_ba_sidang]|max_size[berkas_ba_sidang,2048]|ext_in[berkas_ba_sidang,pdf]',
                'errors' => [
                    'uploaded' => 'Berkas BA Sidang harus diunggah.',
                    'max_size' => 'Ukuran berkas BA Sidang maksimal 2MB.',
                    'ext_in' => 'Berkas BA Sidang harus berformat PDF.',
                ],
            ],
            // 'berkas_khs' => [
            //     // required uploaded file (max: 2MB, mime: pdf)
            //     'rules' => 'uploaded[berkas_khs]|max_size[berkas_khs,2048]|ext_in[berkas_khs,pdf]',
            //     'errors' => [
            //         'uploaded' => 'Berkas KHS harus diunggah.',
            //         'max_size' => 'Ukuran berkas KHS maksimal 2MB.',
            //         'ext_in' => 'Berkas KHS harus berformat PDF.',
            //     ],
            // ],
            // 'berkas_bukti_bayar_avita' => [
            //     // required uploaded file (max: 2MB, mime: pdf)
            //     'rules' => 'uploaded[berkas_bukti_bayar_avita]|max_size[berkas_bukti_bayar_avita,2048]|ext_in[berkas_bukti_bayar_avita,pdf]',
            //     'errors' => [
            //         'uploaded' => 'Berkas bukti bayar AVITA harus diunggah.',
            //         'max_size' => 'Ukuran berkas bukti bayar AVITA maksimal 2MB.',
            //         'ext_in' => 'Berkas bukti bayar AVITA harus berformat PDF.',
            //     ],
            // ],
        ];

        $data = $this->request->getFiles();

        if (! $this->validateData($data, $rules)) {
            return redirect()->back()->withInput();
        }

        // TODO: IMPLEMENT PENGAJUAN SK BEBAS UKT
        // $sk->ajukanSuratKeterangan(JENIS_SK_BEBAS_UKT);

        // Redirect to mahasiswa dashboard
        return redirect()->route('mahasiswa.dashboard')->with('success', 'Surat keterangan bebas UKT berhasil diajukan.');
    }   

    public function statusYudisium()
    {
        /**
         * @var \App\Entities\UserEntity $user
         */
        $user = auth()->user();

        $skBebasPerpustakaan = $user->getSuratKeterangan(JENIS_SK_BEBAS_PERPUSTAKAAN);
        $skBebasUkt = $user->getSuratKeterangan(JENIS_SK_BEBAS_UKT);
        $skBebasLabotatorium = $user->getSuratKeterangan(JENIS_SK_BEBAS_LABORATORIUM);
        $pendaftaranYudisium = $user->getPendaftaranYudisium();

        $data = [
            'sk_bebas_perpustakaan' => $skBebasPerpustakaan,
            'sk_bebas_ukt' => $skBebasUkt,
            'sk_bebas_laboratorium' => $skBebasLabotatorium,
            'pendaftaran_yudisium' => $pendaftaranYudisium,
        ];

        return view('mahasiswa/status_yudisium', $data);
    }
}
