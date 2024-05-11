<?php

namespace App\Cells;

class LinkTextCell
{
    protected $suratNotUploadedHTML = '<span class="text-sm text-danger">Surat keterangan tidak ditemukan</span>';
    protected $fileNotUploadedHTML = '<span class="text-sm text-danger">File tidak ditemukan</span>'; 
    public function skLink($sk_id = null, $url = null)
    {
        if (!$sk_id) {
            return $this->suratNotUploadedHTML;
        }

        $url = $url ?? route_to('file_surat_keterangan', $sk_id);

        return sprintf('<a href="%s" target="_blank">Lihat</a>', $url);
    }

    public function bebasLabLink($sk_bebaslab = null)
    {
        if (!$sk_bebaslab) {
            return $this->suratNotUploadedHTML;
        }

        return sprintf('<a href="%s" target="_blank">Lihat</a>', $sk_bebaslab->surat);
    }

    public function uploadedFileUKTLink($path, $id, $jenis_berkas)
    {
        $url = route_to('berkas_bebas_ukt', $id, $jenis_berkas);

        if (!$path || !$url) {
            return $this->fileNotUploadedHTML;
        }

        return sprintf('<a href="%s" target="_blank">Lihat</a>', $url);
    }

    public function uploadedFileYudisiumLink($path, $id, $jenis_berkas)
    {
        $url = route_to('berkas_pendaftaran_yudisium', $id, $jenis_berkas);

        if (!$path || !$url) {
            return $this->fileNotUploadedHTML;
        }

        return sprintf('<a href="%s" target="_blank">Lihat</a>', $url);
    }
}
