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
}
