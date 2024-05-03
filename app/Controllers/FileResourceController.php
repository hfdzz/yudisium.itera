<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class FileResourceController extends BaseController
{
    public function berkasBebasUkt($sk_id, $jenis_berkas)
    {
        $user = auth()->user();

        $suratKeteranganModel = model('SuratKeteranganModel');
        
        $suratKeterangan = $suratKeteranganModel->find($sk_id);
        
        if (! $suratKeterangan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // if (! $user->can('keuangan.validasi_sk_bebas_ukt'))
        // {
        //     if ($suratKeterangan->mahasiswa_id != $user->id) {
        //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        //     }
        // }

        $file_path = WRITEPATH . 'uploads/' . $suratKeterangan->getBerkasPath($jenis_berkas);

        if (! file_exists($file_path) || ! is_file($file_path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->download($file_path, null, true)
        ->inline();
    }
    
    public function fileSuratKeterangan($sk_id)
    {
        $force_generate = $this->request->getGet('force_generate') == '1';
        $user = auth()->user();

        $suratKeteranganModel = model('SuratKeteranganModel');
        
        /** @var \App\Entities\SuratKeterangan $suratKeterangan */
        $suratKeterangan = $suratKeteranganModel->find($sk_id);
        
        if (! $suratKeterangan ||
            ! $suratKeterangan->isSelesai()
            ) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // if ($user->inGroup('user_mahasiswa'))
        // {
        //     if ($suratKeterangan->mahasiswa_id != $user->id) {
        //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        //     }
        // }

        // $file_path = WRITEPATH . 'generated_files/' . $suratKeterangan->file_surat_keterangan;
        $file_path = $suratKeterangan->getSuratKeteranganPdf($force_generate);

        // dd($file_path);

        if (! file_exists($file_path) || ! is_file($file_path)) {
            // $file_path = $suratKeterangan->getSuratKeteranganPdf($force_generate);
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File not found');
        }

        return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->download($file_path, null, true)
        ->inline();
    }

    public function berkasPendaftaranYudisium($yudisium_pendaftaran_id, $jenis_berkas)
    {
        $user = auth()->user();

        $yudisiumPendaftaranModel = model('YudisiumPendaftaranModel');
        
        $yudisiumPendaftaran = $yudisiumPendaftaranModel->find($yudisium_pendaftaran_id);
        
        if (! $yudisiumPendaftaran) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // if (! $user->can('fakultas.validasi_yudisium'))
        // {
        //     if ($yudisiumPendaftaran->mahasiswa_id != $user->id) {
        //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        //     }
        // }

        $file_path = WRITEPATH . 'uploads/' . $yudisiumPendaftaran->getBerkasPath($jenis_berkas);

        if (! file_exists($file_path) || ! is_file($file_path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->download($file_path, null, true)
        ->inline();
    }

    public function fileTandaTerimaYudisium($yudisium_pendaftaran_id)
    {
        // $fmt = new \IntlDateFormatter('id_ID');
        // $fmt->setPattern('d MMMM Y');
        // return $fmt->format(new \DateTime('2024-04-04'));
        $force_generate = $this->request->getGet('force_generate') == '1';
        $user = auth()->user();

        $yudisiumPendaftaranModel = model('YudisiumPendaftaranModel');
        
        /** @var \App\Entities\YudisiumPendaftaran $yudisiumPendaftaran */
        $yudisiumPendaftaran = $yudisiumPendaftaranModel->find($yudisium_pendaftaran_id);
        
        if (! $yudisiumPendaftaran ||
            ! $yudisiumPendaftaran->isSelesai()
            ) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // if (! $user->can('fakultas.validasi_yudisium'))
        // {
        //     if ($yudisiumPendaftaran->mahasiswa_id != $user->id) {
        //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        //     }
        // }

        // $file_path = WRITEPATH . 'generated_files/' . $yudisiumPendaftaran->file_tanda_terima_yudisium;
        
        $file_path = $yudisiumPendaftaran->getTandaTerimaPdf($force_generate);

        if (! file_exists($file_path) || ! is_file($file_path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File not found');
        }

        return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->download($file_path, null, true)
        ->inline();
    }
}