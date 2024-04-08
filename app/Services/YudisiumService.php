<?php

namespace App\Services;

use App\Entities\UserEntity;
use App\Entities\YudisiumPendaftaran;
use CodeIgniter\HTTP\Files\UploadedFile;

class YudisiumService
{
    public function __construct()
    {
        // ...
    }

    public function daftarYudisium(UserEntity $user, array $uploaded_files)
    {
        $this->checkSuratKeterangan($user);

        /** @var \App\Models\YudisiumPendaftaranModel $yudisiumPendaftaranModel */
        $yudisiumPendaftaranModel = model('YudisiumPendaftaranModel');

        $currentPeriode = $this->getCurrentPeriode();

        // Check if current periode is open
        if (! $currentPeriode?->isOpen()) {
            throw new \Exception('Pendaftaran yudisium belum dibuka.');
        }
        
        // Check if user can register for yudisium
        if (! $currentPeriode?->canDaftarYudisium($user->id)) {
            throw new \Exception('Tidak bisa mendaftar yudisium pada periode ini. Periode sudah ditutup atau sudah mendaftar sebelumnya.');
        }

        // $yudisiumPendaftaranModel->save([
        //     'id' => $user->yudisiumPendaftaran()?->id,
        //     'mahasiswa_id' => $user->id,
        //     'yudisium_periode_id' => $currentPeriode->id,
        //     'status' => STATUS_MENUNGGU_VALIDASI,
        // ]);

        $yudisiumPendaftaran = new YudisiumPendaftaran([
            'id' => $user->yudisiumPendaftaran()?->id,
            'tanggal_penerimaan' => date('Y-m-d H:i:s'),
            'mahasiswa_id' => $user->id,
            'yudisium_periode_id' => $currentPeriode->id,
            'status' => STATUS_MENUNGGU_VALIDASI,
        ]);

        $yudisiumPendaftaran->saveUploadedFiles($uploaded_files);

        $yudisiumPendaftaranModel->save($yudisiumPendaftaran);

        $yudisiumPendaftaran->generateSuratPdf();

        if ($yudisiumPendaftaranModel->errors()) {
            throw new \Exception($yudisiumPendaftaranModel->errors()[0]);
        }

        return true;
    }

    public function validasiPendaftaranYudisium(UserEntity $peninjau, YudisiumPendaftaran $yudisiumPendaftaran, array $data)
    {
        if ($yudisiumPendaftaran->status != STATUS_MENUNGGU_VALIDASI) {
            throw new \Exception('Pendaftaran yudisium sudah divalidasi.');
        }

        $yudisiumPendaftaran->terima($peninjau->id, $data['keterangan']);

        return true;
    }

    public function tolakPendaftaranYudisium(UserEntity $peninjau, YudisiumPendaftaran $yudisiumPendaftaran, array $data)
    {
        if ($yudisiumPendaftaran->status != STATUS_MENUNGGU_VALIDASI) {
            throw new \Exception('Pendaftaran yudisium sudah divalidasi.');
        }

        $yudisiumPendaftaran->tolak($peninjau->id, $data['keterangan']);

        return true;
    }

    public function getCurrentPeriode() : ?\App\Entities\YudisiumPeriode
    {
        /** @var \App\Models\YudisiumPeriodeModel $periodeModel */
        $periodeModel = model('YudisiumPeriodeModel');

        return $periodeModel->getCurrentPeriode();
    }

    public function checkSuratKeterangan($user)
    {
        if (!$this->checkSkBebasPerpustakaan($user)) {
            throw new \Exception('Surat Keterangan Bebas Perpustakaan belum SELESAI.');
        }
        
        if (!$this->checkSkBebasUkt($user)) {
            throw new \Exception('Surat Keterangan Bebas UKT belum SELESAI.');
        }

        if (!$this->checkSkBebasLab($user)) {
            throw new \Exception('Surat Keterangan Bebas Laboratorium belum SELESAI.');
        }
    }

    public function checkSkBebasPerpustakaan(UserEntity $user)
    {
        $sk = $user->suratKeteranganBebasPerpustakaan();

        return $sk?->isSelesai();
    }

    public function checkSkBebasUkt(UserEntity $user)
    {
        $sk = $user->suratKeteranganBebasUkt();

        return $sk?->isSelesai();
    }

    public function checkSkBebasLab(UserEntity $user)
    {
        $silabor = service('silabor');
        return $silabor->isBebasLabSelesai($user->nim);
    }
}