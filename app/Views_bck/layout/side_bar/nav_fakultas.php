<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<a class="nav-item nav-link border border-primary<?= current_url(true)->getSegment(2) === 'validasi-yudisium' ? ' active' : '' ?>"
    href="<?= route_to('fakultas.validasi_yudisium')
    ?>">Validasi Yudisium</a>
    
<a class="nav-item nav-link border border-primary<?= current_url(true)->getSegment(2) === 'periode-yudisium' ? ' active' : '' ?>"
    href="<?= route_to('fakultas.periode_yudisium')
    ?>">Periode Yudisium</a>

<a class="nav-item nav-link border border-primary<?= current_url(true)->getSegment(2) === 'yudisium-pendaftaran' ? ' active' : '' ?>"
    href="<?= site_url('fakultas/yudisium-pendaftaran')
    ?>">Pendaftaran Yudisium</a>