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
         * 1. 120 mahaasiswa user (Category: fresh, asked (both) SK, with SK, asked yudisium, finished)
         * 2. 5 admin user
         * 3. 5 fakultas user
         * 4. 5 upt perpustakaan user
         * 5. 5 keuangan user 
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

    // users
    const MAHASISWA_USER_AMOUNT = 305; // 100 mahasiswa each periode, 5 non-faker mahasiswa
    const MAHASISWA_USER_NON_FAKER_AMOUNT = 5; // 1 fresh, 2, asked (both) SK, 3 with SK, 4 asked yudisium, 5 finished
    const PRODI_LIST = ['Teknik Informatika', 'Sistem Informasi', 'Teknik Elektro', 'Teknik Geofisika', 'Teknik Geologi', 
    'Teknik Industri', 'Teknik Mesin', 'Teknik Pertambangan', 'Rekayasa Minyak dan Gas', 'Teknik Material', 'Teknik Elektro', 
    'Teknik Informatika', 'Teknik Sistem Energi', 'Teknik Biomedis', 'Teknik Fisika', 'Rekayasa Instrumentasi dan Automasi', 
    'Teknik Telekomunikasi', 'Rekayasa Keolahragaan', 'Teknik Kimia', 'Teknik Biosistem', 'Teknologi Industri Pertanian'];
    const VALIDATOR_USER_AMOUNT = 5;
    const VALIDATOR_USER_NON_FAKER_AMOUNT = 3;
    const FAKULTAS_ID_START = self::MAHASISWA_USER_AMOUNT + 1;
    const UPT_PERPUSTAKAAN_ID_START = self::MAHASISWA_USER_AMOUNT + self::VALIDATOR_USER_AMOUNT + 1;
    const KEUANGAN_ID_START = self::MAHASISWA_USER_AMOUNT + self::VALIDATOR_USER_AMOUNT*2 + 1;

    // surat_keterangan
    // const SURAT_KETERANGAN_AMOUNT = self::MAHASISWA_USER_AMOUNT;

    // yudisium_pendaftaran
    // const YUDISIUM_PENDAFTARAN_AMOUNT = self::MAHASISWA_USER_AMOUNT;
    // These exclude non-faker mahasiswa
    const YUDISIUM_PENDAFTARAN_MENUNGGU_VALIDASI_AMOUNT = 50;
    const YUDISIUM_PENDAFTARAN_SELESAI_AMOUNT = 230;
    const YUDISIUM_PENDAFTARAN_DITOLAK_AMOUNT = 20;
    
    public function run()
    {
        $start_time = microtime(true);

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
         * Section 1
         * ==============================
         */
        echo 'Running Section 1...' . PHP_EOL;

        /**
         * ==============================
         * UserSeeder
         * ==============================
         */

        //  user_mahasiswa
        for ($i = 0; $i < self::MAHASISWA_USER_AMOUNT; $i++) {
            $this->create_user([
                'id' => $i,
                'username' => $i < self::MAHASISWA_USER_NON_FAKER_AMOUNT ? 'mahasiswa' . $i : $faker->name,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' =>  $i < self::MAHASISWA_USER_NON_FAKER_AMOUNT ? 'mahasiswa' . $i . '@test.com' : $faker->email,
                'nim' => $i < self::MAHASISWA_USER_NON_FAKER_AMOUNT ? (string)(120140230 + $i) : $faker->unique()->randomNumber(9),
                'program_studi' => self::PRODI_LIST[$i % count(self::PRODI_LIST)],
                'group' => 'user_mahasiswa',
            ]);
        }

        // user_fakultas
        for ($i = 0; $i < self::VALIDATOR_USER_AMOUNT; $i++) {
            $this->create_user([
                'id' => $i + self::MAHASISWA_USER_AMOUNT,
                'username' => $i < self::VALIDATOR_USER_NON_FAKER_AMOUNT ? 'fakultas' . $i : $faker->name,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => $i < self::VALIDATOR_USER_NON_FAKER_AMOUNT ? 'fakultas' . $i . '@test.com' : $faker->email,
                'nip' => '500' . $faker->unique()->randomNumber(9),
                'group' => 'user_fakultas',
            ]);
        }

        // user_upt_perpustakaan
        for ($i = 0; $i < self::VALIDATOR_USER_AMOUNT; $i++) {
            $this->create_user([
                'id' => $i + self::VALIDATOR_USER_AMOUNT + self::MAHASISWA_USER_AMOUNT,
                'username' => $i < self::VALIDATOR_USER_NON_FAKER_AMOUNT ? 'upt_perpustakaan' . $i : $faker->name,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => $i < self::VALIDATOR_USER_NON_FAKER_AMOUNT ? 'upt_perpustakaan' . $i . '@test.com' : $faker->email,
                'nip' => '600' . $faker->unique()->randomNumber(9),
                'group' => 'user_upt_perpustakaan',
            ]);
        }

        // user_keuangan
        for ($i = 0; $i < self::VALIDATOR_USER_AMOUNT; $i++) {
            $this->create_user([
                'id' => $i + self::VALIDATOR_USER_AMOUNT*2 + self::MAHASISWA_USER_AMOUNT,
                'username' => $i < self::VALIDATOR_USER_NON_FAKER_AMOUNT ? 'keuangan' . $i : $faker->name,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' => $i < self::VALIDATOR_USER_NON_FAKER_AMOUNT ? 'keuangan' . $i . '@test.com' : $faker->email,
                'nip' => '700' . $faker->unique()->randomNumber(9),
                'group' => 'user_keuangan',
            ]);
        }

        /**
         * ==============================
         * YudisiumPeriodeSeeder
         * ==============================
         */
        for ($i = 0; $i < 3; $i++) {
            $this->db->table('yudisium_periode')->insert([
                'id' => 3 - $i,
                'periode' => date('F/Y', strtotime("-$i month")),
                'tanggal_yudisium' => date('Y-m-d', strtotime("-$i month")),
                'tanggal_awal' => date('Y-m-05', strtotime("-$i month")),
                // last day of the month
                'tanggal_akhir' => date('Y-m-t', strtotime("-$i month")),
            ]);
        }


        /**
         * ==============================
         * SuratKeteranganSeeder
         * ==============================
         */

        //  Surat Keterangan Bebas Perpustakaan
        for ($i = 0; $i < self::MAHASISWA_USER_AMOUNT; $i++) {
            if ($i <= 0) {
                continue;
            }
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 1,
                'mahasiswa_id' => $i + 1,
                'jenis_surat' => 'sk_bebas_perpustakaan',
                'status' => $i == 1 ? 'menunggu_validasi' : 'selesai',
                // 2 month ago + ( $i/10 ) day 
                'tanggal_pengajuan' => date('Y-m-d', strtotime("-2 month" . (int) ($i/10) . " day")),
                'tanggal_terbit' => $i > 1 ? date('Y-m-d', strtotime("-2 month" . (int) ($i/10) . " day")) : null,
                'nomor_surat' => $i > 1 ? 'SKBP/'.date('Y-m-d', strtotime("-2 month" . (int) ($i/10) . " day")).'/'.$faker->unique()->randomNumber(5, true) : null,
                'created_at' => date('Y-m-d', strtotime("-2 month" . (int) ($i/10) . " day")),
                'updated_at' => date('Y-m-d', strtotime("-2 month" . (int) ($i/10) . " day")),
            ]);
        }

        //  Surat Keterangan Bebas UKT
        for ($i = 0; $i < self::MAHASISWA_USER_AMOUNT; $i++) {
            if ($i <= 0) {continue;}
            $this->db->table('surat_keterangan')->insert([
                'id' => $i + 1 + self::MAHASISWA_USER_AMOUNT,
                'mahasiswa_id' => $i + 1,
                'jenis_surat' => 'sk_bebas_ukt',
                'status' => $i == 1 ? 'menunggu_validasi' : ($i == 2 ? 'selesai_mahasiswa_beasiswa' : 'selesai'),
                'tanggal_sidang' => $i + 1 > 1 ? date('Y-m-d', strtotime("-2 month" . (int) ($i/10) . " day")) : null,
                'berkas_ba_sidang' => $i + 1 > 1 ? 'faker/berkas_ba_sidang.pdf' : null,
                'berkas_transkrip' => $i +1 > 1 ? 'faker/berkas_transkrip.pdf' : null,
                'berkas_bukti_bayar_ukt' => $i + 1 > 1 ? 'faker/berkas_bukti_bayar_ukt.pdf' : null,
                // 2 month ago + ( $i/10 ) day 
                'tanggal_pengajuan' => date('Y-m-d', strtotime("-2 month" . (int) ($i/10) . " day")),
                'tanggal_terbit' => $i > 2 ? date('Y-m-d', strtotime("-2 month" . (int) ($i/10 + 1) . " day")) : null,
                'nomor_surat' => $i > 2 ? 'SKBU/'.date('Y-m-d', strtotime("-2 month" . (int) ($i/10) . " day")).'/'.$faker->unique()->randomNumber(5, true) : null,
                'created_at' => date('Y-m-d', strtotime("-2 month" . (int) ($i/10) . " day")),
                'updated_at' => date('Y-m-d', strtotime("-2 month" . (int) ($i/10) . " day")),
            ]);
        }

        /**
         * ==============================
         * YudisiumPendaftaranSeeder
         * ==============================
         */

        for ($i = 0; $i < self::MAHASISWA_USER_AMOUNT; $i++) {
            if ($i < 3) {continue;}
            $this->db->table('yudisium_pendaftaran')->insert([
                'id' => $i + 1,
                'mahasiswa_id' => $i + 1,
                'yudisium_periode_id' => $i < 105 ? 3 : ($i < 200 ? 2 : 1),
                'status' => $i == 3 || ($i > 4 && $i < self::YUDISIUM_PENDAFTARAN_MENUNGGU_VALIDASI_AMOUNT) ? 'menunggu_validasi' : ($i >= self::YUDISIUM_PENDAFTARAN_MENUNGGU_VALIDASI_AMOUNT && $i < self::YUDISIUM_PENDAFTARAN_DITOLAK_AMOUNT + self::YUDISIUM_PENDAFTARAN_MENUNGGU_VALIDASI_AMOUNT + 5 ? 'ditolak' : 'selesai'),
                'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
                'berkas_ijazah' => 'faker/berkas_ijazah.pdf',
                'berkas_pas_foto' => 'faker/berkas_pas_foto.pdf',
                'berkas_sertifikat_bahasa_inggris' => 'faker/berkas_sertifikat_bahasa_inggris.pdf',
                'berkas_akta_kelahiran' => 'faker/berkas_akta_kelahiran.pdf',
                'berkas_surat_keterangan_mahasiswa' => $i == 3 ? 'faker/berkas_surat_keterangan_mahasiswa.pdf' : null,
                'tanggal_daftar' => date('Y-m-d', strtotime("-2 month" . (int) ($i/10) . " day")),
                'tanggal_penerimaan' => $i == 4 || $i >= self::YUDISIUM_PENDAFTARAN_MENUNGGU_VALIDASI_AMOUNT ? date('Y-m-d', strtotime("-2 month" . (int) ($i/10 + 1) . " day")) : null,
                'peninjau_id' => $i == 4 || $i >= self::YUDISIUM_PENDAFTARAN_MENUNGGU_VALIDASI_AMOUNT ? ($i % self::VALIDATOR_USER_AMOUNT) + self::FAKULTAS_ID_START : null,
                'created_at' => date('Y-m-d', strtotime("-2 month" . (int) ($i/10) . " day")),
                'updated_at' => date('Y-m-d', strtotime("-2 month" . (int) ($i/10) . " day")),
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
        $this->db->table('yudisium_periode')->update(['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);


        /**
         * ==============================
         * Section 2
         * ==============================
         */
        echo 'Running Section 2...' . PHP_EOL;

        //  user_mahasiswa with menunggu validasi SK
        $amount = 50;
        for ($i = 0; $i < $amount; $i++) {
            $insert_id = $this->create_user([
                'username' => $faker->name,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'email' =>  $faker->email,
                'nim' => $faker->unique()->randomNumber(9),
                'program_studi' => self::PRODI_LIST[$i % count(self::PRODI_LIST)],
                'group' => 'user_mahasiswa',
            ]);

            $this->db->table('surat_keterangan')->insert([
                'mahasiswa_id' => $insert_id,
                'jenis_surat' => 'sk_bebas_perpustakaan',
                'status' => 'menunggu_validasi',
                'tanggal_pengajuan' => date('Y-m-d', strtotime('-1 day')),
                'created_at' => date('Y-m-d', strtotime('-1 day')),
                'updated_at' => date('Y-m-d', strtotime('-1 day')),
            ]);

            $this->db->table('surat_keterangan')->insert([
                'mahasiswa_id' => $insert_id,
                'jenis_surat' => 'sk_bebas_ukt',
                'status' => 'menunggu_validasi',
                'tanggal_sidang' => date('Y-m-d', strtotime('-1 day')),
                'berkas_ba_sidang' => 'faker/berkas_ba_sidang.pdf',
                'berkas_transkrip' => 'faker/berkas_transkrip.pdf',
                'berkas_bukti_bayar_ukt' => 'faker/berkas_bukti_bayar_ukt.pdf',
                'tanggal_pengajuan' => date('Y-m-d', strtotime('-1 day')),
                'created_at' => date('Y-m-d', strtotime('-1 day')),
                'updated_at' => date('Y-m-d', strtotime('-1 day')),
            ]);
        }




    
        $end_time = microtime(true);
        // Round execution time to 4 decimal places
        $execution_time = round($end_time - $start_time, 4);
        echo 'Execution time: ' . $execution_time . ' seconds' . PHP_EOL;

    }
    

    protected function create_user(array $data, bool $authable = true)
    {
        $data['id'] = isset($data['id']) ? $data['id']+1 : null;
        $this->db->table('users')->insert([
            'id' => $data['id'],
            'username' => $data['username'],
            'nim' => $data['nim'] ?? null,
            'program_studi' => $data['program_studi'] ?? null,
            'nip' => $data['nip'] ?? null,
            // one day before the current date added with + {id} minutes
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day +' . $data['id'] . ' minutes')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day +' . $data['id'] . ' minutes')),
        ]);

        $user_insert_id = $this->db->insertID();

        $this->db->table('auth_groups_users')->insert([
            'user_id' => $data['id'] ?? $user_insert_id,
            'group' => $data['group'],
            // one day before the current date added with + {id} minutes
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day +' . $data['id'] . ' minutes')),
        ]);

        if ($authable) {
            $this->db->table('auth_identities')->insert([
                'user_id' => $data['id'] ?? $user_insert_id,
                'type' => 'email_password',
                'secret' => $data['email'],
                'secret2' => $data['password'],
                // one day before the current date added with + {id} minutes
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day +' . $data['id'] . ' minutes')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day +' . $data['id'] . ' minutes')),
            ]);
        }

        return $user_insert_id ?? null;
    }
}
