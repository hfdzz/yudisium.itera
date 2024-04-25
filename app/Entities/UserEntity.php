<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User;

class UserEntity extends User
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    // protected function getSuratKeterangan($jenis_surat)
    // {
    //     $sk_model = model('SuratKeteranganModel');

    //     return $sk_model->getSuratKeterangan($this->attributes['id'], $jenis_surat);
    // }

    public function suratKeteranganBebasPerpustakaan() : ?\App\Entities\SuratKeterangan
    {
        /**
         * @var \App\Models\SuratKeteranganModel $model
         */
        $model = model('SuratKeteranganModel');

        return $model->getSkBebasPerpustakaan($this->attributes['id']);
    }

    public function suratKeteranganBebasUkt() : ?\App\Entities\SuratKeterangan
    {
        /**
         * @var \App\Models\SuratKeteranganModel $model
         */
        $model = model('SuratKeteranganModel');

        return $model->getSkBebasUkt($this->attributes['id']);
    }

    public function suratKeteranganBebasLaboratorium() : ?\App\Services\SkBebasLaboratorium
    {
        /** @var \App\Services\SILABORService $service */
        $service = service('silabor');

        return $service->getLatestBebasLabByNim($this->attributes['nim']);
    }

    public function yudisiumPendaftaran() : ?\App\Entities\YudisiumPendaftaran
    {
        $yudisium_pendaftaran_model = model('YudisiumPendaftaranModel');

        return $yudisium_pendaftaran_model->where('mahasiswa_id', $this->attributes['id'])
            ->first();
    }

    public function latestBebasLab()
    {
        $service = service('silabor');

        return $service->getLatestBebasLabByNim($this->attributes['nim']);
    }

    public function canDaftarYudisium()
    {
        /** @var \App\Models\YudisiumPeriodeModel $yudisiumPeriodeModel */
        $yudisiumPeriodeModel = model('YudisiumPeriodeModel');
        
        /** @var \App\Entities\YudisiumPeriode $currentPeriode */
        $currentPeriode = $yudisiumPeriodeModel->getCurrentPeriode();

        return $currentPeriode && $currentPeriode->canDaftarYudisium($this->attributes['id']);
    }
}