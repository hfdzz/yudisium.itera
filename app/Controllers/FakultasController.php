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

        // dd($this->request->getPost());
        // Save periode yudisium

        $data = $this->request->getPost();

        $db = \Config\Database::connect();

        $informasiModel = model('YudisiumPeriodeInformasiModel');
        
        if (!$data['id']) {
            $periodeModel->openNewPeriode($data);
        }
        
        $periodeId = $data['id'] ?? $periodeModel->getInsertID();
        
        $yudisiumPeriode = $periodeModel->find($periodeId);
        
        $db->transStart();

        $yudisiumPeriode->clearInformasi();

        $periodeModel->update($periodeId, [
            'periode' => $data['periode'] ?? $yudisiumPeriode->periode,
            'tanggal_awal' => $data['tanggal_awal'],
            'tanggal_akhir' => $data['tanggal_akhir'],
        ]);

        foreach ($data['link_grup_whatsapp'] as $index => $link) {
            $informasiModel->insert([
                'link_grup_whatsapp' => $link,
                'keterangan' => $data['keterangan'][$index],
                'yudisium_periode_id' => $periodeId,
            ]);
        }

        $db->transComplete();

        return redirect()->to('/fakultas/periode-yudisium')->with('success', 'Periode berhasil disimpan');
    }

    public function newPeriodeYudisium()
    {
        if (! $this->request->is('post')) {
            return view('fakultas/new_periode_yudisium');
        }
    }
}
