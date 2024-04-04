<?php

namespace App\Cells;

class LinkTextCell
{
    public function skLink($sk_id = null, $url = null)
    {
        if (!$sk_id) {
            return '<span class="text-danger">Surat Keterangan Tidak Ditemukan</span>';
        }

        $url = $url ?? route_to('file_surat_keterangan', $sk_id);

        return sprintf('<a href="%s" target="_blank">Lihat</a>', $url);
    }

    public function bebasLabLink($sk_bebaslab = null)
    {
        if (!$sk_bebaslab) {
            return '<span class="text-danger">Surat Keterangan Tidak Ditemukan</span>';
        }

        return sprintf('<a href="%s" target="_blank">Lihat</a>', $sk_bebaslab->surat);
    }
}
