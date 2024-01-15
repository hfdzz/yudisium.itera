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
        return model('MahasiswaModel')->where('id', $this->attributes['mahasiswa_id'])->first();
    }

    public function getPeninjau()
    {
        return model('UserModel')->where('id', $this->attributes['peninjau_id'])->first();
    }

    public function getYudisiumPeriode()
    {
        return model('YudisiumPeriodeModel')->where('id', $this->attributes['yudisium_periode_id'])->first();
    }


}
