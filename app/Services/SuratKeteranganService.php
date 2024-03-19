<?php

namespace App\Services;
use App\Entities\SuratKeterangan;
use App\Entities\UserEntity;

class SuratKeteranganService
{
    public function __construct()
    {
        // ...
    }

    public function ajukanSuratKeterangan($user, $data)
    {
        // ...
    }

    public function validasiSuratKeterangan($peninjau, SuratKeterangan $suratKeterangan, array $data)
    {
        $suratKeterangan->validasi($peninjau, $data['nomor_surat'], $data['keterangan']);
    }

    public function validasiBeasiswaSuratKeterangan($peninjau, SuratKeterangan $suratKeterangan, $data)
    {
        $suratKeterangan->validasiBeasiswa($peninjau, $data['nomor_surat'], $data['keterangan']);
    }

    public function tolakSuratKeterangan($peninjau, SuratKeterangan $suratKeterangan, $data)
    {
        $suratKeterangan->tolak($peninjau, $data['keterangan']);
    }

    public function generateSuratKeterangan($suratKeterangan) : string
    {
        $dompdf = new \Dompdf\Dompdf();

        
    }

    public function getSuratKeteranganPdf($id)
    {
        // ...
    }
}