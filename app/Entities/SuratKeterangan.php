<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\HTTP\Files\UploadedFile;

class SuratKeterangan extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getMahasiswa() : ?\App\Entities\UserEntity
    {
        $user_model = model('UserModel');

        return $user_model->where('id', $this->attributes['mahasiswa_id'])
            ->first();
    }

    public function getPeninjau() : ?\App\Entities\UserEntity
    {
        $user_model = model('UserModel');

        return $user_model->where('id', $this->attributes['peninjau_id'])
            ->first();
    }

    public function getStatus($humanize = false) : string
    {
        if ($humanize) {
            switch ($this->attributes['status']) {
                case STATUS_MENUNGGU_VALIDASI:
                    return 'Menunggu Validasi';
                case STATUS_SELESAI:
                    return 'Selesai';
                case STATUS_DITOLAK:
                    return 'Ditolak';
                case STATUS_SELESAI_BEASISWA:
                    return 'Selesai (Beasiswa)';
            }
        }

        return $this->attributes['status'];
    }

    public function isSelesai() : bool
    {
        return $this->attributes['status'] == STATUS_SELESAI;
    }

    public function isBeasiswa() : bool
    {
        return $this->attributes['jenis_surat'] == JENIS_SK_BEBAS_UKT && $this->attributes['status'] == STATUS_SELESAI_BEASISWA;
    }

    public function isSelesaiOrBeasiswa() : bool
    {
        return $this->isSelesai() || $this->isBeasiswa();
    }

    public function canAjukan() : bool
    {
        return !$this->isSelesaiOrBeasiswa();
    }

    public function validasi($peninjau_id, $nomor_surat, $keterangan = null)
    {
        $this->attributes['peninjau_id'] = $peninjau_id;
        $this->attributes['nomor_surat'] = $nomor_surat;
        $this->attributes['status'] = STATUS_SELESAI;
        $this->attributes['keterangan'] = $keterangan;
        $this->attributes['tanggal_terbit'] = date('Y-m-d');

        return model('SuratKeteranganModel')->save($this);
    }

    public function tolak($peninjau_id, $keterangan = null)
    {
        $this->attributes['peninjau_id'] = $peninjau_id;
        $this->attributes['status'] = STATUS_DITOLAK;
        $this->attributes['keterangan'] = $keterangan;

        return model('SuratKeteranganModel')->save($this);
    }

    public function validasiBeasiswa($peninjau_id, $nomor_surat = null, $keterangan = null)
    {
        $this->attributes['peninjau_id'] = $peninjau_id;
        $this->attributes['nomor_surat'] = $nomor_surat;
        $this->attributes['status'] = STATUS_SELESAI_BEASISWA;
        $this->attributes['keterangan'] = $keterangan;

        return model('SuratKeteranganModel')->save($this);
    }

    public function generatePdf()
    {
        $dompdf = new \Dompdf\Dompdf();

        $data = [
            'surat_keterangan' => $this,
            'mahasiswa' => $this->getMahasiswa(),
            'peninjau' => $this->getPeninjau()
        ];

        $html = view('surat_keterangan/pdf', $data);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $output = $dompdf->output();

        $path = WRITEPATH . 'uploads/' . PATH_SK_BEBAS_UKT . '/' . date('Y-m') . '/' . $this->attributes['id'] . '.pdf';

        if (file_put_contents($path, $output)) {
            $this->attributes['file_surat_keterangan'] = $path;
            model('SuratKeteranganModel')->save($this);
        }

        return $path;
    }

    public function getSuratKeteranganPdf()
    {
        $path = WRITEPATH . 'uploads/' . $this->attributes['berkas_ba_sidang'];

        if (!file_exists($path)) {
            $path = $this->generatePdf();
        }

        return $path;
    }

    public function saveUploadedFile(UploadedFile $file, $jenis_berkas, $saveModel = false)
    {
        if (! $file->isValid()){
            return false;
        }
        
        $path = $file->store(PATH_UPLOAD_SK_BEBAS_UKT . '/' . date('Y-m'));

        $this->attributes[$jenis_berkas] = $path;

        return $saveModel ? model('SuratKeteranganModel')->save($this) : true;
    }

    public function saveUploadedFiles(array $files, $saveModel = false)
    {
        foreach ($files as $jenis_berkas => $file) {
            $this->saveUploadedFile($file, $jenis_berkas, $saveModel);
        }

        return true;
    }
}
