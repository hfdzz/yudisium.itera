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
            <h1>Daftar Yudisium</h1>
        </div>
        <div class="">
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
                                <div class="d-flex align-items-center">
                                    <div style="width: 20px; height: 20px; border: 1px solid #aaa; border-radius: 3px; line-height:1px" class="mr-1 bg-light">
                                    </div>
                                    <div>Belum Mengajukan</div>
                                </div>
                                <a href="https://silabor.itera.ac.id" class="mx-1" target="_blank">Ajukan</a>
                            </div>
                            <!-- SK Bebas Perpustakaan -->
                            <div class="mb-3">
                                <div>Surat Keterangan Bebas Perpustakaan</div>
                                <div class="d-flex align-items-center">
                                    <div style="width: 20px; height: 20px; border: 1px solid #aaa; border-radius: 3px;" class="mr-1 bg-light"></div>
                                    <div>Belum Mengajukan</div>
                                </div>
                                <a href="<?= route_to('mahasiswa.sk_bebas_perpustakaan') ?>" class="mx-1">Ajukan</a>
                            </div>
                            <!-- SK Bebas Perpustakaan -->
                            <div class="mb-3">
                                <div>Surat Keterangan Bebas UKT</div>
                                <div class="d-flex align-items-center">
                                    <div style="width: 20px; height: 20px; border: 1px solid #aaa; border-radius: 3px;" class="mr-1 bg-light"></div>
                                    <div>Belum Mengajukan</div> 
                                </div>
                                <a href="<?= route_to('mahasiswa.sk_bebas_ukt') ?>" class="mx-1">Ajukan</a>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Daftar Yudisium</button>
                            <button type="button" class="btn btn-secondary" onclick="confirm('Clear form?') && this.form.reset()">Clear</button> 
                        </div>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>