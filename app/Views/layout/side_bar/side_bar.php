<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 bg-warna">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>" class="brand-link pb-0 mb-0">
        <img src="<?= base_url('assets/img/logo_fti.png') ?>" alt="Logo" class="brand-image img-circle elevation-3 border">
        <span class="brand-text font-weight-light">
        <div style="font-size: 12px; color: black; font-weight: bold">Fakultas Teknologi Industri</div>
        <div style="font-size: 10px; color: black; font-weight: bold">Sistem Informasi Manajeman Yudisium</div>
    </span>
    <hr>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="<?= route_to('mahasiswa.dashboard') ?>"
                class="nav-link <?= current_url(true)->getSegment(2) === '' ? 'aktif' : '' ?> "
                style="color: black;">
                    <i class="nav-icon fas fa-home"></i>
                    <p>
                    Dashboard
                    </p>
                </a>
            </li>

            <?php if (auth()->user()->inGroup('user_mahasiswa')) : ?>
                <?= $this->include('layout/side_bar/nav_mahasiswa') ?>
            <?php endif ?>

            <?php if (auth()->user()->inGroup('user_fakultas')) : ?>
                <?= $this->include('layout/side_bar/nav_fakultas') ?>
            <?php endif ?>
                
            <?php if (auth()->user()->inGroup('user_upt_perpustakaan')) : ?>
                <?= $this->include('layout/side_bar/nav_upt_perpustakaan') ?>
            <?php endif ?>

            <?php if (auth()->user()->inGroup('user_keuangan')) : ?>
                <?= $this->include('layout/side_bar/nav_keuangan') ?>
            <?php endif ?>

            <?php if (auth()->user()->inGroup('admin')) : ?>
                <?= $this->include('layout/side_bar/nav_admin') ?>
            <?php endif ?>

            <li class="nav-item">
                <a href="<?= route_to('logout') ?>"
                class="nav-link"
                style="color: black;">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>
                    Logout
                    </p>
                </a>
            </li>
        </ul>
        </nav>
    </div>
</aside>