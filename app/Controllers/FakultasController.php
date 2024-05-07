<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class FakultasController extends BaseController
{
    protected $helpers = ['form'];

    public function dashboard()
    {
        // Dashboard for fakultas
        $data = [
            'belum_divalidasi' => 0,
            // 'menunggu_validasi' => 0,
            'selesai' => 0,
        ];

        /**
         * @var \App\Models\YudisiumPendaftaranModel $pendaftaran_model
         */
        $model = model('YudisiumPendaftaranModel');

        $latest_periode = model('YudisiumPeriodeModel')->getLatestPeriode();

        if ($latest_periode) {
            $data['belum_divalidasi'] = $model->where('yudisium_pendaftaran.status', STATUS_MENUNGGU_VALIDASI)
                ->where('yudisium_pendaftaran.yudisium_periode_id', $latest_periode->id)
                ->countAllResults();
    
            $data['selesai'] = $model->groupStart()
                ->where('yudisium_pendaftaran.status', STATUS_SELESAI)
                ->orWhere('yudisium_pendaftaran.status', STATUS_DITOLAK)
                ->groupEnd()
                ->where('yudisium_pendaftaran.yudisium_periode_id', $latest_periode->id)
                ->countAllResults();
        }


        return view('fakultas/dashboard', $data);
    }

    public function validasiYudisium()
    {
        if (! $this->request->is('post')) {
            
            /**
             * @var \App\Models\YudisiumPendaftaranModel $pendaftaran_model
             */
            $pendaftaran_model = model('YudisiumPendaftaranModel');

            $perPage = $this->request->getGet('per_page') ?? 10;

            $latest_periode = model('YudisiumPeriodeModel')->getLatestPeriode();

            $data = [
                'pendaftaran' => $pendaftaran_model->where('yudisium_pendaftaran.status', STATUS_MENUNGGU_VALIDASI)
                    ->where('yudisium_pendaftaran.yudisium_periode_id', $latest_periode?->id)
                    ->orderBy('yudisium_pendaftaran.tanggal_daftar', 'desc')
                    ->join('users', 'users.id = yudisium_pendaftaran.mahasiswa_id')
                    ->select('yudisium_pendaftaran.*, users.username, users.nim, users.program_studi')
                    // ->paginate($perPage),
                    ->findAll(),
                'latest_periode' => $latest_periode,
                'pager' => $pendaftaran_model->pager,
            ];

            return view('fakultas/validasi_yudisium', $data);
        }

        $yudisium = new \App\Services\YudisiumService();

        /** @var \App\Models\YudisiumPendaftaranModel $yudisiumPendaftaranModel */
        $yudisiumPendaftaranModel = model('YudisiumPendaftaranModel');

        $data = $this->request->getPost();

        // dd($data);

        $yudisiumPendaftaran = $yudisiumPendaftaranModel->where('id', $data['id'])->first();

        if (! $yudisiumPendaftaran) {
            return redirect()->to('/fakultas/validasi-yudisium')->with('error', 'Pendaftaran yudisium tidak ditemukan');
        }
        
        try{
            if ($data['action'] == 'validasi') {
                // Terima pendaftaran yudisium
    
                $yudisium->validasiPendaftaranYudisium(
                    auth()->user(),
                    $yudisiumPendaftaran,
                    $data
                );
    
                return redirect()->to('/fakultas/validasi-yudisium')->with('success', 'Pendaftaran yudisium berhasil diterima');
            }
            else if ($data['action'] == 'tolak') {
                // Tolak pendaftaran yudisium
    
                $yudisium->tolakPendaftaranYudisium(
                    auth()->user(),
                    $yudisiumPendaftaran,
                    $data
                );
    
                return redirect()->to('/fakultas/validasi-yudisium')->with('success', 'Pendaftaran yudisium berhasil ditolak');
            }
            else {
                throw new \Exception('Invalid action');
            }
        }
        catch (\Exception $e) {
            return redirect()->to('/fakultas/validasi-yudisium')->with('error', $e->getMessage());
        }
    }

    public function periodeYudisium()
    {
        /** @var \App\Models\YudisiumPeriodeModel $periodeModel */
        $periodeModel = model('YudisiumPeriodeModel');

        if (! $this->request->is('post')) {
            // Periode Yudisium for fakultas

            $latestPeriode = $periodeModel->getLatestPeriode();

            $data = [
                'latest_periode' => $latestPeriode,
                'informasi' => $latestPeriode?->yudisiumPeriodeInformasi() ?? [],
            ];

            // dd($data);
    
            return view('fakultas/periode_yudisium', $data);
        }

        $data = $this->request->getPost();
    
        if (isset($data['close_periode']) && $data['close_periode'] == 1) {
            // Close periode
            $periodeModel->where('id', $data['id'])->first()->closePeriode();
            return redirect()->to('/fakultas/periode-yudisium')->with('success', 'Periode berhasil ditutup');
        }

        $informasiModel = model('YudisiumPeriodeInformasiModel');
        $db = \Config\Database::connect();
        
        $db->transStart();

        // Create new periode or update existing periode
        if ( !isset($data['id']) ) {
            try {
                $periodeModel->openNewPeriode($data);

                if($periodeModel->errors()) {
                    return redirect()->to('/fakultas/periode-yudisium/new')->with('errors', $periodeModel->errors());
                }

                $data['id'] = $periodeModel->getInsertID();
            } catch (\Exception $e) {
                return redirect()->to('/fakultas/periode-yudisium/new')->with('error', $e->getMessage());
            }
        } else {
            $periodeModel->update($data['id'], [
                'periode' => $periodeModel->find($data['id'])->periode,
                'tanggal_awal' => $data['tanggal_awal'],
                'tanggal_akhir' => $data['tanggal_akhir'],
            ]);
        }
        
        // Clear existing informasi and insert new informasi
        $periodeId = $data['id'];
        
        /** @var \App\Entities\YudisiumPeriode $yudisiumPeriode */
        $yudisiumPeriode = $periodeModel->find($periodeId);

        $yudisiumPeriode->clearInformasi();

        if(isset($data['link_grup_whatsapp']) && is_array($data['link_grup_whatsapp'])){
            foreach ($data['link_grup_whatsapp'] as $index => $link) {
                $informasiModel->insert([
                    'link_grup_whatsapp' => $link,
                    'keterangan' => $data['keterangan'][$index],
                    'yudisium_periode_id' => $periodeId,
                ]);
            }
        }


        $db->transComplete();

        // dd($db->error());

        return redirect()->to('/fakultas/periode-yudisium')->with('success', 'Periode berhasil disimpan');
    }

    public function newPeriodeYudisium()
    {
        $latest_periode = model('YudisiumPeriodeModel')->getLatestPeriode();
        $warning = model('YudisiumPendaftaranModel')->where('yudisium_periode_id', $latest_periode?->id)
            ->where('status', STATUS_MENUNGGU_VALIDASI)
            ->findAll() ? true : false;
        return view('fakultas/new_periode_yudisium', ['warning' => $warning]);
    }
}
