<?php

namespace App\Database\Seeds;

use App\Entities\UserEntity;
use CodeIgniter\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
         * WARNING: This seeder will truncate the users, auth_groups_users, yudisium_pendaftaran, surat_keterangan, yudisium_periode, and yudisium_periode_informasi tables.
         * 
         * TestSeeder
         * 
         * This is a test seeder file. You can use this file to seed your database with test data.
         * 
         * UserSeeder:
         * 1. 60 mahaasiswa user (5 auth-able)
         * 2. 5 admin user (3 auth-able)
         * 3. 5 fakultas user (3 auth-able)
         * 4. 5 upt perpustakaan user (3 auth-able)
         * 5. 5 keuangan user (3 auth-able) 
         * 
         * ==============================
         * YudisiumPeriodeSeeder:
         * 1. 3 yudisium periode
         * 
         * ==============================
         * YudisiumPendaftaranSeeder:
         * 1. Total: 45 (out of 60 mahasiswa) yudisium pendaftaran (no yudisium pendafataran for 2 auth-able mahasiswa users)
         * 2. 15 menunggu validasi (1 for auth-able mahasiswa users on latest periode) (5 each yudisium periode)
         * 3. 15 selesai (1 for auth-able mahasiswa users on latest periode) (5 each yudisium periode)
         * 4. 15 ditolak (1 for auth-able mahasiswa users on latest periode) (5 each yudisium periode)
         * 
         * ==============================
         * SuratKeteranganSeeder:
         * a. Surat Keterangan Bebas Perpustakaan:
         * 1. Total: 45 (out of 60 mahasiswa) surat keterangan (no surat keterangan for 1 auth-able mahasiswa users)
         * 2. 15 menunggu validasi (1 for auth-able mahasiswa users on latest periode)
         * 3. 15 selesai (2 for auth-able mahasiswa users)
         * 4. 15 ditolak (1 for auth-able mahasiswa users)
         * 
         * b. Surat Keterangan Bebas UKT:
         * 1. Total: 45 (out of 60 mahasiswa) surat keterangan (no surat keterangan for 1 auth-able mahasiswa users
         * 2. 15 menunggu validasi (1 for auth-able mahasiswa users)
         * 3. 15 selesai (5 selesai beasiswa) (2 for auth-able mahasiswa users, 1 is beasiswa)
         * 4. 15 ditolak (1 for auth-able mahasiswa users)
         * 
         * ==============================
         * YudisiumPeriodeInformasiSeeder:
         * 1. 1st periode -> 1 informasi
         * 2. 2nd periode -> 2 informasi
         * 3. 3rd periode -> 5 informasi
    */
    public function run()
    {
        // if (! is_cli()) {
        //     echo 'This seeder must be run as a CLI command.';
        //     return;
        // }
        // $test = readline('WARNING: WILL TRUNCATE ALL TABLES. ARE YOU SURE? (yes/no): ');
        // if ($test !== 'yes') {
        //     echo 'Seeder aborted.' . PHP_EOL;
        //     return;
        // }
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
        for ($i = 0; $i < 60; $i++) {
            $data = [
                'id' => $i + 1,
                'username' => $faker->name,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => $faker->email,
                'nim' => $faker->unique()->randomNumber(9),
                'program_studi' => $faker->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Teknik Elektro', 'Teknik Industri', 'Teknik Sipil']),
            ];

            if ($i < 5){
                $data['username'] = 'test' . $i;
                $data['email'] = 'mahasiswa' . $i . '@test.com';
            }

            $this->db->table('users')->insert([
                'id' => $i + 1,
                'username' => $data['username'],
                'nim' => $data['nim'],
                'program_studi' => $data['program_studi'],
            ]);

            $this->db->table('auth_groups_users')->insert([
                'id' => $i + 1,
                'user_id' => $i + 1,
                'group' => 'user_mahasiswa'
            ]);

            $this->db->table('auth_identities')->insert([
                'id' => $i + 1,
                'user_id' => $i + 1,
                'type' => 'email_password',
                'secret' => $data['email'],
                'secret2' => $data['password'],
            ]);
        }
        
        // admin
        for ($i = 0; $i < 5; $i++) {
            $data = [
                'id' => $i + 61,
                'username' => $faker->name,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => $faker->email,
                'nip' => '110' . $faker->unique()->randomNumber(9),
            ];

            if ($i < 3){
                $data['username'] = 'admin' . $i;
                $data['email'] = 'admin' . $i . '@test.com';
            }

            $this->db->table('users')->insert([
                'id' => $i + 61,
                'username' => $data['username'],
            ]);

            $this->db->table('auth_groups_users')->insert([
                'id' => $i + 61,
                'user_id' => $i + 61,
                'group' => 'admin'
            ]);

            if ($i < 3) {
                $this->db->table('auth_identities')->insert([
                    'id' => $i + 61,
                    'user_id' => $i + 61,
                    'type' => 'email_password',
                    'secret' => $data['email'],
                    'secret2' => $data['password'],
                ]);
            }
        }

        // user_fakultas
        for ($i = 0; $i < 5; $i++) {
            $data = [
                'id' => $i + 66,
                'username' => $faker->name,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => $faker->email,
                'nip' => '110' . $faker->unique()->randomNumber(9),
            ];

            if ($i < 3){
                $data['username'] = 'fakultas' . $i;
                $data['email'] = 'fakultas' . $i . '@test.com';
            }

            $this->db->table('users')->insert([
                'id' => $i + 66,
                'username' => $data['username'],
                'nip' => $data['nip'],
            ]);

            $this->db->table('auth_groups_users')->insert([
                'id' => $i + 66,
                'user_id' => $i + 66,
                'group' => 'user_fakultas'
            ]);

            if ($i < 3) {
                $this->db->table('auth_identities')->insert([
                    'id' => $i + 66,
                    'user_id' => $i + 66,
                    'type' => 'email_password',
                    'secret' => $data['email'],
                    'secret2' => $data['password'],
                ]);
            }
        }

        // user_upt_perpustakaan
        for ($i = 0; $i < 5; $i++) {
            $data = [
                'id' => $i + 71,
                'username' => $faker->name,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => $faker->email,
                'nip' => '110' . $faker->unique()->randomNumber(9),
            ];

            if ($i < 3){
                $data['username'] = 'upt_perpustakaan' . $i;
                $data['email'] = 'upt_perpustakaan' . $i . '@test.com';
            }

            $this->db->table('users')->insert([
                'id' => $i + 71,
                'username' => $data['username'],
                'nip' => $data['nip'],
            ]);

            $this->db->table('auth_groups_users')->insert([
                'id' => $i + 71,
                'user_id' => $i + 71,
                'group' => 'user_upt_perpustakaan'
            ]);

            if ($i < 3) {
                $this->db->table('auth_identities')->insert([
                    'id' => $i + 71,
                    'user_id' => $i + 71,
                    'type' => 'email_password',
                    'secret' => $data['email'],
                    'secret2' => $data['password'],
                ]);
            }
        }

        // user_keuangan
        for ($i = 0; $i < 5; $i++) {
            $data = [
                'id' => $i + 76,
                'username' => $faker->name,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => $faker->email,
                'nip' => '110' . $faker->unique()->randomNumber(9),
            ];

            if ($i < 3){
                $data['username'] = 'keuangan' . $i;
                $data['email'] = 'keuangan' . $i . '@test.com';
            }

            $this->db->table('users')->insert([
                'id' => $i + 76,
                'username' => $data['username'],
                'nip' => $data['nip'],
            ]);

            $this->db->table('auth_groups_users')->insert([
                'id' => $i + 76,
                'user_id' => $i + 76,
                'group' => 'user_keuangan'
            ]);

            if ($i < 3) {
                $this->db->table('auth_identities')->insert([
                    'id' => $i + 76,
                    'user_id' => $i + 76,
                    'type' => 'email_password',
                    'secret' => $data['email'],
                    'secret2' => $data['password'],
                ]);
            }
        }

        /**
         * ==============================
         * YudisiumPeriodeSeeder
         * ==============================
         */

        $this->db->table('yudisium_periode')->insert([
            'id' => 1,
            'periode' => 'Januari/2024',
            'tanggal_awal' => '2024-01-01',
            'tanggal_akhir' => '2024-01-20',
        ]);

        $this->db->table('yudisium_periode')->insert([
            'id' => 2,
            'periode' => 'Februari/2024',
            'tanggal_awal' => '2024-02-01',
            'tanggal_akhir' => '2024-02-20',
        ]);

        $this->db->table('yudisium_periode')->insert([
            'id' => 3,
            'periode' => 'Maret/2024',
            'tanggal_awal' => '2024-03-01',
            'tanggal_akhir' => '2024-03-20',
        ]);

        /**
         * ==============================
         * YudisiumPendaftaranSeeder
         * ==============================
         */

        //  auth-able menunggu validasi
         $this->db->table('yudisium_pendaftaran')->insert([
            'id' => 3,
            'mahasiswa_id' => 3,
            'yudisium_periode_id' => 3,
            'status' => 'menunggu_validasi',
        ]);

        //  auth-able selesai
        $this->db->table('yudisium_pendaftaran')->insert([
            'id' => 4,
            'mahasiswa_id' => 4,
            'yudisium_periode_id' => 3,
            'status' => 'selesai',
        ]);

        //  auth-able ditolak
        $this->db->table('yudisium_pendaftaran')->insert([
            'id' => 5,
            'mahasiswa_id' => 5,
            'yudisium_periode_id' => 3,
            'status' => 'ditolak',
        ]);

        //  14 Menunggu validasi
        for ($i = 5; $i < 19; $i++) {
            $this->db->table('yudisium_pendaftaran')->insert([
                'id' => $i + 1,
                'mahasiswa_id' => $i + 1,
                'yudisium_periode_id' => $i % 3 + 1,
                'status' => 'menunggu_validasi',
            ]);
        }

        // 14 Selesai
        for ($i = 19; $i < 33; $i++) {
            $this->db->table('yudisium_pendaftaran')->insert([
                'id' => $i + 1,
                'mahasiswa_id' => $i + 1,
                'yudisium_periode_id' => $i % 3 + 1,
                'status' => 'selesai',
            ]);
        }

        // 14 Ditolak
        for ($i = 33; $i < 47; $i++) {
            $this->db->table('yudisium_pendaftaran')->insert([
                'id' => $i + 1,
                'mahasiswa_id' => $i + 1,
                'yudisium_periode_id' => $i % 3 + 1,
                'status' => 'ditolak',
            ]);
        }

        /**
         * ==============================
         * SuratKeteranganSeeder
         * ==============================
         */

        //  Surat Keterangan Bebas Perpustakaan
        //  auth-able menunggu validasi
        $this->db->table('surat_keterangan')->insert([
            'id' => 2,
            'mahasiswa_id' => 2,
            'jenis_surat' => 'sk_bebas_perpustakaan',
            'status' => 'menunggu_validasi',
        ]);

        //  auth-able selesai
        $this->db->table('surat_keterangan')->insert([
            'id' => 3,
            'mahasiswa_id' => 3,
            'jenis_surat' => 'sk_bebas_perpustakaan',
            'status' => 'selesai',
            'nomor_surat' => '123/UN7.1/20240001',
            'peninjau_id' => 71,
        ]);
        $this->db->table('surat_keterangan')->insert([
            'id' => 4,
            'mahasiswa_id' => 4,
            'jenis_surat' => 'sk_bebas_perpustakaan',
            'status' => 'selesai',
            'nomor_surat' => '123/UN7.1/20240002',
            'tanggal_terbit' => date('Y-m-d', strtotime('-1 day')),
            'peninjau_id' => 72,
        ]);

        //  auth-able ditolak
        $this->db->table('surat_keterangan')->insert([
            'id' => 5,
            'mahasiswa_id' => 5,
            'jenis_surat' => 'sk_bebas_perpustakaan',
            'status' => 'ditolak',
            'peninjau_id' => 71,
        ]);

        //  14 Menunggu validasi
        for ($i = 5; $i < 19; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 1,
                'mahasiswa_id' => $i + 1,
                'jenis_surat' => 'sk_bebas_perpustakaan',
                'status' => 'menunggu_validasi',
            ]);
        }

        // 13 Selesai
        for ($i = 19; $i < 32; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 1,
                'mahasiswa_id' => $i + 1,
                'jenis_surat' => 'sk_bebas_perpustakaan',
                'status' => 'selesai',
                'nomor_surat' => '123/UN7.1/2024000' . ($i - 18),
                'tanggal_terbit' => date('Y-m-d', strtotime('2024-01-01 +' . rand(0, 78) . ' days')),
                'peninjau_id' => $faker->randomElement([71, 75]),
            ]);
        }

        // 14 Ditolak
        for ($i = 32; $i < 46; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 1,
                'mahasiswa_id' => $i + 1,
                'jenis_surat' => 'sk_bebas_perpustakaan',
                'status' => 'ditolak',
                'peninjau_id' => $faker->randomElement([71, 75]),
            ]);
        }

        //  Surat Keterangan Bebas UKT
        //  auth-able menunggu validasi
        $this->db->table('surat_keterangan')->insert([
            'id' => 47,
            'mahasiswa_id' => 2,
            'jenis_surat' => 'sk_bebas_ukt',
            'status' => 'menunggu_validasi',
        ]);

        //  auth-able selesai
        $this->db->table('surat_keterangan')->insert([
            'id' => 48,
            'mahasiswa_id' => 3,
            'jenis_surat' => 'sk_bebas_ukt',
            'status' => 'selesai',
            
        ]);

        //  auth-able selesai beasiswa
        $this->db->table('surat_keterangan')->insert([
            'id' => 49,
            'mahasiswa_id' => 4,
            'jenis_surat' => 'sk_bebas_ukt',
            'status' => 'selesai_mahasiswa_beasiswa'
        ]);

        //  auth-able ditolak
        $this->db->table('surat_keterangan')->insert([
            'id' => 50,
            'mahasiswa_id' => 5,
            'jenis_surat' => 'sk_bebas_ukt',
            'status' => 'ditolak',
        ]);

        //  14 Menunggu validasi
        for ($i = 50; $i < 64; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 1,
                'mahasiswa_id' => $i + 1 - 45,
                'jenis_surat' => 'sk_bebas_ukt',
                'status' => 'menunggu_validasi',
            ]);
        }

        // 9 Selesai
        for ($i = 64; $i < 73; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 1,
                'mahasiswa_id' => $i + 1 - 45,
                'jenis_surat' => 'sk_bebas_ukt',
                'status' => 'selesai',
            ]);
        }

        // 4 Selesai Beasiswa
        for ($i = 73; $i < 77; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 1,
                'mahasiswa_id' => $i + 1 - 45,
                'jenis_surat' => 'sk_bebas_ukt',
                'status' => 'selesai_mahasiswa_beasiswa',
            ]);
        }

        // 14 Ditolak
        for ($i = 77; $i < 91; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 1,
                'mahasiswa_id' => $i + 1 - 45,
                'jenis_surat' => 'sk_bebas_ukt',
                'status' => 'ditolak',
            ]);
        }


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

        // 2nd periode
        for ($i = 0; $i < 2; $i++) {
            $this->db->table('yudisium_periode_informasi')->insert([
                'id' => $i + 2,
                'yudisium_periode_id' => 2,
                'link_grup_whatsapp' => $faker->unique()->url,
                'keterangan' => 'link grup untuk program studi ' . ($i + 1) . '.',
            ]);
        }

        // 3rd periode
        for ($i = 0; $i < 5; $i++) {
            $this->db->table('yudisium_periode_informasi')->insert([
                'id' => $i + 4,
                'yudisium_periode_id' => 3,
                'link_grup_whatsapp' => $faker->unique()->url,
                'keterangan' => 'link grup untuk program studi ' . ($i + 1) . '.',
            ]);
        }
        
        // insert created_at and updated_at for all tables
        $this->db->table('users')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        $this->db->table('auth_groups_users')->update(['created_at' => date('Y-m-d H:i:s')]);
        $this->db->table('auth_identities')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        $this->db->table('yudisium_pendaftaran')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        $this->db->table('surat_keterangan')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        $this->db->table('yudisium_periode')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        $this->db->table('yudisium_periode_informasi')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
    }
}
