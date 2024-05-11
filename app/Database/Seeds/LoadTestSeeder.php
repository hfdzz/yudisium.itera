<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LoadTestSeeder extends Seeder
{
    public function run()
    {
        $start_time = microtime(true);
        define('MAHASISWA_USER_AMOUNT', 100);
        define('PRODI_LIST', ['Teknik Informatika', 'Sistem Informasi', 'Teknik Elektro']);

        define('VALIDATOR_USER_AMOUNT', 3);
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
        define('BASE_NIM', 120140001);
        for ($i = 0; $i < MAHASISWA_USER_AMOUNT; $i++) {
            $this->create_user([
                'id' => $i,
                'username' => 'mahasiswa' . $i,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => 'mahasiswa' . $i . '@test.com',
                'nim' => (BASE_NIM + $i),
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

        /**
         * ==============================
         * YudisiumPeriodeSeeder
         * ==============================
         */

        $this->db->table('yudisium_periode')->insert([
            'id' => 1,
            'periode' => 'TEST/2024',
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

        /**
         * ==============================
         * YudisiumPendaftaranSeeder
         * ==============================
         */

        // for ($i = 0; $i < MAHASISWA_USER_AMOUNT; $i++) {
        //     $this->db->table('yudisium_pendaftaran')->insert([
        //         'id' => $i,
        //         'mahasiswa_id' => $i,
        //         'yudisium_periode_id' => 1,
        //         'status' => STATUS_SELESAI,
        //     ]);
        // }

        /**
         * ==============================
         * SuratKeteranganSeeder
         * ==============================
         */

        // Surat Keterangan Bebas Perpustakaan

        for ($i = 0; $i < MAHASISWA_USER_AMOUNT; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 1,
                'mahasiswa_id' => $i + 1,
                'jenis_surat' => JENIS_SK_BEBAS_PERPUSTAKAAN,
                'status' => STATUS_SELESAI,
                'tanggal_pengajuan' => date('Y-m-d', strtotime('-3 days')),
                'tanggal_terbit' => date('Y-m-d', strtotime('-1 days')),
                'nomor_surat' => 'SK-BEBAS-PERPUS/' . date('Y') . '/' . $i,
                'peninjau_id' => ($i % VALIDATOR_USER_AMOUNT) + UPT_PERPUSTAKAAN_ID_START + 1,
            ]);
        }

        // Surat Keterangan Bebas UKT

        for ($i = 0; $i < MAHASISWA_USER_AMOUNT; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + MAHASISWA_USER_AMOUNT + 1,
                'mahasiswa_id' => $i + 1,
                'jenis_surat' => JENIS_SK_BEBAS_UKT,
                'status' => STATUS_SELESAI,
                'tanggal_pengajuan' => date('Y-m-d', strtotime('-3 days')),
                'tanggal_terbit' => date('Y-m-d', strtotime('-1 days')),
                'nomor_surat' => 'SK-BEBAS-UKT/' . date('Y') . '/' . $i,
                'peninjau_id' => ($i % VALIDATOR_USER_AMOUNT) + KEUANGAN_ID_START + 1,
            ]);
        }
        
        // insert created_at and updated_at for all tables
        $this->db->table('users')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        $this->db->table('auth_groups_users')->update(['created_at' => date('Y-m-d H:i:s')]);
        $this->db->table('auth_identities')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        // $this->db->table('yudisium_pendaftaran')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        // $this->db->table('surat_keterangan')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        $this->db->table('yudisium_periode')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        $this->db->table('yudisium_periode_informasi')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

        $this->requirement_check();

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

    protected function requirement_check() : void
    {
        /**
         * Prodi should be divided evenly (with reminder considered)
         */
        $reminder = MAHASISWA_USER_AMOUNT % count(PRODI_LIST);
        foreach (PRODI_LIST as $index => $prodi) {
            $count = $this->db->table('users')->where('program_studi', $prodi)->countAllResults();
            $this_remainder = $index < $reminder ? 1 : 0;
            if ($count !== (int)(MAHASISWA_USER_AMOUNT / count(PRODI_LIST)) + $this_remainder) {
                throw new \Exception('Prodi ' . $prodi . ' should have ' . (int)(MAHASISWA_USER_AMOUNT / count(PRODI_LIST)) + $this_remainder . ' users, but got ' . $count . ' users.');
            }
        }

        /**
         * Pendaftaran yudisium inner join with users should have the same amount of users as MAHASISWA_USER_AMOUNT
         */
        // $count = $this->db->table('yudisium_pendaftaran')->where('status', STATUS_SELESAI)->join('users', 'users.id = yudisium_pendaftaran.mahasiswa_id', 'inner')->countAllResults();
        // if ($count !== MAHASISWA_USER_AMOUNT) {
        //     throw new \Exception('Pendaftaran yudisium should have ' . MAHASISWA_USER_AMOUNT . ' users, but got ' . $count . ' users.');
        // }

        /**
         * Surat keterangan Bebas Perpustakaan inner join with users should have the same amount of users as MAHASISWA_USER_AMOUNT
         */
        $count = $this->db->table('surat_keterangan')->where('jenis_surat', JENIS_SK_BEBAS_PERPUSTAKAAN)->where('surat_keterangan.status', STATUS_SELESAI)->join('users', 'users.id = surat_keterangan.mahasiswa_id', 'inner')->countAllResults();
        if ($count !== MAHASISWA_USER_AMOUNT) {
            throw new \Exception('Surat keterangan Bebas Perpustakaan should have ' . MAHASISWA_USER_AMOUNT . ' users, but got ' . $count . ' users.');
        }

        // Surat keterangan Bebas Keuangan inner join with users should have the same amount of users as MAHASISWA_USER_AMOUNT
        $count = $this->db->table('surat_keterangan')->where('jenis_surat', JENIS_SK_BEBAS_UKT)->where('surat_keterangan.status', STATUS_SELESAI)->join('users', 'users.id = surat_keterangan.mahasiswa_id', 'inner')->countAllResults();
        if ($count !== MAHASISWA_USER_AMOUNT) {
            throw new \Exception('Surat keterangan Bebas Keuangan should have ' . MAHASISWA_USER_AMOUNT . ' users, but got ' . $count . ' users.');
        }
        
    }
}
