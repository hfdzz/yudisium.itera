<?php
    
namespace App\Cells;


// <div>Surat Keterangan Bebas Perpustakaan</div>
// <div class="d-flex align-items-center">
//     <div style="width: 20px; height: 20px; border: 1px solid #aaa; border-radius: 3px;" class="mr-1 bg-light"></div>
//     <div>Belum Mengajukan</div>
// </div>
// <a href="<?= route_to('mahasiswa.sk_bebas_perpustakaan') \?\>" class="mx-1">Ajukan</a>

class StatusSuratKeterangan
{
    protected $badgeTemplate = '<span class="badge p-1 bg-%s text-light">%s</span>';
    protected $linkTemplate = '<a href="%s" class="mx-1" target="%s">%s</a>';

    public function renderBadge($status)
    {
        switch ($status) {
            case STATUS_SELESAI:
                return sprintf($this->badgeTemplate, 'success', 'Selesai');
            case STATUS_DITOLAK:
                return sprintf($this->badgeTemplate, 'danger', 'Ditolak');
            case STATUS_MENUNGGU_VALIDASI:
                return sprintf($this->badgeTemplate, 'warning', 'Menunggu Validasi');
            case STATUS_SELESAI_BEASISWA:
                return sprintf($this->badgeTemplate, 'info', 'Selesai (Beasiswa)');

            default:
                return sprintf($this->badgeTemplate, 'secondary', 'Belum Mengajukan');
        }
    }

    public function renderLink($status, $url, $url2 = null, $target = '_blank')
    {
        // only if status is not 'Selesai' or 'Menunggu Validasi'
        if ($status == STATUS_SELESAI) {
            return sprintf($this->linkTemplate, $url2, $target, 'Lihat Surat Keterangan');
        } else if ($status == STATUS_DITOLAK || $status == STATUS_MENUNGGU_VALIDASI || $status == STATUS_SELESAI_BEASISWA) {
            return '';
        }
        
        return sprintf($this->linkTemplate, $url, $target, 'Ajukan');
    }

    public function renderBadgeAndLink($status, $url, $url2 = null, $target = '_blank')
    {
        return $this->renderBadge($status) . $this->renderLink($status, $url, $url2, $target);
    }
}