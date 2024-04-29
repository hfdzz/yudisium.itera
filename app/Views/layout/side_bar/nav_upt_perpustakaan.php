<?php
    /**
     * @var \CodeIgniter\View\View $this
     */

    $links = [
        [
            'route_name' => 'upt_perpustakaan.dashboard',
            'segment_name' => '',
            'link_name' => 'Dashboard',
            'icon' => 'fa fa-home'
        ],
        [
            'route_name' => 'upt_perpustakaan.validasi_surat_keterangan',
            'segment_name' => 'validasi-surat-keterangan',
            'link_name' => 'Validasi Berkas',
            'icon' => 'fa fa-check'
        ],
        [
            'route_name' => 'upt_perpustakaan/bebas-perpustakaan',
            'segment_name' => 'bebas-perpustakaan',
            'link_name' => 'Kelola Data Bebas Perpustakaan',
            'icon' => 'fa fa-database'
        ],
    ];
?>
    
<?php foreach ($links as $link) : ?>
    <li class="nav-item">
        <a href="<?= route_to($link['route_name']) ?? site_url($link['route_name']) ?>"
        class="nav-link <?= current_url(true)->getSegment(2) === $link['segment_name'] ? ' aktif' : '' ?>"
        style="color: black;">
            <i class="nav-icon fas <?= $link['icon'] ?>"></i>
            <p>
                <?= $link['link_name'] ?>
            </p>
        </a>
    </li>
<?php endforeach; ?>