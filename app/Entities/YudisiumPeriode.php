<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class YudisiumPeriode extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getInformasi()
    {
        return model('YudisiumPeriodeInformasiModel')->where('yudisium_periode_id', $this->attributes['id'])->first();
    }

    
}
