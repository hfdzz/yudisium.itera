<?php

namespace App\Models;

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
        'tanggal_terbit',
        'keterangan',
        'file_surat',
        'berkas_ba_sidang',
        'berkas_khs',
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
        'jenis_surat' => 'required',
        'status' => 'required',
        // 'nomor_surat' => 'required',
        // 'tanggal_terbit' => 'required',
        // 'keterangan' => 'required',
        // 'berkas_ba_sidang' => 'required',
        // 'berkas_khs' => 'required',
        // 'berkas_bukti_bayar_ukt' => 'required',
        'mahasiswa_id' => 'required',
        // 'peninjau_id' => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // query scope
    public function getSkBebasPerpustakaan()
    {
        return $this->where('jenis_surat', JENIS_SK_BEBAS_PERPUSTAKAAN);
    }

    public function getSkBebasUkt()
    {
        return $this->where('jenis_surat', JENIS_SK_BEBAS_UKT);
    }

    public function getSkBebasLaboratorium()
    {
        return $this->where('jenis_surat', JENIS_SK_BEBAS_LABORATORIUM);
    }

    public function getCurrentUploadFilePath($jenis_surat)
    {
        $path = '';
        switch ($jenis_surat) {
            case JENIS_SK_BEBAS_PERPUSTAKAAN:
                $path = PATH_UPLOAD_SK_BEBAS_PERPUSTAKAAN;
                break;
            case JENIS_SK_BEBAS_UKT:
                $path = PATH_UPLOAD_SK_BEBAS_UKT;
                break;
            case JENIS_SK_BEBAS_LABORATORIUM:
                $path = PATH_UPLOAD_SK_BEBAS_LABORATORIUM;
                break;
            default:
                throw new \Exception('Jenis surat tidak ditemukan');
        }
        return $path . '/' . date('Y-m');
    }

    public function requestSkBebasLaboratorium(/** TODO: PARAMS */)
    {
        // NOT YET IMPLEMENTED
        // TODO:
        // 1. CURL to SILABOR.ITERA API
        // 2. Save to database
        // 3. Return the data
    }

    public function requestRepo(/** TODO: PARAMS */)
    {
        // NOT YET IMPLEMENTED
        // TODO:
        // 1. CURL to REPO.ITERA API
    }
}
