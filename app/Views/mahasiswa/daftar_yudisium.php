<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="p-4">

    <?php if (isset($yudisium_pendaftaran) && $yudisium_pendaftaran->isSelesai()): ?>
        <div class="alert alert-success" role="alert">
            <p>Yudisium anda telah selesai.</p>
            <a href="<?= route_to('file_tanda_terima_yudisium', $yudisium_pendaftaran->id) ?>" class="btn btn-primary" target="_blank">Lihat Tanda Terima Yudisium</a>
        </div>

    <?php elseif ($yudisium_periode?->isOpen()): ?>

        <div class="rounded p-3" style="background-color: #f3f3f3;">
            <div>
                <h1>Daftar Yudisium</h1>
                <h3>Periode: <?= esc($yudisium_periode->getHumanizedPeriodeName()) ?></h3>
            </div>
            <div class="">
    
                <?php if ($yudisium_periode->canDaftarYudisium(auth()->user()->id)): ?>
    
                <div>
                    <?= validation_list_errors() ?>
    
                    <?= form_open_multipart('mahasiswa/daftar-yudisium') ?>
                    <div class="row">
                        <div class="col-6">
                            <div>
                                <!-- berkas transkrip -->
                                <div class="form-group d-inline-block">
                                    <label for="berkas_transkrip" class="form-label">Upload Transkrip</label>
                                    <input type="file" class="form-control-file" id="berkas_transkrip" name="berkas_transkrip" accept="application/pdf" >
                                </div>
                
                                <!-- berkas ijazah -->
                                <div class="form-group d-inline-block">
                                    <label for="berkas_ijazah" class="form-label">Upload Ijazah</label>
                                    <input type="file" class="form-control-file" id="berkas_ijazah" name="berkas_ijazah" >
                                </div>
                
                                <!-- berkas pas foto -->
                                <div class="form-group d-inline-block">
                                    <label for="berkas_pas_foto" class="form-label">Upload Pas Foto</label>
                                    <input type="file" class="form-control-file" id="berkas_pas_foto" name="berkas_pas_foto" >
                                </div>
                
                                <!-- berkas sertifikat bahasa inggris -->
                                <div class="form-group d-inline-block">
                                    <label for="berkas_sertifikat_bahasa_inggris" class="form-label">Upload Sertifikat Bahasa Inggris</label>
                                    <input type="file" class="form-control-file" id="berkas_sertifikat_bahasa_inggris" name="berkas_sertifikat_bahasa_inggris" >
                                </div>
                
                                <!-- berkas akta kelahiran -->
                                <div class="form-group d-inline-block">
                                    <label for="berkas_akta_kelahiran" class="form-label">Upload Akta Kelahiran</label>
                                    <input type="file" class="form-control-file" id="berkas_akta_kelahiran" name="berkas_akta_kelahiran">
                                </div>
                
                                <!-- berkas berkas surat keterangan mahasiswa -->
                                <div class="form-group d-inline-block">
                                    <label for="berkas_surat_keterangan_mahasiswa" class="form-label">Upload Surat Keterangan Mahasiswa</label>
                                    <input type="file" class="form-control-file" id="berkas_surat_keterangan_mahasiswa" name="berkas_surat_keterangan_mahasiswa">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <!-- SK Bebas Laboratorium -->
                                <div class="mb-3">
                                    <div>Surat Keterangan Bebas Laboratorium</div>
    
                                    <?= view_cell('StatusSuratKeterangan::renderBadge', ['status' => $sk_bebas_lab->status ?? '']) ?>
    
                                    <?php if ($sk_bebas_lab?->status == STATUS_SELESAI): ?>

                                        <a href="<?= esc($sk_bebas_lab->surat) ?>" target="_blank" class="link">Lihat Surat</a>

                                    <?php else: ?>

                                        <a href="http://silabor.itera.ac.id" target="_blank" class="link">Ajukan Surat</a>
                                        
                                    <?php endif ?>
                                </div>
    
                                <!-- SK Bebas Perpustakaan -->
                                <div class="mb-3">
                                    <div>Surat Keterangan Bebas Perpustakaan</div>
                                    
                                    <?= view_cell('StatusSuratKeterangan::renderBadgeAndLink', ['status' => $sk_bebas_perpustakaan->status ?? '', 'url' => route_to('mahasiswa.sk_bebas_perpustakaan'), 'target' => '_self']) ?>
                                </div>
    
                                <!-- SK Bebas UKT -->
                                <div class="mb-3">
                                    <div>Surat Keterangan Bebas UKT</div>
                                    
                                    <?= view_cell('StatusSuratKeterangan::renderBadgeAndLink', ['status' => $sk_bebas_ukt->status ?? '', 'url' => route_to('mahasiswa.sk_bebas_ukt'), 'target' => '_self']) ?>
                                </div>
                            </div>
                            <?php if (isset($yudisium_pendaftaran->keterangan)) : ?>
                                <div class="alert alert-warning" role="alert">
                                    <div>
                                        <span><?= $yudisium_pendaftaran->status == 'ditolak' ? 'Pendaftaran Yudisium ditolak.' : '' ?></span>
                                        <br>
                                        <span>Keterangan:</span>
                                    </div>
                                    <p><?= esc($yudisium_pendaftaran->keterangan) ?></p>
                                </div>
                            <?php endif ?>
                            <div>
                                <button type="submit" class="btn btn-primary">Daftar Yudisium</button>
                                <button type="button" class="btn btn-secondary" onclick="confirm('Clear form?') && this.form.reset()">Clear</button> 
                            </div>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
    
                <?php else: ?>
                    <div class="alert alert-info" role="alert">
                        <p>Anda sudah mendaftar yudisium.</p>
                    </div>
                    <div>
                        <p>Status Pendaftaran:</p>
                        <?= view_cell('StatusSuratKeterangan::renderBadgeAndLink', ['status' => $yudisium_pendaftaran->status ?? '', 'url' => ''] ) ?>
                    </div>
                <?php endif ?>
    
            </div>
        </div>

    <?php else : ?>
        
        <div class="alert alert-info" role="alert">
            <p>Pendaftaran yudisium belum dibuka.</p>
        </div>


    <?php endif ?>

</div>
<?= $this->endSection() ?>