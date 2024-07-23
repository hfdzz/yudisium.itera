<?php

namespace App\Models;

use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Model;

class SuratKeteranganModel extends Model
{
    protected $table            = 'surat_keterangan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\SuratKeterangan::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'jenis_surat',
        'status',
        'nomor_surat',
        'tanggal_pengajuan',
        'tanggal_terbit',
        'keterangan',
        'file_surat_keterangan',
        'tanggal_sidang',
        'berkas_ba_sidang',
        'berkas_transkrip',
        'berkas_bukti_bayar_ukt',
        'mahasiswa_id',
        'peninjau_id',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'jenis_surat' => 'required|string',
        'status' => 'required|string',
        'nomor_surat' => 'string|permit_empty',
        'tanggal_pengajuan' => 'required|date',
        'tanggal_terbit' => 'date|permit_empty',
        'keterangan' => 'string|permit_empty',
        'tanggal_sidang' => 'date|permit_empty',
        'berkas_ba_sidang' => 'string|permit_empty',
        'berkas_transkrip' => 'string|permit_empty',
        'berkas_bukti_bayar_ukt' => 'string|permit_empty',
        'mahasiswa_id' => 'required',
        'peninjau_id' => 'permit_empty'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [
        'removeFileSuratKeterangan'
    ];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getUploadPath($jenis_surat)
    {
        $path = '';
        switch ($jenis_surat) {
            case JENIS_SK_BEBAS_PERPUSTAKAAN:
                $path = PATH_UPLOAD_SK_BEBAS_PERPUSTAKAAN;
                break;
            case JENIS_SK_BEBAS_UKT:
                $path = PATH_UPLOAD_SK_BEBAS_UKT;
                break;
            default:
                throw new \Exception('Jenis surat tidak ditemukan');
        }
        return $path . '/' . date('Y-m');
    }
    
    public function getSkBebasPerpustakaan($mahasiswa_id)
    {
        return $this->where('jenis_surat', JENIS_SK_BEBAS_PERPUSTAKAAN)
            ->where('mahasiswa_id', $mahasiswa_id)
            ->first();
    }

    public function getSkBebasUkt($mahasiswa_id)
    {
        return $this->where('jenis_surat', JENIS_SK_BEBAS_UKT)
            ->where('mahasiswa_id', $mahasiswa_id)
            ->first();
    }

    public function ajukanSkBebasPerpustakaan($data, $file_data = null)
    {
        /** @var \App\Entities\UserEntity */
        $mahasiswa = model('UserModel')->find($data['mahasiswa_id']);

        if ($mahasiswa->suratKeteranganBebasPerpustakaan() && !$mahasiswa->suratKeteranganBebasPerpustakaan()->canAjukan()) {
            throw new \Exception('Anda sudah memiliki surat keterangan bebas perpustakaan atau sedang dalam proses validasi');
        }

        $data = [
            ...$data,
            'id' => $mahasiswa->suratKeteranganBebasPerpustakaan()->id ?? null,
            'jenis_surat' => JENIS_SK_BEBAS_PERPUSTAKAAN,
            'status' => STATUS_MENUNGGU_VALIDASI,
            'tanggal_pengajuan' => date('Y-m-d'),
        ];

        $sk_bebas_perpustakaan = new \App\Entities\SuratKeterangan($data);

        $this->save($sk_bebas_perpustakaan);

        return $sk_bebas_perpustakaan;
    }

    public function ajukanSkBebasUkt($data, $file_data = null)
    {
        /** @var \App\Entities\UserEntity */
        $mahasiswa = model('UserModel')->find($data['mahasiswa_id']);
        $previous_sk = $mahasiswa->suratKeteranganBebasUkt();

        if ($previous_sk && !$previous_sk->canAjukan()) {
            throw new \Exception('Anda sudah memiliki surat keterangan bebas UKT atau sedang dalam proses validasi');
        }

        $data = [
            ...$data,
            'id' => $previous_sk->id ?? null,
            'jenis_surat' => JENIS_SK_BEBAS_UKT,
            'status' => STATUS_MENUNGGU_VALIDASI,
            'tanggal_pengajuan' => date('Y-m-d'),
        ];

        $sk_bebas_ukt = new \App\Entities\SuratKeterangan($data);

        $this->save($sk_bebas_ukt);

        $sk_bebas_ukt = $previous_sk ?? $this->find($this->insertID());

        if ($file_data) {
            $sk_bebas_ukt->saveUploadedFiles($file_data, true);
        }

        return $sk_bebas_ukt;
    }

    // afterUpdate
    protected function removeFileSuratKeterangan($eventData)
    {
        // set 'file_surat_keterangan' to null if updated field does not contain 'file_surat_keterangan'
        if (isset($eventData['data']['file_surat_keterangan'])) {
            return $eventData;
        }
        $this->set('file_surat_keterangan', null)
            ->where('id', $eventData['id'])
            ->allowCallbacks(false)
            ->update();

        return $eventData;
    }
}
