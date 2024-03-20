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
        return view('dashboard');
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
            $skBebasPerpustakaan = $user->suratKeteranganBebasPerpustakaan();
            $skBebasUkt = $user->suratKeteranganBebasUkt();
            $skBebasLab = $user->suratKeteranganBebasLaboratorium();
            
            $data = [
                'sk_bebas_perpustakaan' => $skBebasPerpustakaan,
                'sk_bebas_ukt' => $skBebasUkt,
                'sk_bebas_lab' => $skBebasLab,
                'yudisium_pendaftaran' => $currentPeriode->getCurrentYudisiumPendaftaran($user->id),
                'yudisium_periode' => $currentPeriode,
            ];
            // dd($data);
            return view('mahasiswa/daftar_yudisium', $data);
        }

        // validate input
        $rules = [];

        $yudisium_service = new \App\Services\YudisiumService();

        try {
            $yudisium_service->daftarYudisium($user, $this->request->getPost());
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

        $file_data = $this->request->getFiles();

        if (! $this->validateData($file_data, $rules)) {
            return redirect()->back()->withInput();
        }   

        /** @var \App\Models\SuratKeteranganModel $model_sk */

        $model_sk = model('SuratKeteranganModel');

        try {
            $model_sk->ajukanSkBebasUkt([
                'mahasiswa_id' => auth()->id(),
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
            'sk_bebas_perpustakaan' => $skBebasPerpustakaan,
            'sk_bebas_ukt' => $skBebasUkt,
            'sk_bebas_laboratorium' => $skBebasLabotatorium,
            'pendaftaran_yudisium' => $pendaftaranYudisium,
        ];

        return view('mahasiswa/status_yudisium', $data);
    }
}
