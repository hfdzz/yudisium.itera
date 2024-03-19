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
        return view('dashboard');
    }

    public function validasiYudisium()
    {
        if (! $this->request->is('post')) {
            
            /**
             * @var \App\Models\YudisiumPendaftaranModel $pendaftaran_model
             */
            $pendaftaran_model = model('yudisiumPendaftaranModel');

            $perPage = $this->request->getGet('per_page') ?? 10;

            $data = [
                'pendaftaran' => $pendaftaran_model->where('yudisium_pendaftaran.status', STATUS_MENUNGGU_VALIDASI)
                    ->orderBy('yudisium_pendaftaran.created_at', 'desc')
                    ->join('users', 'users.id = yudisium_pendaftaran.mahasiswa_id')
                    ->select('yudisium_pendaftaran.* , users.username, users.nim')
                    ->paginate($perPage),
                'pager' => $pendaftaran_model->pager,
            ];

            return view('fakultas/validasi_yudisium', $data);
        }

        $yudisium = new \App\Services\YudisiumService();

        /** @var \App\Models\YudisiumPendaftaranModel $yudisiumPendaftaranModel */
        $yudisiumPendaftaranModel = model('YudisiumPendaftaranModel');

        $data = $this->request->getPost();

        $yudisiumPendaftaran = $yudisiumPendaftaranModel->find($data['id']);

        if (! $yudisiumPendaftaran) {
            return redirect()->to('/fakultas/validasi-yudisium')->with('error', 'Pendaftaran yudisium tidak ditemukan');
        }
        
        try{
            if ($data['action'] == 'terima') {
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

    public function detailValidasiYudisium($id)
    {
        // Detail Validasi Yudisium for fakultas
        return view('fakultas/detail_validasi_yudisium');
    }

    public function periodeYudisium()
    {
        $periodeModel = model('YudisiumPeriodeModel');

        if (! $this->request->is('post')) {
            // Periode Yudisium for fakultas

            $currentPeriode = $periodeModel->getCurrentOpenPeriode();
    
            $data = [
                'current_periode' => $currentPeriode,
                'informasi' => $currentPeriode ? $currentPeriode->periodeInformasi() : [],
            ];
    
            return view('fakultas/periode_yudisium', $data);
        }
        // dd($this->request->getPost());
        // Save periode yudisium

        $data = $this->request->getPost();

        $db = \Config\Database::connect();

        $informasiModel = model('YudisiumPeriodeInformasiModel');

        $db->transStart();

        $currentPeriode = $periodeModel->getCurrentOpenPeriode();

        if ($currentPeriode) {
            $periodeModel->update($data['id'], [
                'tanggal_awal' => $data['tanggal_awal'],
                'tanggal_akhir' => $data['tanggal_akhir'],
            ]);

            $currentPeriode->clearInformasi();

            foreach ($data['link'] as $index => $link) {
                $informasiModel->update($data['informasi_id'][$index], [
                    'link' => $link,
                    'keterangan' => $data['keterangan'][$index],
                ]);
            }

        } else {
            $periodeModel->openNewPeriode($data);
            
            foreach ($data['link'] as $index => $link) {
                $informasiModel->insert([
                    'yudisium_periode_id' => $periodeModel->getInsertID(),
                    'link' => $link,
                    'keterangan' => $data['keterangan'][$index],
                ]);
            }

        }

        $db->transComplete();

        return redirect()->to('/fakultas/periode-yudisium')->with('success', 'Periode berhasil disimpan');

    }

    public function pendaftaranYudisium()
    {
        // Pendaftaran Yudisium for fakultas
        return view('fakultas/pendaftaran_yudisium');
    }
}
