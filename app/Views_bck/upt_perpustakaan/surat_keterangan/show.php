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
            <h1>Detail Surat Keterangan Bebas Perpustakaan</h1>
        </div>
        <div class="">
            <div class="mb-3">
                <div class="form-group mb-3">
                    <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                    <input type="text" class="form-control" name="nama_mahasiswa" id="nama_mahasiswa" value="<?= $sk_bebas_perpustakaan->mahasiswa->username ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" name="nim" id="nim" value="<?= $sk_bebas_perpustakaan->mahasiswa->nim ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="program_studi" class="form-label">Program Studi</label>
                    <input type="text" class="form-control" name="program_studi" id="program_studi" value="<?= $sk_bebas_perpustakaan->mahasiswa->program_studi ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <input type="text" class="form-control" name="status" id="status" value="<?= $sk_bebas_perpustakaan->getStatus(true) ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="nomor_surat" class="form-label">Nomor Surat</label>
                    <input type="text" class="form-control" name="nomor_surat" id="nomor_surat" value="<?= $sk_bebas_perpustakaan->nomor_surat ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                    <input type="date" class="form-control" name="tanggal_terbit" id="tanggal_terbit" value="<?= $sk_bebas_perpustakaan->tanggal_terbit ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3" style="resize:none;" readonly><?= $sk_bebas_perpustakaan->keterangan ?></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="peninjau" class="form-label">Peninjau</label>
                    <input type="text" class="form-control" name="peninjau" id="peninjau" value="<?= $sk_bebas_perpustakaan->peninjau?->username . ' (' . $sk_bebas_perpustakaan->peninjau?->nip . ')' ?>" readonly>
                </div>
                <div>
                    <label for="file" class="form-label">Berkas</label>
                    <div class="d-flex flex-column flex-shrink-1">
                        <a href="<?= site_url('file-surat-keterangan/' . $sk_bebas_perpustakaan->id) ?>" target="_blank" class="btn btn-primary mt-2">Lihat Surat Keterangan</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-start">
            <a href="<?= site_url('upt_perpustakaan/bebas-perpustakaan/edit/' . $sk_bebas_perpustakaan->id) ?>" class="btn btn-primary mr-1">Edit</a>
            <a href="<?= site_url('upt_perpustakaan/bebas-perpustakaan') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>