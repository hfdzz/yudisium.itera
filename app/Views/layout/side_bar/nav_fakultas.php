<?php
    /**
     * @var \CodeIgniter\View\View $this
     */

    $links = [
        [
            'route_name' => 'fakultas.validasi_yudisium',
            'segment_name' => 'validasi-yudisium',
            'link_name' => 'Validasi Yudisium',
            'icon' => 'fa fa-check'
        ],
        [
            'route_name' => 'fakultas.yudisium_pendaftaran',
            'segment_name' => 'yudisium-pendaftaran',
            'link_name' => 'Kelola Data Yudisium',
            'icon' => 'fa fa-database'
        ],
        [
            'route_name' => 'fakultas.periode_yudisium',
            'segment_name' => 'periode-yudisium',
            'link_name' => 'Periode Yudisium',
            'icon' => 'fa fa-calendar'
        ],
    ]

?>

<?php foreach ($links as $link) : ?>
    <li class="nav-item">
        <a href="<?= route_to($link['route_name']) ?>"
        class="nav-link <?= current_url(true)->getSegment(2) === $link['segment_name'] ? ' aktif' : '' ?>"
        style="color: black;">
            <i class="nav-icon fas <?= $link['icon'] ?>"></i>
            <p>
                <?= $link['link_name'] ?>
            </p>
        </a>
    </li>
<?php endforeach; ?>