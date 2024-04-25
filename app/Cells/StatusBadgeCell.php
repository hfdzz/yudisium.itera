<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class StatusBadgeCell extends Cell
{
    public $status;
    public $type;
    public function render() : string
    {
        switch ($this->status) {
            case STATUS_MENUNGGU_VALIDASI:
                $this->status = 'Menunggu Validasi';
                $this->type = 'warning';
                break;
            case STATUS_SELESAI:
                $this->status = 'Selesai';
                $this->type = 'success';
                break;
            case STATUS_DITOLAK:
                $this->status = 'Ditolak';
                $this->type = 'danger';
                break;
            case STATUS_SELESAI_BEASISWA:
                $this->status = 'Selesai (Beasiswa)';
                $this->type = 'success';
                break;
            default:
                $this->status = 'Belum Mengajukan';
                $this->type = 'secondary';
                break;
        }
        
        return $this->view('status_badge', [
            'status' => $this->status,
            'type' => $this->type
        ]);
    }
}
