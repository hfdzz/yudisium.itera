<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class SuratKeterangan extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getMahasiswa() : ?\App\Entities\UserEntity
    {
        $user_model = model('UserModel');

        return $user_model->where('id', $this->attributes['mahasiswa_id'])
            ->first();
    }

    public function getPeninjau() : ?\App\Entities\UserEntity
    {
        $user_model = model('UserModel');

        return $user_model->where('id', $this->attributes['peninjau_id'])
            ->first();
    }

    public function getStatus($humanize = false) : string
    {
        if ($humanize) {
            switch ($this->attributes['status']) {
                case STATUS_MENUNGGU_VALIDASI:
                    return 'Menunggu Validasi';
                case STATUS_SELESAI:
                    return 'Selesai';
                case STATUS_DITOLAK:
                    return 'Ditolak';
                case STATUS_SELESAI_BEASISWA:
                    return 'Selesai (Beasiswa)';
            }
        }

        return $this->attributes['status'];
    }

    public function isSelesai() : bool
    {
        return $this->attributes['status'] == STATUS_SELESAI;
    }

    public function isBeasiswa() : bool
    {
        return $this->attributes['jenis_surat'] == JENIS_SK_BEBAS_UKT && $this->attributes['status'] == STATUS_SELESAI_BEASISWA;
    }

    public function isSelesaiOrBeasiswa() : bool
    {
        return $this->isSelesai() || $this->isBeasiswa();
    }

    public function canAjukan() : bool
    {
        return !$this->isSelesaiOrBeasiswa();
    }

    public function validasi($peninjau_id, $nomor_surat, $keterangan = null)
    {
        $this->attributes['peninjau_id'] = $peninjau_id;
        $this->attributes['nomor_surat'] = $nomor_surat;
        $this->attributes['status'] = STATUS_SELESAI;
        $this->attributes['keterangan'] = $keterangan;
        $this->attributes['tanggal_terbit'] = date('Y-m-d');

        return model('SuratKeteranganModel')->save($this);
    }

    public function tolak($peninjau_id, $keterangan = null)
    {
        $this->attributes['peninjau_id'] = $peninjau_id;
        $this->attributes['status'] = STATUS_DITOLAK;
        $this->attributes['keterangan'] = $keterangan;

        return model('SuratKeteranganModel')->save($this);
    }

    public function validasiBeasiswa($peninjau_id, $nomor_surat = null, $keterangan = null)
    {
        $this->attributes['peninjau_id'] = $peninjau_id;
        $this->attributes['nomor_surat'] = $nomor_surat;
        $this->attributes['status'] = STATUS_SELESAI_BEASISWA;
        $this->attributes['keterangan'] = $keterangan;

        return model('SuratKeteranganModel')->save($this);
    }

    public function saveFiles(array $files)
    {
        foreach ($files as $file) {
            $this->uploadFile($file);
        }
    }

    public function deleteFile()
    {
        // $path = $this->getCurrentUploadFilePath($this->attributes['jenis_surat']);
        // $file = $path . '/' . $this->attributes['file'];
        // if (file_exists($file)) {
        //     unlink($file);
        // }
    }

    public function getFilePath()
    {
        // return $this->getCurrentUploadFilePath($this->attributes['jenis_surat']) . '/' . $this->attributes['file'];
    }
}
