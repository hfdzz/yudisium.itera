<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\SILABORService;

class MahasiswaController extends BaseController
{
    protected $helpers = ['form'];

    public function dashboard()
    {
        // Dashboard for mahasiswa

        $user = auth()->user();

        $userData = [
            $user->suratKeteranganBebasPerpustakaan(),
            $user->suratKeteranganBebasUkt(),
            $user->suratKeteranganBebasLaboratorium(),
            $user->yudisiumPendaftaran(),
        ];

        // data for dashboard number
        $data = [
            'belum_mengajukan' => 0,
            'menunggu_validasi' => 0,
            'selesai' => 0,
        ];

        foreach ($userData as $ud) {
            if ($ud) {
                if ($ud->isMenungguValidasi()) {
                    $data['menunggu_validasi']++;
                } elseif ($ud->isSelesai()) {
                    $data['selesai']++;
                }
            } else {
                $data['belum_mengajukan']++;
            }
        }
        
        return view('mahasiswa/dashboard', $data);
    }

    public function daftarYudisium()
    {
        /**
         * @var \App\Models\YudisiumPeriodeModel $yudisiumPeriodeModel
         */
        $yudisiumPeriodeModel = model('YudisiumPeriodeModel');
        $user = auth()->user();
        
        if (! $this->request->is('post')) {
            $currentPeriode = $yudisiumPeriodeModel->getCurrentPeriode();
            $yudisiumPendaftaran = auth()->user()->yudisiumPendaftaran();

            $skBebasPerpustakaan = $user->suratKeteranganBebasPerpustakaan();
            $skBebasUkt = $user->suratKeteranganBebasUkt();
            $skBebasLaboratorium = $user->suratKeteranganBebasLaboratorium();
            
            $data = [
                'sk_bebas_perpustakaan' => $skBebasPerpustakaan,
                'sk_bebas_ukt' => $skBebasUkt,
                'sk_bebas_laboratorium' => $skBebasLaboratorium,
                'yudisium_pendaftaran' => $yudisiumPendaftaran,
                'yudisium_periode' => $currentPeriode,
            ];

            return view('mahasiswa/daftar_yudisium', $data);
        }

        $skBebasUkt = $user->suratKeteranganBebasUkt();

        // validate input
        $rules = [
            'berkas_transkrip' => [
                'rules' => 'uploaded[berkas_transkrip]|max_size[berkas_transkrip,2048]|ext_in[berkas_transkrip,pdf]',
                'errors' => [
                    'uploaded' => 'Berkas BA Sidang harus diunggah.',
                    'max_size' => 'Ukuran berkas BA Sidang maksimal 2MB.',
                    'ext_in' => 'Berkas BA Sidang harus berformat PDF.',
                ],
            ],
            'berkas_ijazah' => [
                'rules' => 'uploaded[berkas_ijazah]|max_size[berkas_ijazah,2048]|ext_in[berkas_ijazah,pdf]',
                'errors' => [
                    'uploaded' => 'Berkas Ijazah harus diunggah.',
                    'max_size' => 'Ukuran berkas Ijazah maksimal 2MB.',
                    'ext_in' => 'Berkas Ijazah harus berformat PDF.',
                ],
            ],
            'berkas_pas_foto' => [
                'rules' => 'uploaded[berkas_pas_foto]|max_size[berkas_pas_foto,2048]|ext_in[berkas_pas_foto,pdf]',
                'errors' => [
                    'uploaded' => 'Berkas Pas Foto harus diunggah.',
                    'max_size' => 'Ukuran berkas Pas Foto maksimal 2MB.',
                    'ext_in' => 'Berkas Pas Foto harus berformat PDF.',
                ],
            ],
            'berkas_akta_kelahiran' => [
                'rules' => 'uploaded[berkas_akta_kelahiran]|max_size[berkas_akta_kelahiran,2048]|ext_in[berkas_akta_kelahiran,pdf]',
                'errors' => [
                    'uploaded' => 'Berkas Akta Kelahiran harus diunggah.',
                    'max_size' => 'Ukuran berkas Akta Kelahiran maksimal 2MB.',
                    'ext_in' => 'Berkas Akta Kelahiran harus berformat PDF.',
                ],
            ],
            'berkas_sertifikat_bahasa_inggris' => [
                'rules' => 'uploaded[berkas_sertifikat_bahasa_inggris]|max_size[berkas_sertifikat_bahasa_inggris,2048]|ext_in[berkas_sertifikat_bahasa_inggris,pdf]',
                'errors' => [
                    'uploaded' => 'Berkas Sertifikat Bahasa Inggris harus diunggah.',
                    'max_size' => 'Ukuran berkas Sertifikat Bahasa Inggris maksimal 2MB.',
                    'ext_in' => 'Berkas Sertifikat Bahasa Inggris harus berformat PDF.',
                ],
            ],
        ];

        if ($skBebasUkt?->isBeasiswa()) {
            $rules['berkas_surat_keterangan_mahasiswa'] = [
                'rules' => 'uploaded[berkas_surat_keterangan_mahasiswa]|max_size[berkas_surat_keterangan_mahasiswa,2048]|ext_in[berkas_surat_keterangan_mahasiswa,pdf]',
                'errors' => [
                    'uploaded' => 'Berkas Surat Keterangan Mahasiswa harus diunggah untuk mahasiswa beasiswa.',
                    'max_size' => 'Ukuran berkas Surat Keterangan Mahasiswa maksimal 2MB.',
                    'ext_in' => 'Berkas Surat Keterangan Mahasiswa harus berformat PDF.',
                ],
            ];
        }

        $upload_data = $this->request->getFiles();

        if (! $this->validateData([], $rules)) {
            return redirect()->back()->withInput();
        }

        $yudisium_service = new \App\Services\YudisiumService();

        try {
            $yudisium_service->daftarYudisium($user, $upload_data);
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', [$e->getMessage()]);
        }

        return redirect()->route('mahasiswa.daftar_yudisium')->with('success', 'Pendaftaran yudisium berhasil diajukan.');
    }

