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
         * 1. 120 mahaasiswa user (5 auth-able)
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
         * 1. Total: 55 (out of 120 mahasiswa out of 60 eligible mahasiswa) yudisium pendaftaran (no yudisium pendafataran for 2 auth-able mahasiswa users)
         * 2. 30 menunggu validasi (1 for auth-able mahasiswa users on latest periode) (8/9 each yudisium periode)
         * 3. 20 selesai (1 for auth-able mahasiswa users on latest periode) (5 each yudisium periode)
         * 4. 5 ditolak (1 for auth-able mahasiswa users on latest periode) (5 each yudisium periode)
         * 
         * ==============================
         * SuratKeteranganSeeder:
         * a. Surat Keterangan Bebas Perpustakaan:
         * 1. Total: 100 (out of 120 mahasiswa) surat keterangan (no surat keterangan for 1 auth-able mahasiswa users)
         * 2. 25 menunggu validasi (1 for auth-able mahasiswa users on latest periode)
         * 3. 60 selesai (2 for auth-able mahasiswa users)
         * 4. 15 ditolak (1 for auth-able mahasiswa users)
         * 
         * b. Surat Keterangan Bebas UKT:
         * 1. Total: 100 (out of 120 mahasiswa) surat keterangan (no surat keterangan for 1 auth-able mahasiswa users
         * 2. 25 menunggu validasi (1 for auth-able mahasiswa users)
         * 3. 60 selesai (20 selesai beasiswa) (2 for auth-able mahasiswa users, 1 is beasiswa)
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
        for ($i = 0; $i < 120; $i++) {
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
                'id' => $i + 121,
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
                'id' => $data['id'],
                'username' => $data['username'],
            ]);

            $this->db->table('auth_groups_users')->insert([
                'id' => $data['id'],
                'user_id' => $data['id'],
                'group' => 'admin'
            ]);

            if ($i < 3) {
                $this->db->table('auth_identities')->insert([
                    'id' => $data['id'],
                    'user_id' => $data['id'],
                    'type' => 'email_password',
                    'secret' => $data['email'],
                    'secret2' => $data['password'],
                ]);
            }
        }

        // user_fakultas
        for ($i = 0; $i < 5; $i++) {
            $data = [
                'id' => $i + 126,
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
                'id' => $data['id'],
                'username' => $data['username'],
                'nip' => $data['nip'],
            ]);

            $this->db->table('auth_groups_users')->insert([
                'id' => $data['id'],
                'user_id' => $data['id'],
                'group' => 'user_fakultas'
            ]);

            if ($i < 3) {
                $this->db->table('auth_identities')->insert([
                    'id' => $data['id'],
                    'user_id' => $data['id'],
                    'type' => 'email_password',
                    'secret' => $data['email'],
                    'secret2' => $data['password'],
                ]);
            }
        }

        // user_upt_perpustakaan
        for ($i = 0; $i < 5; $i++) {
            $data = [
                'id' => $i + 131,
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
                'id' => $data['id'],
                'username' => $data['username'],
                'nip' => $data['nip'],
            ]);

            $this->db->table('auth_groups_users')->insert([
                'id' => $data['id'],
                'user_id' => $data['id'],
                'group' => 'user_upt_perpustakaan'
            ]);

            if ($i < 3) {
                $this->db->table('auth_identities')->insert([
                    'id' => $data['id'],
                    'user_id' => $data['id'],
                    'type' => 'email_password',
                    'secret' => $data['email'],
                    'secret2' => $data['password'],
                ]);
            }
        }

        // user_keuangan
        for ($i = 0; $i < 5; $i++) {
            $data = [
                'id' => $i + 136,
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
                'id' => $data['id'],
                'username' => $data['username'],
                'nip' => $data['nip'],
            ]);

            $this->db->table('auth_groups_users')->insert([
                'id' => $data['id'],
                'user_id' => $data['id'],
                'group' => 'user_keuangan'
            ]);

            if ($i < 3) {
                $this->db->table('auth_identities')->insert([
                    'id' => $data['id'],
                    'user_id' => $data['id'],
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
            'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
            'berkas_ijazah' => 'faker/berkas_ijazah.pdf',
            'berkas_pas_foto' => 'faker/berkas_pas_foto.pdf',
            'berkas_sertifikat_bahasa_inggris' => 'faker/berkas_sertifikat_bahasa_inggris.pdf',
            'berkas_akta_kelahiran' => 'faker/berkas_akta_kelahiran.pdf',
        ]);

        //  auth-able selesai (beasiswa)
        $this->db->table('yudisium_pendaftaran')->insert([
            'id' => 4,
            'mahasiswa_id' => 4,
            'yudisium_periode_id' => 3,
            'status' => 'selesai',
            'tanggal_penerimaan' => '2024-03-01',
            'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
            'berkas_ijazah' => 'faker/berkas_ijazah.pdf',
            'berkas_pas_foto' => 'faker/berkas_pas_foto.pdf',
            'berkas_sertifikat_bahasa_inggris' => 'faker/berkas_sertifikat_bahasa_inggris.pdf',
            'berkas_akta_kelahiran' => 'faker/berkas_akta_kelahiran.pdf',
            'berkas_surat_keterangan_mahasiswa' => 'faker/berkas_surat_keterangan_mahasiswa.pdf',
        ]);

        //  auth-able ditolak
        $this->db->table('yudisium_pendaftaran')->insert([
            'id' => 5,
            'mahasiswa_id' => 5,
            'yudisium_periode_id' => 3,
            'status' => 'ditolak',
            'keterangan' => 'Hanya mahasiswa beasiswa yang mengirim surat keterangan mahasiswa',
            'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
            'berkas_ijazah' => 'faker/berkas_ijazah.pdf',
            'berkas_pas_foto' => 'faker/berkas_pas_foto.pdf',
            'berkas_sertifikat_bahasa_inggris' => 'faker/berkas_sertifikat_bahasa_inggris.pdf',
            'berkas_akta_kelahiran' => 'faker/berkas_akta_kelahiran.pdf',
            'berkas_surat_keterangan_mahasiswa' => 'faker/berkas_surat_keterangan_mahasiswa.pdf',
        ]);

        //  24 Menunggu validasi
        for ($i = 0; $i < 24; $i++) {
            $this->db->table('yudisium_pendaftaran')->insert([
                'id' => $i + 6,
                'mahasiswa_id' => $i + 30,
                'yudisium_periode_id' => $i % 3 + 1,
                'status' => 'menunggu_validasi',
                'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
                'berkas_ijazah' => 'faker/berkas_ijazah.pdf',
                'berkas_pas_foto' => 'faker/berkas_pas_foto.pdf',
                'berkas_sertifikat_bahasa_inggris' => 'faker/berkas_sertifikat_bahasa_inggris.pdf',
                'berkas_akta_kelahiran' => 'faker/berkas_akta_kelahiran.pdf',
            ]);
        }

        // 14 Selesai
        for ($i = 0; $i < 14; $i++) {
            $this->db->table('yudisium_pendaftaran')->insert([
                'id' => $i + 30,
                'mahasiswa_id' => $i + 44,
                'yudisium_periode_id' => $i % 3 + 1,
                'status' => 'selesai',
                'tanggal_penerimaan' => '2024-03-01',
                'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
                'berkas_ijazah' => 'faker/berkas_ijazah.pdf',
                'berkas_pas_foto' => 'faker/berkas_pas_foto.pdf',
                'berkas_sertifikat_bahasa_inggris' => 'faker/berkas_sertifikat_bahasa_inggris.pdf',
                'berkas_akta_kelahiran' => 'faker/berkas_akta_kelahiran.pdf',
            ]);
        }

        // 5 Menunggu Validasi (Bewasiswa)
        for ($i = 0; $i < 5; $i++) {
            $this->db->table('yudisium_pendaftaran')->insert([
                'id' => $i + 44,
                'mahasiswa_id' => $i + 114,
                'yudisium_periode_id' => $i % 3 + 1,
                'status' => 'menunggu_validasi',
                'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
                'berkas_ijazah' => 'faker/berkas_ijazah.pdf',
                'berkas_pas_foto' => 'faker/berkas_pas_foto.pdf',
                'berkas_sertifikat_bahasa_inggris' => 'faker/berkas_sertifikat_bahasa_inggris.pdf',
                'berkas_akta_kelahiran' => 'faker/berkas_akta_kelahiran.pdf',
                'berkas_surat_keterangan_mahasiswa' => 'faker/berkas_surat_keterangan_mahasiswa.pdf',
            ]);
        }

        // 5 Selesai (Beasiswa)
        for ($i = 0; $i < 5; $i++) {
            $this->db->table('yudisium_pendaftaran')->insert([
                'id' => $i + 49,
                'mahasiswa_id' => $i + 119,
                'yudisium_periode_id' => $i % 3 + 1,
                'status' => 'selesai',
                'tanggal_penerimaan' => '2024-03-01',
                'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
                'berkas_ijazah' => 'faker/berkas_ijazah.pdf',
                'berkas_pas_foto' => 'faker/berkas_pas_foto.pdf',
                'berkas_sertifikat_bahasa_inggris' => 'faker/berkas_sertifikat_bahasa_inggris.pdf',
                'berkas_akta_kelahiran' => 'faker/berkas_akta_kelahiran.pdf',
                'berkas_surat_keterangan_mahasiswa' => 'faker/berkas_surat_keterangan_mahasiswa.pdf',
            ]);
        }

        // 3 Ditolak
        for ($i = 0; $i < 3; $i++) {
            $this->db->table('yudisium_pendaftaran')->insert([
                'id' => $i + 54,
                'mahasiswa_id' => $i + 54,
                'yudisium_periode_id' => $i % 3 + 1,
                'status' => 'ditolak',
                'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
                'berkas_ijazah' => 'faker/berkas_ijazah.pdf',
                'berkas_pas_foto' => 'faker/berkas_pas_foto.pdf',
                'berkas_sertifikat_bahasa_inggris' => 'faker/berkas_sertifikat_bahasa_inggris.pdf',
                'berkas_akta_kelahiran' => 'faker/berkas_akta_kelahiran.pdf',
                'berkas_surat_keterangan_mahasiswa' => 'faker/berkas_surat_keterangan_mahasiswa.pdf',
            ]);
        }

        // 1 Ditolak (Beasiswa)
        $this->db->table('yudisium_pendaftaran')->insert([
            'id' => 57,
            'mahasiswa_id' => $i + 124,
            'yudisium_periode_id' => 3,
            'status' => 'ditolak',
            'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
            'berkas_ijazah' => 'faker/berkas_ijazah.pdf',
            'berkas_pas_foto' => 'faker/berkas_pas_foto.pdf',
            'berkas_sertifikat_bahasa_inggris' => 'faker/berkas_sertifikat_bahasa_inggris.pdf',
            'berkas_akta_kelahiran' => 'faker/berkas_akta_kelahiran.pdf',
            'berkas_surat_keterangan_mahasiswa' => 'faker/berkas_surat_keterangan_mahasiswa.pdf',
        ]);

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
            'nomor_surat' => '100/UN7.1/20240001',
            'peninjau_id' => 131,
            'tanggal_terbit' => date('Y-m-d', strtotime('-1 day')),
        ]);
        $this->db->table('surat_keterangan')->insert([
            'id' => 4,
            'mahasiswa_id' => 4,
            'jenis_surat' => 'sk_bebas_perpustakaan',
            'status' => 'selesai',
            'nomor_surat' => '100/UN7.1/20240002',
            'peninjau_id' => 132,
            'tanggal_terbit' => date('Y-m-d', strtotime('-1 day')),
        ]);

        //  auth-able ditolak
        $this->db->table('surat_keterangan')->insert([
            'id' => 5,
            'mahasiswa_id' => 5,
            'jenis_surat' => 'sk_bebas_perpustakaan',
            'status' => 'ditolak',
            'peninjau_id' => 131,
        ]);

        //  24 Menunggu validasi
        for ($i = 0; $i < 24; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 6,
                'mahasiswa_id' => $i + 6,
                'jenis_surat' => 'sk_bebas_perpustakaan',
                'status' => 'menunggu_validasi',
            ]);
        }

        // 58 Selesai
        for ($i = 0; $i < 58; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 30,
                'mahasiswa_id' => $i + 30,
                'jenis_surat' => 'sk_bebas_perpustakaan',
                'status' => 'selesai',
                'nomor_surat' => '100/UN7.1/2024000' . ($i + 1),
                'tanggal_terbit' => date('Y-m-d', strtotime('2024-01-01 +' . rand(0, 78) . ' days')),
                'peninjau_id' => $faker->randomElement([131, 135]),
            ]);
        }

        // 14 Ditolak
        for ($i = 0; $i < 14; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 88,
                'mahasiswa_id' => $i + 88,
                'jenis_surat' => 'sk_bebas_perpustakaan',
                'status' => 'ditolak',
                'peninjau_id' => $faker->randomElement([131, 135]),
            ]);
        }

        //  Surat Keterangan Bebas UKT
        //  auth-able menunggu validasi
        $this->db->table('surat_keterangan')->insert([
            'id' => 102,
            'mahasiswa_id' => 2,
            'jenis_surat' => 'sk_bebas_ukt',
            'status' => 'menunggu_validasi',
            'nomor_surat' => '110/UN7.1/20240001',
            'berkas_ba_sidang' => 'faker/berkas_ba_sidang.pdf',
            'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
            'berkas_bukti_bayar_ukt' => 'faker/berkas_bukti_bayar_ukt.pdf',
        ]);

        //  auth-able selesai
        $this->db->table('surat_keterangan')->insert([
            'id' => 103,
            'mahasiswa_id' => 3,
            'peninjau_id' => 136, // user_keuangan
            'jenis_surat' => 'sk_bebas_ukt',
            'status' => 'selesai',
            'nomor_surat' => '110/UN7.1/20240002',
            'tanggal_terbit' => date('Y-m-d', strtotime('-1 day')), // '2024-03-01
            'berkas_ba_sidang' => 'faker/berkas_ba_sidang.pdf',
            'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
            'berkas_bukti_bayar_ukt' => 'faker/berkas_bukti_bayar_ukt.pdf',
        ]);

        //  auth-able selesai beasiswa
        $this->db->table('surat_keterangan')->insert([
            'id' => 104,
            'mahasiswa_id' => 4,
            'peninjau_id' => 137,
            'jenis_surat' => 'sk_bebas_ukt',
            'status' => 'selesai_mahasiswa_beasiswa',
            'berkas_ba_sidang' => 'faker/berkas_ba_sidang.pdf',
            'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
            'berkas_bukti_bayar_ukt' => 'faker/berkas_bukti_bayar_ukt.pdf',
        ]);

        //  auth-able ditolak
        $this->db->table('surat_keterangan')->insert([
            'id' => 105,
            'mahasiswa_id' => 5,
            'peninjau_id' => 136,
            'jenis_surat' => 'sk_bebas_ukt',
            'status' => 'ditolak',
            'berkas_ba_sidang' => 'faker/berkas_ba_sidang.pdf',
            'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
            'berkas_bukti_bayar_ukt' => 'faker/berkas_bukti_bayar_ukt.pdf',
        ]);

        //  24 Menunggu validasi
        for ($i = 0; $i < 24; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 106,
                'mahasiswa_id' => $i + 6,
                'jenis_surat' => 'sk_bebas_ukt',
                'status' => 'menunggu_validasi',
                'berkas_ba_sidang' => 'faker/berkas_ba_sidang.pdf',
                'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
                'berkas_bukti_bayar_ukt' => 'faker/berkas_bukti_bayar_ukt.pdf',
            ]);
        }

        // 39 Selesai
        for ($i = 0; $i < 39; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 130,
                'mahasiswa_id' => $i + 30,
                'peninjau_id' => $faker->randomElement([136, 140]),
                'jenis_surat' => 'sk_bebas_ukt',
                'status' => 'selesai',
                'tanggal_terbit' => date('Y-m-d', strtotime('2024-01-01 +' . rand(0, 78) . ' days')), // '2024-01-01
                'nomor_surat' => '110/UN7.1/2024000' . ($i + 1),
                'berkas_ba_sidang' => 'faker/berkas_ba_sidang.pdf',
                'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
                'berkas_bukti_bayar_ukt' => 'faker/berkas_bukti_bayar_ukt.pdf',
            ]);
        }

        // 19 Selesai beasiswa
        for ($i = 0; $i < 19; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 169,
                'mahasiswa_id' => $i + 60,
                'peninjau_id' => $faker->randomElement([136, 140]),
                'jenis_surat' => 'sk_bebas_ukt',
                'status' => 'selesai_mahasiswa_beasiswa',
                'berkas_ba_sidang' => 'faker/berkas_ba_sidang.pdf',
                'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
                'berkas_bukti_bayar_ukt' => 'faker/berkas_bukti_bayar_ukt.pdf',
            ]);
        }

        // 14 Ditolak
        for ($i = 0; $i < 14; $i++) {
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 188,
                'mahasiswa_id' => $i + 88,
                'peninjau_id' => $faker->randomElement([136, 140]),
                'jenis_surat' => 'sk_bebas_ukt',
                'status' => 'ditolak',
                'berkas_ba_sidang' => 'faker/berkas_ba_sidang.pdf',
                'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
                'berkas_bukti_bayar_ukt' => 'faker/berkas_bukti_bayar_ukt.pdf',
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
