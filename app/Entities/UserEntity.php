<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User;

class UserEntity extends User
{
    // protected $datamap = [];
    // protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    // protected $casts   = [];

    public function getSuratKeterangan($jenis_surat)
    {
        $surat_keterangan = $this->surat_keterangan->where('jenis_surat', $jenis_surat)->first();

        if (! $surat_keterangan) {
            return null;
        }

        return $surat_keterangan;
    }

    public function getPendaftaranYudisium()
    {
        $yudisium_pendaftaran = $this->yudisium_pendaftaran->first();

        if (! $yudisium_pendaftaran) {
            return null;
        }

        return $yudisium_pendaftaran;
    }
}