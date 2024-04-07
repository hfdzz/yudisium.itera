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
            <h1>Edit Data Pendaftaran Yudisium</h1>
        </div>
        <div class="">
            <?= validation_list_errors() ?>

            <?= form_open_multipart('fakultas/yudisium-pendaftaran/update/' . $yudisium_pendaftaran->id) ?>

            <div class="mb-3">
                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="<?= STATUS_SELESAI ?>" <?= $yudisium_pendaftaran?->status == STATUS_SELESAI ? 'selected' : '' ?>>Selesai</option>
                        <option value="<?= STATUS_MENUNGGU_VALIDASI ?>" <?= $yudisium_pendaftaran?->status == STATUS_MENUNGGU_VALIDASI ? 'selected' : '' ?>>Menunggu Validasi</option>
                        <option value="<?= STATUS_DITOLAK ?>" <?= $yudisium_pendaftaran?->status == STATUS_DITOLAK ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                </div>
    
                <div class="form-group mb-3">
                    <label for="tanggal_penerimaan" class="form-label">Tanggal Penerimaan</label>
                    <input type="date" class="form-control" name="tanggal_penerimaan" id="tanggal_penerimaan" value="<?= $yudisium_pendaftaran?->tanggal_terbit ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3" style="resize:none;"><?= $yudisium_pendaftaran?->keterangan ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="peninjau_id" class="form-label">Peninjau</label>
                    <select class="form-control" name="peninjau_id" id="peninjau_id">
                        <option value="">Pilih Peninjau</option>
                        <?php foreach ($list_peninjau as $peninjau) : ?>
                            <option value="<?= $peninjau->id ?>" <?= $yudisium_pendaftaran?->peninjau_id == $peninjau->id ? 'selected' : '' ?>><?= $peninjau->username ?> (<?= $peninjau->nip ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= site_url('fakultas/yudisium-pendaftaran') ?>" class="btn btn-secondary">Kembali</a>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>