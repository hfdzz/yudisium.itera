<?php
    /**
     * @var \CodeIgniter\View\View $this
     */

     
     /**
      * $links
      * [
      *   'route_name' => 'route_name',
      *   'segment_name' => 'segment_name',
      *   'icon' => 'icon']]
      * ]
      */

    $links = [
        [
            'route_name' => 'mahasiswa.daftar_yudisium',
            'segment_name' => 'daftar-yudisium',
            'link_name' => 'Pendaftaran Yudisium',
            'icon' => 'fa fa-chart-bar'
        ],
        [
            'route_name' => 'mahasiswa.sk_bebas_perpustakaan',
            'segment_name' => 'sk-bebas-perpustakaan',
            'link_name' => 'Bebas Perpustakaan',
            'icon' => 'fa fa-file-upload'
        ],
        [
            'route_name' => 'mahasiswa.sk_bebas_ukt',
            'segment_name' => 'sk-bebas-ukt',
            'link_name' => 'Bebas UKT',
            'icon' => 'fa fa-file-upload'
        ],
        [
            'route_name' => 'mahasiswa.status_yudisium',
            'segment_name' => 'status-yudisium',
            'link_name' => 'Cek Status Pendaftaran',
            'icon' => 'fa fa-user'
        ]
        
    ];
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