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
            <h1>Surat Keterangan Bebas UKT</h1>
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
                            <li>KHS</li>
                            <li>BA</li>
                            <li>Skirnsot AVITA</li>
                            <li>Sholat subuh</li>
                        </ol>
                    </div>
                </div>

                
                <?php if ($sk_bebas_ukt) : ?>

                <div class="d-flex">
                    <div>Status SK Bebas UKT</div>
                    <div class="d-flex align-items-center mx-2">
                        <?php if ($sk_bebas_ukt->status == STATUS_DITOLAK) : ?>
                            <span class="badge badge-pill px-2 badge-danger">Ditolak</span>
                        <?php elseif ($sk_bebas_ukt->status == STATUS_SELESAI) : ?>
                            <span class="badge badge-pill px-2 badge-success">Diterima</span>
                        <?php else : ?>
                            <span class="badge badge-pill px-2 badge-warning">Menunggu Persetujuan</span>
                        <?php endif ?>
                    </div>
                </div>
                <span><?= $sk_bebas_ukt->keterangan ?></span>

                <?php else : ?>

                <div>
                    <div>
                        <?= validation_list_errors() ?>
        
                        <?= form_open_multipart('/mahasiswa/sk-bebas-ukt') ?>
                        
                        <!-- berkas BA Sidang -->
                        <div class="form-group d-inline-block">
                            <label for="berkas_ba_sidang" class="form-label">Upload BA Sidang</label>
                            <input type="file" class="form-control-file" id="berkas_ba_sidang" name="berkas_ba_sidang">
                        </div>

                        <!-- berkas KHS -->
                        <div class="form-group d-inline-block">
                            <label for="berkas_khs" class="form-label">Upload KHS</label>
                            <input type="file" class="form-control-file" id="berkas_khs" name="berkas_khs">
                        </div>
                        
                        <!-- berkas bukti bayar AVITA -->
                        <div class="form-group d-inline-block">
                            <label for="berkas_bukti_bayar_avita" class="form-label">Upload Bukti Bayar AVITA</label>
                            <input type="file" class="form-control-file" id="berkas_bukti_bayar_avita" name="berkas_bukti_bayar_avita">
                        </div>

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