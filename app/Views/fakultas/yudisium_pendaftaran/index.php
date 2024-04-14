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
            <h1>Kelola Yudisium Pendaftaran</h1>
        </div>
        <div class="d-flex justify-content-start align-items-center gap-2">
            <div class="d-flex gap-2">
                <form action="<?= site_url('fakultas/yudisium-pendaftaran') ?>" method="get" class="d-flex gap-2">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
            </div>
            <div class="d-flex gap-2">
                <form action="<?= site_url('fakultas/yudisium-pendaftaran') ?>" method="get" class="d-flex gap-2">
                    <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value=<?= STATUS_MENUNGGU_VALIDASI ?> <?= isset($_GET['status']) && $_GET['status'] == STATUS_MENUNGGU_VALIDASI ? 'selected' : '' ?>>Menunggu Validasi</option>
                        <option value=<?= STATUS_SELESAI ?> <?= isset($_GET['status']) && $_GET['status'] == STATUS_SELESAI ? 'selected' : '' ?>>Selesai</option>
                        <option value=<?= STATUS_DITOLAK ?> <?= isset($_GET['status']) && $_GET['status'] == STATUS_DITOLAK ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                </form>
            </div>
            <div class="d-flex gap-2">
                <form action="<?= site_url('fakultas/yudisium-pendaftaran') ?>" method="get" class="d-flex gap-2">
                    <select name="periode" id="periode" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Periode</option>
                        <?php foreach ($list_periode as $p) : ?>
                            <option value="<?= $p->id ?>" <?= isset($_GET['periode']) && $_GET['periode'] == $p->id ? 'selected' : '' ?>><?= $p->periode ?></option>
                        <?php endforeach ?>
                    </select>
                </form>
            </div>
        </div>
        <div>
            <?php if (isset($_GET['search']) && $_GET['search'] !== '') : ?>
                <span>Hasil pencarian untuk: <strong><?= $_GET['search']?></strong></span>
            <?php endif ?>
            <?php if (isset($_GET['status']) && $_GET['status'] !== '') : ?>
                <span>Hasil filter untuk: <strong><?= view_cell('StatusSuratKeterangan::renderBadge', ['status' => $_GET['status']]) ?></strong></span>
            <?php endif ?>
            <?php if (isset($_GET['periode']) && $_GET['periode'] !== '') : ?>
                <span>Hasil untuk periode: <strong><?= model('YudisiumPeriodeModel')->find($_GET['periode'])->periode ?></strong></span>
            <?php endif ?>
        </div>
        <div class="">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mahasiswa</th>
                        <th>Tanggal Penerimaan</th>
                        <th>Status</th>
                        <th>Peninjau</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($yudisium_pendaftaran as $index => $p) : ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <?= $p->mahasiswa->username ?>
                                <br>
                                <?= $p->mahasiswa->nim ?>
                            </td>
                            <td><?= $p->tanggal_penerimaan ?></td>
                            <td><?= view_cell('StatusSuratKeterangan::renderBadge', ['status' => $p->status]) ?></td>
                            <td>
                                <?= $p->peninjau?->username ?>
                                <br>
                                <?= $p->peninjau?->nip ?>
                            </td>
                            <td><?= $p->keterangan ?></td>
                            <td class="d-flex gap-1">
                                <a href="<?= site_url('fakultas/yudisium-pendaftaran/show/' . $p->id) ?>" class="btn btn-primary">Detail</a>
                                <a href="<?= site_url('fakultas/yudisium-pendaftaran/edit/' . $p->id) ?>" class="btn btn-warning">Edit</a>
                                <?= form_open('fakultas/yudisium-pendaftaran/delete/' . $p->id, ['onsubmit' => 'return confirm("Apakah Anda yakin ingin menghapus data ini?")', 'class' => 'd-inline']) ?>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                                <?= form_close() ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <a href="<?= site_url('fakultas/yudisium-pendaftaran/new') ?>" class="btn btn-primary">Tambah</a>
            
            <?= $pager->links() ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>