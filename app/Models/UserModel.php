<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\UserEntity;
use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected function initialize(): void
    {
        parent::initialize();

        $this->allowedFields = [
            ...$this->allowedFields,

            'nim',
            'program_studi',
            'nip',
            
        ];

        // $this->returnType = 'App\Entities\UserEntity';
    }

    protected $returnType = 'App\Entities\UserEntity';

    public function findOrCreateMahasiswa($nim, $username, $programStudi): UserEntity
    {
        $user = $this->where('nim', $nim)->first();

        if ($user) {
            return $user;
        }

        $this->save([
            'nim' => $nim,
            'username' => $username,
            'program_studi' => $programStudi,
        ]);

        $user = $this->where('nim', $nim)->first();
        $user->addGroup('user_mahasiswa');

        return $user;
    }
}
