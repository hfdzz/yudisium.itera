<?php

namespace App\Models;

use App\Entities\YudisiumPeriode;
use CodeIgniter\Model;
use Config\App;

class YudisiumPeriodeModel extends Model
{
    protected $table            = 'yudisium_periode';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\YudisiumPeriode';
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

    public function getLatestPeriode() : YudisiumPeriode | null
    {
        return $this->orderBy('created_at', 'DESC')
            ->orderBy('tanggal_akhir', 'DESC')
            ->first();
    }

    public function getCurrentPeriode() : YudisiumPeriode | null
    {
        return $this->where('tanggal_awal <=', date('Y-m-d'))
            ->where('tanggal_akhir >=', date('Y-m-d'))
            ->orderBy('created_at', 'DESC')
            ->first();
    }

    public function openNewPeriode($data)
    {
        if (! $this->getCurrentPeriode()) {
            $this->insert($data);
        }
        throw new \Exception('Tidak dapat membuat periode baru, masih ada periode yang terbuka.');
    }
}
