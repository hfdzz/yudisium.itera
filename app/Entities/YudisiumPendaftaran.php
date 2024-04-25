<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use Dompdf\Dompdf;

class YudisiumPendaftaran extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getMahasiswa() : ?UserEntity
    {
        return model('UserModel')->where('id', $this->attributes['mahasiswa_id'])->first();
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
        return model('UserModel')->where('id', $this->attributes['peninjau_id'])->first();
    }

    public function getYudisiumPeriode()
    {
        return model('YudisiumPeriodeModel')->where('id', $this->attributes['yudisium_periode_id'])->first();
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

    public function getJenis($humanize = false) : string
    {
        return 'Pendaftaran Yudisium';
    }

    public function isSelesai()
    {
        return $this->attributes['status'] == STATUS_SELESAI;
    }

    public function isMenungguValidasi()
    {
        return $this->attributes['status'] == STATUS_MENUNGGU_VALIDASI;
    }

    public function isDitolak()
    {
        return $this->attributes['status'] == STATUS_DITOLAK;
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

    public function saveUploadedFile($file, $jenis_berkas, $saveModel = false)
    {
        if (! $file->isValid()) {
            return false;
        }

        $path = $file->store(PATH_UPLOAD_PENDAFTARAN_YUDISIUM . '/' . date('Y-m') . '/' . $this->attributes['id'], $this->attributes['id'] . '_' . $jenis_berkas . '.pdf');

        $this->attributes[$jenis_berkas] = $path;

        return $saveModel ? model('YudisiumPendaftaranModel')->save($this) : true;
    }

    public function saveUploadedFiles($files, $saveModel = false)
    {
        foreach ($files as $jenis_berkas => $file) {
            $this->saveUploadedFile($file, $jenis_berkas, $saveModel);
        }

        return true;
    }

    public function generateSuratPdf() : ?string
    {
        $options = new \Dompdf\Options();    
        $options->set( 'chroot', 'kop.png' );
        $dompdf = new Dompdf( $options );

        $fmt = new \IntlDateFormatter('id_ID');
        $fmt->setPattern('d MMMM yyyy');

        $data = [
            'nama' => $this->getMahasiswa()->username,
            'nim' => $this->getMahasiswa()->nim,
            'program_studi' => $this->getMahasiswa()->program_studi,
            'tanggal' => $fmt->format(new \DateTime($this->attributes['tanggal_penerimaan'])),
            'kop_surat' => 'kop.png',
        ];

        $html = view('template_surat/tanda_terima_yudisium', $data);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $output = $dompdf->output();

        $path = PATH_TANDA_TERIMA_YUDISIUM . '/' . date('Y-m') . '/' . $this->attributes['id'] . '.pdf';

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
        return !empty($this->attributes['file_tanda_terima']) && file_exists(WRITEPATH . 'generated_files/' . $this->attributes['file_tanda_terima']);
    }

    public function getTandaTerimaPdf()
    {
        if (!$this->hasGeneratedPdf()) {
            $path = $this->generateSuratPdf();

            // update the file path if it's different
            if ($path !== $this->attributes['file_tanda_terima']) {
                $this->attributes['file_tanda_terima'] = $path;
                model('YudisiumPendaftaranModel')->save($this);
            }
        }

        return WRITEPATH . 'generated_files/' . $this->attributes['file_tanda_terima'];
    }
}