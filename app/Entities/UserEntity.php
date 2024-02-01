<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User;

class UserEntity extends User
{
    // protected $datamap = [];
    // protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    // protected $casts   = [];

    public function getSuratKeterangan($jenis_surat) : ?\App\Entities\SuratKeterangan
    {
        $sk_model = model('SuratKeteranganModel');

        $surat_keterangan = $sk_model->where('jenis_surat', $jenis_surat)
            ->where('mahasiswa_id', $this->attributes['id'])
            ->first();

        if (! $surat_keterangan) {
            return null;
        }

        return $surat_keterangan;
    }

    public function getPendaftaranYudisium()
    {
        $yudisium_pendaftaran_model = model('YudisiumPendaftaranModel');

        $yudisium_pendaftaran = $yudisium_pendaftaran_model->where('mahasiswa_id', $this->attributes['id'])
            ->first();

        if (! $yudisium_pendaftaran) {
            return null;
        }

        return $yudisium_pendaftaran;
    }
}