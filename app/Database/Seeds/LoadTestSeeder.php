<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LoadTestSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $faker->seed(1234);

        // truncate all tables with foreign key check disabled
        $this->db->disableForeignKeyChecks();
        $this->db->table('users')->truncate();
        $this->db->table('auth_groups_users')->truncate();
        $this->db->table('auth_identities')->truncate();
        $this->db->table('yudisium_pendaftaran')->truncate();
        $this->db->table('surat_keterangan')->truncate();
        $this->db->table('yudisium_periode')->truncate();
        $this->db->table('yudisium_periode_informasi')->truncate();
        $this->db->enableForeignKeyChecks();

        /**
         * ==============================
         * UserSeeder
         * ==============================
         */

        //  user_mahasiswa
        
        // admin

        // user_fakultas
        for ($i = 0; $i < 3; $i++) {
            $data = [
                'id' => $i + 200,
                'username' => 'fakultas' . $i,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => 'fakultas' . $i . '@test.com',
                'nip' => '110' . $faker->unique()->randomNumber(9),
            ];

            $this->db->table('users')->insert([
                'id' => $data['id'],
                'username' => $data['username'],
                'nip' => $data['nip'],
            ]);

            $this->db->table('auth_groups_users')->insert([
                'id' => $data['id'],
                'user_id' => $data['id'],
                'group' => 'user_fakultas'
            ]);

            $this->db->table('auth_identities')->insert([
                'id' => $data['id'],
                'user_id' => $data['id'],
                'type' => 'email_password',
                'secret' => $data['email'],
                'secret2' => $data['password'],
            ]);
        }

        // user_upt_perpustakaan
        for ($i = 0; $i < 3; $i++) {
            $data = [
                'id' => $i + 300,
                'username' => 'upt_perpustakaan' . $i,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => 'upt_perpustakaan' . $i . '@test.com',
                'nip' => '110' . $faker->unique()->randomNumber(9),
            ];

            $this->db->table('users')->insert([
                'id' => $data['id'],
                'username' => $data['username'],
                'nip' => $data['nip'],
            ]);

            $this->db->table('auth_groups_users')->insert([
                'id' => $data['id'],
                'user_id' => $data['id'],
                'group' => 'user_upt_perpustakaan'
            ]);

            $this->db->table('auth_identities')->insert([
                'id' => $data['id'],
                'user_id' => $data['id'],
                'type' => 'email_password',
                'secret' => $data['email'],
                'secret2' => $data['password'],
            ]);
        }

        // user_keuangan
        for ($i = 0; $i < 3; $i++) {
            $data = [
                'id' => $i + 400,
                'username' => 'keuangan' . $i,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => 'keuangan' . $i . '@test.com',
                'nip' => '110' . $faker->unique()->randomNumber(9),
            ];

            $this->db->table('users')->insert([
                'id' => $data['id'],
                'username' => $data['username'],
                'nip' => $data['nip'],
            ]);

            $this->db->table('auth_groups_users')->insert([
                'id' => $data['id'],
                'user_id' => $data['id'],
                'group' => 'user_keuangan'
            ]);

            $this->db->table('auth_identities')->insert([
                'id' => $data['id'],
                'user_id' => $data['id'],
                'type' => 'email_password',
                'secret' => $data['email'],
                'secret2' => $data['password'],
            ]);
        }

        /**
         * ==============================
         * YudisiumPeriodeSeeder
         * ==============================
         */

        $this->db->table('yudisium_periode')->insert([
            'id' => 1,
            'periode' => 'Januari/2024',
            // date now and 7 days later
            'tanggal_awal' => date('Y-m-d'),
            'tanggal_akhir' => date('Y-m-d', strtotime('+7 days')),
        ]);

        /**
         * ==============================
         * YudisiumPeriodeInformasiSeeder
         * ==============================
         */

        // 1st periode
        $this->db->table('yudisium_periode_informasi')->insert([
            'id' => 1,
            'yudisium_periode_id' => 1,
            'link_grup_whatsapp' => $faker->unique()->url,
            'keterangan' => 'link grup untuk program studi ' . 1 . '.',
        ]);
        $this->db->table('yudisium_periode_informasi')->insert([
            'id' => 2,
            'yudisium_periode_id' => 1,
            'link_grup_whatsapp' => $faker->unique()->url,
            'keterangan' => 'link grup untuk program studi ' . 2 . '.',
        ]);
        $this->db->table('yudisium_periode_informasi')->insert([
            'id' => 3,
            'yudisium_periode_id' => 1,
            'link_grup_whatsapp' => $faker->unique()->url,
            'keterangan' => 'link grup untuk program studi ' . 3 . '.',
        ]);
        
        // insert created_at and updated_at for all tables
        $this->db->table('users')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        $this->db->table('auth_groups_users')->update(['created_at' => date('Y-m-d H:i:s')]);
        $this->db->table('auth_identities')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        // $this->db->table('yudisium_pendaftaran')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        // $this->db->table('surat_keterangan')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        $this->db->table('yudisium_periode')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        $this->db->table('yudisium_periode_informasi')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
    }
}
