<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<a class="nav-item nav-link border border-primary<?= current_url(true)->getSegment(2) === 'validasi-surat-keterangan' ? ' active' : '' ?>"
    href="<?= route_to('keuangan.validasi_surat_keterangan')
    ?>">Validasi Surat Keterangan</a>

<a class="nav-item nav-link border border-primary<?= current_url(true)->getSegment(2) === 'bebas-perpustakaan' ? ' active' : '' ?>"
    href="<?= site_url('keuangan/bebas-ukt')
    ?>">Kelola Surat Keterangan Bebas UKT</a>