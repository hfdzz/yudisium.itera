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

            $perPage = $this->request->getGet('per_page') ?? 10;

            $latest_periode = model('YudisiumPeriodeModel')->getLatestPeriode();

            $db = db_connect();

            $sql = "select yudisium_pendaftaran.*,
                users.username as mahasiswa_nama, users.nim as mahasiswa_nim, users.program_studi as mahasiswa_prodi,
                skbp.id as skbp_id, skbu.id as skbu_id, skbu.berkas_ba_sidang as skbu_berkas_ba_sidang, skbu.status as skbu_status
            from
                yudisium_pendaftaran left join users on yudisium_pendaftaran.mahasiswa_id = users.id,
                surat_keterangan skbp, surat_keterangan skbu
            where yudisium_pendaftaran.yudisium_periode_id = :periode_id: and yudisium_pendaftaran.status = :status:
            and skbp.mahasiswa_id = yudisium_pendaftaran.id and skbp.jenis_surat = \"sk_bebas_perpustakaan\" and skbu.jenis_surat = \"sk_bebas_ukt\" and skbp.mahasiswa_id = skbu.mahasiswa_id
            order by yudisium_pendaftaran.tanggal_daftar desc";

            $pendaftaran = $db->query($sql, ['periode_id' => $latest_periode?->id, 'status' => STATUS_MENUNGGU_VALIDASI]);

            $data = [
                'pendaftaran' => $pendaftaran->getResult(),
                'latest_periode' => $latest_periode,
            ];

            return view('fakultas/validasi_yudisium', $data);
        }

        /** @var \App\Models\YudisiumPendaftaranModel $yudisiumPendaftaranModel */
        $yudisiumPendaftaranModel = model('YudisiumPendaftaranModel');

        $data = $this->request->getPost();

        $yudisiumPendaftaran = $yudisiumPendaftaranModel->where('id', $data['id'])->first();

        if (! $yudisiumPendaftaran) {
            return redirect()->to('/fakultas/validasi-yudisium')->with('error', 'Pendaftaran yudisium tidak ditemukan');
        }

        $yudisium = new \App\Services\YudisiumService();

        try{
            if ($data['action'] == 'validasi') {
                $yudisium->validasiPendaftaranYudisium(
                    auth()->user(),
                    $yudisiumPendaftaran,
                    $data
                );
            }
            else if ($data['action'] == 'tolak') {
                $yudisium->tolakPendaftaranYudisium(
                    auth()->user(),
                    $yudisiumPendaftaran,
                    $data
                );
            }
            else {
                throw new \Exception('Invalid action');
            }
        }
        catch (\Exception $e) {
            return redirect()->to('/fakultas/validasi-yudisium')->with('error', $e->getMessage());
        }
        return redirect()->to('/fakultas/validasi-yudisium')->with('success', 'Pendaftaran yudisium berhasil ' . ($data['action'] == 'validasi' ? 'diterima' : 'ditolak'));
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

        // tanggal_awal has to be before tanggal_akhir
        if ($data['tanggal_awal'] > $data['tanggal_akhir']) {
            return redirect()->to('/fakultas/periode-yudisium')->with('error', 'Tanggal awal harus sebelum tanggal akhir');
        }
        // tanggal_yudisium has to be greater than tanggal_akhir
        if ($data['tanggal_yudisium'] < $data['tanggal_akhir']) {
            return redirect()->to('/fakultas/periode-yudisium')->with('error', 'Tanggal yudisium harus setelah tanggal akhir');
        }
    
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
            // $periodeModel->update($data['id'], [
            //     'periode' => $periodeModel->find($data['id'])->periode,
            //     'tanggal_awal' => $data['tanggal_awal'],
            //     'tanggal_akhir' => $data['tanggal_akhir'],
            // ]);
            $periodeModel->save([
                'id' => $data['id'],
                'periode' => $periodeModel->find($data['id'])->periode,
                'tanggal_yudisium' => $data['tanggal_yudisium'],
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
            // foreach ($data['link_grup_whatsapp'] as $index => $link) {
            //     $informasiModel->insert([
            //         'link_grup_whatsapp' => $link,
            //         'keterangan' => $data['keterangan'][$index],
            //         'yudisium_periode_id' => $periodeId,
            //     ]);
            // }
            $informasiModel->insertBatch(
                array_map(function($link, $keterangan) use ($periodeId) {
                    return [
                        'link_grup_whatsapp' => $link,
                        'keterangan' => $keterangan,
                        'yudisium_periode_id' => $periodeId,
                    ];
                }, $data['link_grup_whatsapp'], $data['keterangan'])
            );
        }

        $db->transComplete();

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
