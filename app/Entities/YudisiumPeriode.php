<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class YudisiumPeriode extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function yudisiumPeriodeInformasi()
    {
        return model('YudisiumPeriodeInformasiModel')->where('yudisium_periode_id', $this->attributes['id'])->findAll();
    }

    public function clearInformasi()
    {
        model('YudisiumPeriodeInformasiModel')->where('yudisium_periode_id', $this->attributes['id'])->delete();
    }

    public function yudisiumPendaftaran()
    {
        return model('YudisiumPendaftaran')->where('periode_id', $this->attributes['id'])->findAll();
    }

    public function isOpen() : bool
    {
        return $this->attributes['tanggal_awal'] <= date('Y-m-d') && $this->attributes['tanggal_akhir'] >= date('Y-m-d');
    }

    public function isAlreadyDaftar($mahasiswa_id) : bool
    {
        return model('YudisiumPendaftaranModel')->where('yudisium_periode_id', $this->attributes['id'])
        ->where('mahasiswa_id', $mahasiswa_id)
        ->where('status !=', STATUS_DITOLAK)
        ->countAllResults() > 0;
    }

    public function canDaftarYudisium(int $mahasiswa_id) : bool
    {
        return $this->isOpen() && ! $this->isAlreadyDaftar($mahasiswa_id);
    }

    public function daftarYudisium($data)
    {
        if ( $this->canDaftarYudisium($data['mahasiswa_id']) ) {

            return model('YudisiumPendaftaranModel')->daftarYudisiumMahasiswa($data);

        }

        throw new \Exception('Tidak bisa mendaftar yudisium pada periode ini. Periode sudah ditutup atau sudah mendaftar sebelumnya.');
    }

    public function getCurrentYudisiumPendaftaran($mahasiswa_id) : ?\App\Entities\YudisiumPendaftaran
    {
        return model('YudisiumPendaftaranModel')->where('yudisium_periode_id', $this->attributes['id'])
            ->where('mahasiswa_id', $mahasiswa_id)
            ->first();
    }

    public function getHumanizedPeriodeName()
    {
        // split attribute periode by '/' (month/year)
        $periode = explode('/', $this->attributes['periode']);
        
        // get month name from the first element of the array
        $month = date('F', strtotime('2021-' . $periode[0] . '-01'));

        // return the humanized periode name
        return $month . ' ' . $periode[1];
    }
}
