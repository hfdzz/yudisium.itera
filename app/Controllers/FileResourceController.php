<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Exception;

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

        if (! $user->can('keuangan.validasi_sk_bebas_ukt'))
        {
            if ($suratKeterangan->mahasiswa_id != $user->id) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }

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

        $file_path = WRITEPATH . 'generated_files/' . $suratKeterangan->file_surat_keterangan;

        // dd($file_path);

        if (! file_exists($file_path) || ! is_file($file_path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->download($file_path, null, true)
        ->inline();
    }
}