    public function skBebasPerpustakaan()
    {
        if (! $this->request->is('post')) {
            $data = [
                'sk_bebas_perpustakaan' => auth()->user()->suratKeteranganBebasPerpustakaan(),
            ];
            return view('mahasiswa/sk_bebas_perpustakaan', $data);
        }
        
        /**
         * @var \App\Models\SuratKeteranganModel $model_sk
         */
        $model_sk = model('SuratKeteranganModel');

        try {
            $model_sk->ajukanSkBebasPerpustakaan([
                'mahasiswa_id' => auth()->id(),
            ]);
            if($model_sk->errors()) {
                return redirect()->back()->with('errors', $model_sk->errors());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('mahasiswa.sk_bebas_perpustakaan')->with('success', 'Surat keterangan bebas perpustakaan berhasil diajukan.');
    }

    public function skBebasUkt()
    {
        if (! $this->request->is('post')) {
            $file_data = [
                'sk_bebas_ukt' => auth()->user()->suratKeteranganBebasUkt(),
            ];
            return view('mahasiswa/sk_bebas_ukt', $file_data);
        }

        $rules = [
            'tanggal_sidang' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal sidang harus diisi.',
                    'valid_date' => 'Tanggal sidang tidak valid.',
                ],
            ],
            'berkas_ba_sidang' => [
                // required uploaded file (max: 2MB, mime: pdf)
                'rules' => 'uploaded[berkas_ba_sidang]|max_size[berkas_ba_sidang,2048]|ext_in[berkas_ba_sidang,pdf]',
                'errors' => [
                    'uploaded' => 'Berkas BA Sidang harus diunggah.',
                    'max_size' => 'Ukuran berkas BA Sidang maksimal 2MB.',
                    'ext_in' => 'Berkas BA Sidang harus berformat PDF.',
                ],
            ],
            'berkas_khs' => [
                // required uploaded file (max: 2MB, mime: pdf)
                'rules' => 'uploaded[berkas_khs]|max_size[berkas_khs,2048]|ext_in[berkas_khs,pdf]',
                'errors' => [
                    'uploaded' => 'Berkas KHS harus diunggah.',
                    'max_size' => 'Ukuran berkas KHS maksimal 2MB.',
                    'ext_in' => 'Berkas KHS harus berformat PDF.',
                ],
            ],
            'berkas_bukti_bayar_ukt' => [
                // required uploaded file (max: 2MB, mime: pdf)
                'rules' => 'uploaded[berkas_bukti_bayar_ukt]|max_size[berkas_bukti_bayar_ukt,2048]|ext_in[berkas_bukti_bayar_ukt,pdf]',
                'errors' => [
                    'uploaded' => 'Berkas bukti bayar AVITA harus diunggah.',
                    'max_size' => 'Ukuran berkas bukti bayar AVITA maksimal 2MB.',
                    'ext_in' => 'Berkas bukti bayar AVITA harus berformat PDF.',
                ],
            ],
        ];

        $input_data = $this->request->getPost();
        $file_data = $this->request->getFiles();

        if (! $this->validateData($input_data, $rules)) {
            return redirect()->back()->withInput();
        }   

        var_dump($input_data, $file_data);

        /** @var \App\Models\SuratKeteranganModel $model_sk */

        $model_sk = model('SuratKeteranganModel');

        try {
            $model_sk->ajukanSkBebasUkt([
                'mahasiswa_id' => auth()->id(),
                'tanggal_sidang' => $input_data['tanggal_sidang'],
            ], $file_data);
            if($model_sk->errors()) {
                return redirect()->back()->with('errors', $model_sk->errors());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('mahasiswa.sk_bebas_ukt')->with('success', 'Surat keterangan bebas UKT berhasil diajukan.');
    }   

    public function statusYudisium()
    {
        $user = auth()->user();

        $skBebasPerpustakaan = $user->suratKeteranganBebasPerpustakaan();
        $skBebasUkt = $user->suratKeteranganBebasUkt();
        $skBebasLabotatorium = $user->suratKeteranganBebasLaboratorium();
        $pendaftaranYudisium = $user->yudisiumPendaftaran();

        $data = [
            'user' => $user,
            'sk_bebas_perpustakaan' => $skBebasPerpustakaan,
            'sk_bebas_ukt' => $skBebasUkt,
            'sk_bebas_laboratorium' => $skBebasLabotatorium,
            'yudisium_pendaftaran' => $pendaftaranYudisium,
        ];

        return view('mahasiswa/status_yudisium', $data);
    }
}
