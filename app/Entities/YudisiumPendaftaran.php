<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class YudisiumPendaftaran extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getMahasiswa()
    {
        return model('UserModel')->where('id', $this->attributes['mahasiswa_id'])->first();
    }

    public function getPeninjau()
    {
        return model('UserModel')->where('id', $this->attributes['peninjau_id'])->first();
    }

    public function getYudisiumPeriode()
    {
        return model('YudisiumPeriodeModel')->where('id', $this->attributes['yudisium_periode_id'])->first();
    }

    public function getStatusText()
    {
        switch ($this->attributes['status']) {
            case STATUS_MENUNGGU_VALIDASI:
                return 'Menunggu Validasi';
            case STATUS_SELESAI:
                return 'Selesai';
            case STATUS_DITOLAK:
                return 'Ditolak';
            default:
                return 'STATUS ERROR';
        }
    }

    public function updateStatus($status, $peninjau_id, $keterangan = null)
    {
        $model = model('YudisiumPendaftaranModel');
        $this->attributes['status'] = $status;
        $this->attributes['peninjau_id'] = $peninjau_id;
        $this->attributes['keterangan'] = $keterangan;
        $model->save($this);

        return $this;
    }

    public function terima($peninjau_id, $keterangan = null)
    {
        return $this->updateStatus(STATUS_SELESAI, $peninjau_id, $keterangan);
    }

    public function tolak($peninjau_id, $keterangan = null)
    {
        return $this->updateStatus(STATUS_DITOLAK, $peninjau_id, $keterangan);
    }

    // Update from peninjau's CRUD
    public function updateWithPeninjauId($data, $peninjau_id)
    {
        $model = model('YudisiumPendaftaranModel');
        $this->fill($data);
        $this->attributes['peninjau_id'] = $peninjau_id;
        $model->save($this);

        return $this;
    }

    public function canDafarYudisium()
    {
        return $this->attributes['status'] == null || $this->attributes['status'] == STATUS_DITOLAK;
    }

    
}