<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<a class="nav-item nav-link border border-primary<?= current_url(true)->getSegment(2) === 'daftar-yudisium' ? ' active' : '' ?>"
    href="<?= route_to('mahasiswa.daftar_yudisium') 
    ?>">Daftar Yudisium</a>
<a class="nav-item nav-link border border-primary<?= current_url(true)->getSegment(2) === 'sk-bebas-perpustakaan' ? ' active' : '' ?> "
    href="<?= route_to('mahasiswa.sk_bebas_perpustakaan')
    ?>">SK Bebas Perpustakaan</a>
<a class="nav-item nav-link border border-primary<?= current_url(true)->getSegment(2) === 'sk-bebas-ukt' ? ' active' : '' ?> "
    href="<?= route_to('mahasiswa.sk_bebas_ukt')
    ?>">SK Bebas UKT</a>
<a class="nav-item nav-link border border-primary<?= current_url(true)->getSegment(2) === 'status-yudisium' ? ' active' : '' ?> "
    href="<?= route_to('mahasiswa.status_yudisium')
    ?>">Status Yudisium</a>