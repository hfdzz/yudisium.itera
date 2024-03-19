<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="p-4">
    <div class="rounded p-3" style="background-color: #f3f3f3;">
        <div>
            <h1>Tambah Data Pendaftaran Yudisium</h1>
        </div>
        <div class="">
            <?= validation_list_errors() ?>

            <?= form_open_multipart('mahasiswa/daftar-yudisium') ?>
            
            <?= form_close() ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>