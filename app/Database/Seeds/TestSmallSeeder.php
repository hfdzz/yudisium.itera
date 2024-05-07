<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestSmallSeeder extends Seeder
{
    public function run()
    {
        $start_time = microtime(true);
        define('MAHASISWA_USER_AMOUNT', 0);
        define('PRODI_LIST', ['Teknik Informatika', 'Sistem Informasi', 'Teknik Elektro']);

        define('VALIDATOR_USER_AMOUNT', 1);
        define('FAKULTAS_ID_START', MAHASISWA_USER_AMOUNT);
        define('UPT_PERPUSTAKAAN_ID_START', MAHASISWA_USER_AMOUNT + VALIDATOR_USER_AMOUNT);
        define('KEUANGAN_ID_START', MAHASISWA_USER_AMOUNT + VALIDATOR_USER_AMOUNT*2);

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
        // predefined mahasiswa (for pendafataran yudisium testing)
        for ($i = 0; $i < MAHASISWA_USER_AMOUNT; $i++) {
            $this->create_user([
                'id' => $i,
                'username' => 'mahasiswa' . $i,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => 'mahasiswa' . $i . '@test.com',
                'nim' => $faker->unique()->randomNumber(9),
                'program_studi' => PRODI_LIST[$i % count(PRODI_LIST)],
                'group' => 'user_mahasiswa',
            ]);
        }

        // user_fakultas
        for ($i = 0; $i < VALIDATOR_USER_AMOUNT; $i++) {
            $this->create_user([
                'id' => $i + MAHASISWA_USER_AMOUNT,
                'username' => 'fakultas' . $i,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => 'fakultas' . $i . '@test.com',
                'nip' => '311' . $faker->unique()->randomNumber(9),
                'group' => 'user_fakultas',
            ]);
        }

        // user_upt_perpustakaan
        for ($i = 0; $i < VALIDATOR_USER_AMOUNT; $i++) {
            $this->create_user([
                'id' => $i + VALIDATOR_USER_AMOUNT + MAHASISWA_USER_AMOUNT,
                'username' => 'upt_perpustakaan' . $i,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => 'upt_perpustakaan' . $i . '@test.com',
                'nip' => '522' . $faker->unique()->randomNumber(9),
                'group' => 'user_upt_perpustakaan',
            ]);
        }

        // user_keuangan
        for ($i = 0; $i < VALIDATOR_USER_AMOUNT; $i++) {
            $this->create_user([
                'id' => $i + VALIDATOR_USER_AMOUNT*2 + MAHASISWA_USER_AMOUNT,
                'username' => 'keuangan' . $i,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => 'keuangan' . $i . '@test.com',
                'nip' => '733' . $faker->unique()->randomNumber(9),
                'group' => 'user_keuangan',
            ]);
        }
        
        // insert created_at and updated_at for all tables
        $this->db->table('users')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        $this->db->table('auth_groups_users')->update(['created_at' => date('Y-m-d H:i:s')]);
        $this->db->table('auth_identities')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        // $this->db->table('yudisium_pendaftaran')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        // $this->db->table('surat_keterangan')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        // $this->db->table('yudisium_periode')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        // $this->db->table('yudisium_periode_informasi')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

        $end_time = microtime(true);
        // Round execution time to 4 decimal places
        $execution_time = round($end_time - $start_time, 4);
        echo 'Execution time: ' . $execution_time . ' seconds' . PHP_EOL;
    }

    protected function create_user(array $data, bool $authable = true) : void
    {
        $data['id'] = $data['id']+=1 ?? 1;
        $this->db->table('users')->insert([
            'id' => $data['id'],
            'username' => $data['username'],
            'nim' => $data['nim'] ?? null,
            'program_studi' => $data['program_studi'] ?? null,
            'nip' => $data['nip'] ?? null,
        ]);

        $this->db->table('auth_groups_users')->insert([
            'id' => $data['id'],
            'user_id' => $data['id'],
            'group' => $data['group']
        ]);

        if ($authable) {
            $this->db->table('auth_identities')->insert([
                'id' => $data['id'],
                'user_id' => $data['id'],
                'type' => 'email_password',
                'secret' => $data['email'],
                'secret2' => $data['password'],
            ]);
        }
    }
}
