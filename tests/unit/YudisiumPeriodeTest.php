<?php

use CodeIgniter\I18n\Time;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class YudisiumPeriodeTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $refresh  = true;

    protected $namespace = null;
    
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testYudisiumPeriodeIsEmptyTrue()
    {
        $model = model('YudisiumPeriodeModel');

        $model->insert([
            'periode' => '2020/2021',
            'tanggal_awal' => Time::now()->format('Y-m-d'),
            'tanggal_akhir' => Time::now()->addDays(10)->format('Y-m-d')
        ]);

        $result = $model->isPeriodeEmpty(1);

        $this->assertTrue($result);
    }

    public function testYudisiumPeriodeIsEmptyFalse()
    {
        $model_periode = model('YudisiumPeriodeModel');

        $model_periode->insert([
            'periode' => '2020/2021',
            'tanggal_awal' => Time::now()->format('Y-m-d'),
            'tanggal_akhir' => Time::now()->addDays(30)->format('Y-m-d')
        ]);

        if ($model_periode->errors()) {
            foreach ($model_periode->errors() as $error) {
                throw new \Exception($error);
            }
        }

        $model_pendaftaran = model('YudisiumPendaftaranModel');

        model('UserModel')->insert([
            'username' => 'user',
            'password_hash' => password_hash('user', PASSWORD_BCRYPT),
            'email' => 'test@test.com',
        ]);

        $model_pendaftaran->insert([
            'tanggal_penerimaan' => '2020-01-01',
            'status' => 'diterima',
            'keterangan' => 'lulus',
            'berkas_transkrip' => 'transkrip.pdf',
            'berkas_ijazah' => 'ijazah.pdf',
            'berkas_pas_foto' => 'pas_foto.pdf',
            'berkas_sertifikat_bahasa_inggris' => 'sertifikat_bahasa_inggris.pdf',
            'berkas_akta_kelahiran' => 'akta_kelahiran.pdf',
            'berkas_surat_keterangan_mahasiswa' => 'surat_keterangan_mahasiswa.pdf',
            'mahasiswa_id' => 1,
            'peninjau_id' => 1,
            'yudisium_periode_id' => 1,
        ]);

        $result = $model_periode->isPeriodeEmpty(1);

        $this->assertFalse($result);
    }
}
