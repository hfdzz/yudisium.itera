<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class YudisiumPendaftaran extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getMahasiswa() : ?UserEntity
    {
        return model('UserModel')->find($this->attributes['mahasiswa_id']);
    }

    public function getSuratKeterangan($jenis_sk)
    {
        /** @var \App\Entities\UserEntity $mahasiswa */
        $skModel = model('SuratKeteranganModel');

        switch ($jenis_sk) {
            case JENIS_SK_BEBAS_PERPUSTAKAAN:
                return $skModel->where('mahasiswa_id', $this->attributes['mahasiswa_id'])
                    ->where('jenis_surat', JENIS_SK_BEBAS_PERPUSTAKAAN)
                    ->first();
            case JENIS_SK_BEBAS_UKT:
                return $skModel->where('mahasiswa_id', $this->attributes['mahasiswa_id'])
                    ->where('jenis_surat', JENIS_SK_BEBAS_UKT)
                    ->first();
            case JENIS_SK_BEBAS_LABORATORIUM:
                return $this->mahasiswa->suratKeteranganBebasLaboratorium();
            default:
                return null;
        }
    }

    public function getPeninjau()
    {
        return model('UserModel')->find($this->attributes['peninjau_id']);
    }

    public function getYudisiumPeriode()
    {
        return model('YudisiumPeriodeModel')->where('id', $this->attributes['yudisium_periode_id'])->first();
    }

    public function getStatusText()
    {
        switch ($this->attributes['status']) {
            case STATUS_MENUNGGU_VALIDASI:
                return 'Menunggu Validasi';
            case STATUS_SELESAI:
                return 'Selesai';
            case STATUS_DITOLAK:
                return 'Ditolak';
            default:
                return 'STATUS ERROR';
        }
    }

    public function isSelesai()
    {
        return $this->attributes['status'] == STATUS_SELESAI;
    }

    public function updateStatus($status, $peninjau_id, $keterangan = null)
    {
        $model = model('YudisiumPendaftaranModel');
        $this->attributes['status'] = $status;
        $this->attributes['peninjau_id'] = $peninjau_id;
        $this->attributes['keterangan'] = $keterangan;
        $model->save($this);

        return $this;
    }

    public function terima($peninjau_id, $keterangan = null)
    {
        return $this->updateStatus(STATUS_SELESAI, $peninjau_id, $keterangan);
    }

    public function tolak($peninjau_id, $keterangan = null)
    {
        return $this->updateStatus(STATUS_DITOLAK, $peninjau_id, $keterangan);
    }

    // Update from peninjau's CRUD
    public function updateWithPeninjauId($data, $peninjau_id)
    {
        $model = model('YudisiumPendaftaranModel');
        $this->fill($data);
        $this->attributes['peninjau_id'] = $peninjau_id;
        $model->save($this);

        return $this;
    }

    public function canDafarYudisium()
    {
        return $this->attributes['status'] == null || $this->attributes['status'] == STATUS_DITOLAK;
    }

    public function getBerkasPath($jenis_berkas)
    {
        switch ($jenis_berkas) {
            case 'berkas_transkrip':
                return $this->attributes['berkas_transkrip'];
            case 'berkas_ijazah':
                return $this->attributes['berkas_ijazah'];
            case 'berkas_pas_foto':
                return $this->attributes['berkas_pas_foto'];
            case 'berkas_sertifikat_bahasa_inggris':
                return $this->attributes['berkas_sertifikat_bahasa_inggris'];
            case 'berkas_akta_kelahiran':
                return $this->attributes['berkas_akta_kelahiran'];
            case 'berkas_surat_keterangan_mahasiswa':
                return $this->attributes['berkas_surat_keterangan_mahasiswa'];
            case 'berkas_surat_keterangan_bebas_perpustakaan':
                return $this->attributes['berkas_surat_keterangan_bebas_perpustakaan'];
            case 'berkas_surat_keterangan_bebas_ukt':
                return $this->attributes['berkas_surat_keterangan_bebas_ukt'];
            case 'berkas_surat_keterangan_bebas_laboratorium':
                return $this->attributes['berkas_surat_keterangan_bebas_laboratorium'];
            default:
                return null;
        }
    }
}