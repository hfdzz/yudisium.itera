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
            <h1>SK Bebas Perpustakaan</h1>
        </div>
        <div class="">
            <!-- SK Bebas Laboratorium -->
            <div class="mb-3">
                <div>
                    <div>
                        Pastikan Anda sudah melakukan hal-hal berikut:
                    </div>
                    <div>
                        <ol>
                            <li>Mengunggah skripsi ke repositori ITERA <a href="https://repo.itera.ac.id/" target="_blank">https://repo.itera.ac.id</a></li>
                            <li>Menyerahkan cetak fisik (hardocpy) skripsi ke perpustakaan</li>
                            <li>Sholat subuh</li>
                        </ol>
                    </div>
                </div>
                <?php if ($sk_bebas_perpustakaan) : ?>
                    <div class="d-flex">
                        <div>Status SK Bebas Perpustakaan</div>
                        <div class="d-flex align-items-center mx-2">
                            <?php if ($sk_bebas_perpustakaan->status == STATUS_DITOLAK) : ?>
                                <span class="badge badge-pill px-2 badge-danger">Ditolak</span>
                            <?php elseif ($sk_bebas_perpustakaan->status == STATUS_SELESAI) : ?>
                                <span class="badge badge-pill px-2 badge-success">Diterima</span>
                            <?php else : ?>
                                <span class="badge badge-pill px-2 badge-warning">Menunggu Persetujuan</span>
                            <?php endif ?>
                        </div>
                    </div>
                    <span><?= $sk_bebas_perpustakaan->keterangan ?></span>
                <?php else : ?>
                    <div>
                        <div class="d-flex">
                            <div>Syarat Bebas Repositori ITERA</div>
                            <div class="d-flex align-items-center mx-2">
                                <?php if ($status_repo) : ?>
                                    <span class="badge badge-pill px-2 badge-success">Selesai</span>
                                <?php else : ?>
                                    <span class="badge badge-pill px-2 badge-danger">Belum Selesai</span>
                                <?php endif ?>
                            </div>
                        </div>
                        <div>
                            <?= validation_list_errors() ?>
            
                            <?= form_open('mahasiswa/sk-bebas-perpustakaan') ?>
                            
                            <button type="submit" class="btn btn-primary">
                                Ajukan SK Bebas Perpustakaan
                            </button>
            
                            <?= form_close() ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>