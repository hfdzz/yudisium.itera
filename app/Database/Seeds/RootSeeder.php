<?php

namespace App\Database\Seeds;

use App\Entities\UserEntity;
use CodeIgniter\Database\Seeder;

class RootSeeder extends Seeder
{
    public function run()
    {
        // Create Super Admin
        /** @var \App\Models\UserModel $userProvider */
        $userProvider = auth()->getProvider();
        
        $newUser = new UserEntity([
            'username' => 'superadmin',
            'email' => 'superadmin@root.test',
            'password' => 'root',
        ]);
        $userProvider->save($newUser);

        $newUser = $userProvider->findById($userProvider->getInsertID());

        // Add to Super Admin group
        $newUser->addGroup('superadmin');
    }
}
