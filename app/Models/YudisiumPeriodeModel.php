<?php

namespace App\Models;

use CodeIgniter\Model;

class YudisiumPeriodeModel extends Model
{
    protected $table            = 'yudisium_periode';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'periode',
        'tanggal_awal',
        'tanggal_akhir',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'periode' => 'required',
        'tanggal_awal' => 'required|valid_date',
        'tanggal_akhir' => 'required|valid_date',
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

    public function isPeriodeEmpty($periode_id)
    {
        /**
         * @var YudisiumPendaftaranModel $pendaftaran
         */
        $pendaftaran = model('YudisiumPendaftaranModel')->where('yudisium_periode_id', $periode_id);

        if ($pendaftaran->countAllResults() > 0) {
            return false;
        }

        return true;
    }

    public function isPeriodeOpen($periode_id)
    {
        $periode = $this->find($periode_id);

        if ($periode['tanggal_awal'] <= date('Y-m-d') && $periode['tanggal_akhir'] >= date('Y-m-d')) {
            return true;
        }

        return false;
    }

    public function getCurrentOpenPeriode()
    {
        $periode = $this->where('tanggal_awal <=', date('Y-m-d'))
            ->where('tanggal_akhir >=', date('Y-m-d'))
            ->first();

        return $periode;
    }

    public function openNewPeriode($data)
    {
        // Check if there is an open periode
        $periode = $this->getCurrentOpenPeriode();

        if ($periode) {
            throw new \Exception('Tidak dapat membuka periode baru, karena masih ada periode yang terbuka.');
        }

        $this->insert($data);
    }
}
