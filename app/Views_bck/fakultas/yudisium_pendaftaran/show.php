z<?php
    /**
     * @var \CodeIgniter\View\View $this
     */

?>

<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="p-4">
    <div class="rounded p-3" style="background-color: #f3f3f3;">
        <div>
            <h1>Detail Yudisium Pendaftaran</h1>
        </div>
        <div class="">
            <div class="mb-3">
                <div class="form-group mb-3">
                    <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                    <input type="text" class="form-control" name="nama_mahasiswa" id="nama_mahasiswa" value="<?= $yudisium_pendaftaran->mahasiswa->username ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" name="nim" id="nim" value="<?= $yudisium_pendaftaran->mahasiswa->nim ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="program_studi" class="form-label">Program Studi</label>
                    <input type="text" class="form-control" name="program_studi" id="program_studi" value="<?= $yudisium_pendaftaran->mahasiswa->program_studi ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <input type="text" class="form-control" name="status" id="status" value="<?= $yudisium_pendaftaran->getStatus(true) ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="tanggal_penerimaan" class="form-label">Tanggal Penerimaan</label>
                    <input type="date" class="form-control" name="tanggal_penerimaan" id="tanggal_penerimaan" value="<?= $yudisium_pendaftaran->tanggal_penerimaan ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3" style="resize:none;" readonly><?= $yudisium_pendaftaran->keterangan ?></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="peninjau" class="form-label">Peninjau</label>
                    <input type="text" class="form-control" name="peninjau" id="peninjau" value="<?= $yudisium_pendaftaran->peninjau?->username . ' (' . $yudisium_pendaftaran->peninjau?->nip . ')' ?>" readonly>
                </div>
                <div>
                    <label for="file" class="form-label">Berkas</label>
                    <div class="d-flex flex-column flex-shrink-1">
                        <a href="<?= route_to('berkas_pendaftaran_yudisium', $yudisium_pendaftaran->id, 'berkas_transkrip') ?>" target="_blank">Berkas Transkrip</a>
                        <a href="<?= route_to('berkas_pendaftaran_yudisium', $yudisium_pendaftaran->id, 'berkas_ijazah') ?>" target="_blank">Berkas Ijazah</a>
                        <a href="<?= route_to('berkas_pendaftaran_yudisium', $yudisium_pendaftaran->id, 'berkas_pas_foto') ?>" target="_blank">Berkas Pas Foto</a>
                        <a href="<?= route_to('berkas_pendaftaran_yudisium', $yudisium_pendaftaran->id, 'berkas_sertifikat_bahasa_inggris') ?>" target="_blank">Berkas Sertifikat Bahasa Inggris</a>
                        <a href="<?= route_to('berkas_pendaftaran_yudisium', $yudisium_pendaftaran->id, 'berkas_akta_kelahiran') ?>" target="_blank">Berkas Akta Kelahiran</a>
                        <a href="<?= route_to('berkas_pendaftaran_yudisium', $yudisium_pendaftaran->id, 'berkas_surat_keterangan_mahasiswa') ?>" target="_blank">Berkas Surat Keterangan Mahasiswa</a>
                        <a href="<?= route_to('file_tanda_terima_yudisium', $yudisium_pendaftaran->id) ?>" target="_blank" class="btn btn-primary">Tanda Terima Yudisium</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-start">
            <a href="<?= site_url('fakultas/yudisium-pendaftaran/edit/' . $yudisium_pendaftaran->id) ?>" class="btn btn-primary mr-1">Edit</a>
            <a href="<?= site_url('fakultas/yudisium-pendaftaran') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>