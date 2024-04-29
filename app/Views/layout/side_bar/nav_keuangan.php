<?php
    /**
     * @var \CodeIgniter\View\View $this
     */

    $links = [
        [
            'route_name' => 'keuangan.dashboard',
            'segment_name' => '',
            'link_name' => 'Dashboard',
            'icon' => 'fa fa-home'
        ],
        [
            'route_name' => 'keuangan.validasi_surat_keterangan',
            'segment_name' => 'validasi-surat-keterangan',
            'link_name' => 'Validasi Berkas',
            'icon' => 'fa fa-check'
        ],
        [
            'route_name' => 'keuangan/bebas-ukt',
            'segment_name' => 'bebas-ukt',
            'link_name' => 'Kelola Data Bebas UKT',
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