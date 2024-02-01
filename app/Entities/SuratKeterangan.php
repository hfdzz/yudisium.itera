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

        $mahasiswa = $user_model->where('id', $this->attributes['mahasiswa_id'])
            ->first();

        if (! $mahasiswa) {
            return null;
        }

        return $mahasiswa;
    }

    public function getPeninjau() : ?\App\Entities\UserEntity
    {
        $user_model = model('UserModel');

        $peninjau = $user_model->where('id', $this->attributes['peninjau_id'])
            ->first();

        if (! $peninjau) {
            return null;
        }

        return $peninjau;
    }

    
}
