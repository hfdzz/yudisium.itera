<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<div class="" style="background-color:#e5e5e5; width:100%; height:100%;">
    <!-- use profile -->
    <div class="p-3" style="border-bottom: 1px solid #000000;">
        <div><?= auth()->user()->email ?></div>
        <div>
            <?php if (auth()->user()->nip) : ?>
                <div>NIP: <?= auth()->user()->nip ?></div>
            <?php endif ?>

            <?php if (auth()->user()->inGroup('user_mahasiswa')) : ?>
                <div>
                    <div><?= auth()->user()->nim ?></div>
                    <div><?= ucwords(auth()->user()->program_studi) ?></div>
                </div>
            <?php endif ?>
        </div>
    </div>

    <!-- Links -->
    <div class="p-3 d-flex flex-column nav nav-pills" style="gap:6px">
        <a class="nav-item nav-link border border-primary <?= current_url(true)->getSegment(2) === '' ? 'active' : '' ?> "
            href="<?= route_to('mahasiswa.dashboard')
            ?>">Dashboard</a>

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
        
    </div>
</div>