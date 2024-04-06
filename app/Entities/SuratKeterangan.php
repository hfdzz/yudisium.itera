<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\HTTP\Files\UploadedFile;
use Dompdf\Dompdf;

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

    public function isWaitingValidation() : bool
    {
        return $this->attributes['status'] == STATUS_MENUNGGU_VALIDASI;
    }

    public function canAjukan() : bool
    {
        return !$this->isSelesaiOrBeasiswa() && !$this->isWaitingValidation();
    }

    public function validasi($peninjau_id, $nomor_surat, $keterangan = null)
    {
        $this->attributes['peninjau_id'] = $peninjau_id;
        $this->attributes['nomor_surat'] = $nomor_surat;
        $this->attributes['status'] = STATUS_SELESAI;
        $this->attributes['keterangan'] = $keterangan;
        $this->attributes['tanggal_terbit'] = date('Y-m-d');

        $sk_file_path = $this->generateSuratPdf();

        $this->attributes['file_surat_keterangan'] = $sk_file_path ?? null;

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

        $sk_file_path = $this->generateSuratPdf();

        $this->attributes['file_surat_keterangan'] = $sk_file_path ?? null;

        return model('SuratKeteranganModel')->save($this);
    }

    public function saveUploadedFile(UploadedFile $file, $jenis_berkas, $saveModel = false)
    {
        if (! $file->isValid()){
            return false;
        }
        
        $path = $file->store(PATH_UPLOAD_SK_BEBAS_UKT . '/' . date('Y-m'), $this->attributes['id'] . '_' . $jenis_berkas . '.pdf');

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

    public function getBerkasPath($jenis_berkas)
    {
        return $this->attributes[$jenis_berkas];
    }

    public function generateSuratPdf() : ?string
    {
        $options = new \Dompdf\Options();    
        $options->set( 'chroot', 'kop.png' );
        $dompdf = new Dompdf( $options );
        
        $fmt = new \IntlDateFormatter('id_ID');
        $fmt->setPattern('  d MMMM yyyy');

        $data = [
            'nama' => $this->getMahasiswa()->username,
            'nim' => $this->getMahasiswa()->nim,
            'program_studi' => $this->getMahasiswa()->program_studi,
            'mahasiswa' => $this->getMahasiswa(),
            'peninjau' => $this->getPeninjau(),
            'nomor_surat' => $this->attributes['nomor_surat'],
            'tanggal' => $fmt->format(new \DateTime($this->attributes['tanggal_terbit'])),
        ];

        switch($this->attributes['jenis_surat']) {
            case JENIS_SK_BEBAS_PERPUSTAKAAN:
                $html = view('template_surat/bebas_perpustakaan', $data);
                break;
            case JENIS_SK_BEBAS_UKT:
                $html = view('template_surat/bebas_ukt', $data);
                break;
            default:
                throw new \Exception('Jenis surat tidak valid.');
        }

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $output = $dompdf->output();

        $path = $this->attributes['jenis_surat'] . '/' . date('Y-m') . '/' . $this->attributes['id'] . '.pdf';

        if(!is_dir(dirname(WRITEPATH . 'generated_files/' . $path))) {
            mkdir(dirname(WRITEPATH . 'generated_files/' . $path), 0777, true);
        }

        if (file_put_contents(WRITEPATH . 'generated_files/' . $path, $output)) {
            return $path;
        }

        return false;
    }

    public function hasGeneratedPdf()
    {
        return !empty($this->attributes['file_surat_keterangan']) && file_exists(WRITEPATH . 'generated_files/' . $this->attributes['file_surat_keterangan']);
    }

    public function getSuratKeteranganPdf()
    {
        if (!$this->hasGeneratedPdf()) {
            $path = $this->generateSuratPdf();

            // update the file path if it's different
            if ($path !== $this->attributes['file_surat_keterangan']) {
                $this->attributes['file_surat_keterangan'] = $path;
                model('SuratKeteranganModel')->save($this);
            }
        }

        return WRITEPATH . 'generated_files/' . $this->attributes['file_surat_keterangan'];
    }
}
