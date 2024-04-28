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

                <?php if ($sk_bebas_perpustakaan && !$sk_bebas_perpustakaan->canAjukan()) : ?>

                    <div class="d-flex">
                        <div>Status SK Bebas Perpustakaan</div>
                        <div class="d-flex align-items-center mx-2">

                            <?= view_cell('StatusSuratKeterangan::renderBadge', ['status' => $sk_bebas_perpustakaan->status]) ?>

                            <?= $sk_bebas_perpustakaan ? view_cell('\App\Cells\StatusSuratKeterangan::renderLink', ['status' => $sk_bebas_perpustakaan->status, 'url' => route_to('file_surat_keterangan', $sk_bebas_perpustakaan->id)] ) : ''?>
                        </div>
                    </div>
                    <span><?= $sk_bebas_perpustakaan->keterangan ?></span>

                <?php else : ?>

                    <div>
                        <div class="mb-1">
                            <?= view_cell('StatusSuratKeterangan::renderBadge', ['status' => $sk_bebas_perpustakaan?->status]) ?>
                        </div>

                        <?php if($sk_bebas_perpustakaan) : ?>
                        <div class="mb-1">
                            <div>
                                Keterangan:
                            </div>
                            <div class="mb-2 border border-info p-2 bg-light rounded">
                                <?= $sk_bebas_perpustakaan?->keterangan?>
                            </div>
                        </div>
                        <?php endif ?>

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