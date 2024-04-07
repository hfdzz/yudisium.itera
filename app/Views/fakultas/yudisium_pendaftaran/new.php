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
            <h1>Tambah Data Yudisium Pendaftaran</h1>
        </div>
        <div class="">
            <?= validation_list_errors() ?>

            <?= form_open_multipart('fakultas/yudisium-pendaftaran/create') ?>

            <div class="mb-3">
                <div class="mb-3">
                    <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                    <input type="text" class="form-control" name="nama_mahasiswa" id="nama_mahasiswa" value="<?= old('nama_mahasiswa') ?>">
                </div>

                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" name="nim" id="nim" value="<?= old('nim') ?>">
                </div>

                <div class="mb-3">
                    <label for="program_studi" class="form-label">Program Studi</label>
                    <input type="text" class="form-control" name="program_studi" id="program_studi" value="<?= old('program_studi') ?>">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="<?= STATUS_MENUNGGU_VALIDASI ?>">Menunggu Validasi</option>
                        <option value="<?= STATUS_SELESAI ?>">Selesai</option>
                        <option value="<?= STATUS_DITOLAK ?>">Ditolak</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_penerimaan" class="form-label">Tanggal Penerimaan</label>
                    <input type="date" class="form-control" name="tanggal_penerimaan" id="tanggal_penerimaan" value="<?= old('tanggal_penerimaan') ?>">
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3" style="resize:none;"><?= old('keterangan') ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="peninjau" class="form-label">Peninjau</label>
                    <select class="form-control" name="peninjau" id="peninjau">
                        <option value="">Pilih Peninjau</option>
                        <?php foreach ($list_peninjau as $peninjau) : ?>
                            <option value="<?= $peninjau->id ?>"><?= $peninjau->username ?> (<?= $peninjau->nip ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3 row">
                    <div class="col">
                        <div class="mb-2">
                            <label for="berkas_transkrip" class="form-label">Berkas Transkrip</label>
                            <input class="form-control" type="file" name="berkas_transkrip" id="berkas_transkrip">
                        </div>
                        <div class="mb-2">
                            <label for="berkas_ijazah" class="form-label">Berkas Ijazah</label>
                            <input class="form-control" type="file" name="berkas_ijazah" id="berkas_ijazah">
                        </div>
                        <div class="mb-2">
                            <label for="berkas_pas_foto" class="form-label">Berkas Pas Foto</label>
                            <input class="form-control" type="file" name="berkas_pas_foto" id="berkas_pas_foto">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <label for="berkas_sertifikat_bahasa_inggris" class="form-label">Berkas Sertifikat Bahasa Inggris</label>
                            <input class="form-control" type="file" name="berkas_sertifikat_bahasa_inggris" id="berkas_sertifikat_bahasa_inggris">
                        </div>
                        <div class="mb-2">
                            <label for="berkas_akta_kelahiran" class="form-label">Berkas Akta Kelahiran</label>
                            <input class="form-control" type="file" name="berkas_akta_kelahiran" id="berkas_akta_kelahiran">
                        </div>
                        <div class="mb-2">
                            <label for="berkas_surat_keterangan_mahasiswa" class="form-label">Berkas Surat Keterangan Mahasiswa</label>
                            <input class="form-control" type="file" name="berkas_surat_keterangan_mahasiswa" id="berkas_surat_keterangan_mahasiswa">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= site_url('fakultas/yudisium-pendaftaran') ?>" class="btn btn-secondary">Kembali</a>
                </div>
                
            </div>
            
            <?= form_close() ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>