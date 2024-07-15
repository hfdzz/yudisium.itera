<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class YudisiumPendaftaranModel extends Model
{
    protected $table            = 'yudisium_pendaftaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\YudisiumPendaftaran';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tanggal_daftar',
        'tanggal_penerimaan',
        'status',
        'keterangan',
        'file_tanda_terima',
        'berkas_transkrip',
        'berkas_ijazah',
        'berkas_pas_foto',
        'berkas_sertifikat_bahasa_inggris',
        'berkas_akta_kelahiran',
        'berkas_surat_keterangan_mahasiswa',
        'mahasiswa_id',
        'peninjau_id',
        'yudisium_periode_id',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'status' => 'required',
        'mahasiswa_id' => 'required',
        'yudisium_periode_id' => 'required',
        'tanggal_daftar' => 'required',
        'tanggal_penerimaan' => 'permit_empty',
        'keterangan' => 'permit_empty',
        'file_tanda_terima' => 'permit_empty',
        'berkas_transkrip' => 'permit_empty',
        'berkas_ijazah' => 'permit_empty',
        'berkas_pas_foto' => 'permit_empty',
        'berkas_sertifikat_bahasa_inggris' => 'permit_empty',
        'berkas_akta_kelahiran' => 'permit_empty',
        'berkas_surat_keterangan_mahasiswa' => 'permit_empty',
        'peninjau_id' => 'permit_empty',
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
        'removeFileTandaTerima'
    ];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function daftarYudisiumMahasiswa($data)
    {
        $this->insert([
            ...$data,
            'status' => STATUS_MENUNGGU_VALIDASI,
        ]);

        return $this->getInsertID();
    }

    public function validasiPendaftaranYudisium($id, $data)
    {
        $this->update($id, [
            ...$data,
            'status' => STATUS_SELESAI,
        ]);

        return $this->getInsertID();
    }

    public function tolakPendaftaranYudisium($id, $data)
    {
        $this->update($id, [
            ...$data,
            'status' => STATUS_DITOLAK,
        ]);

        return $this->getInsertID();
    }

    public function getCurrentUploadFilePath()
    {
        return  PATH_UPLOAD_PENDAFTARAN_YUDISIUM . '/' . date('Y-m');
    }

    public function getCurrentTandaTerimaFilePath()
    {
        return PATH_TANDA_TERIMA_YUDISIUM . '/' . date('Y-m');
    }

    // afterUpdate callback
    protected function removeFileTandaTerima($eventData)
    {
        // set 'file_surat_keterangan' to null if updated field is not 'file_surat_keterangan'
        if (!isset($eventData['file_tanda_terima'])) {
            return $eventData;
        }
        $this->set('file_tanda_terima', null)
            ->where('id', $eventData['id'])
            ->update();

        return $eventData;
    }
}
