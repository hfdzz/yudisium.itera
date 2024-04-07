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