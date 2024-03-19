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
            <h1>Data Pendaftaran Yudisium</h1>
        </div>
        <div class="">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($yudisium_pendaftaran as $pendaftaran): ?>
                        <tr>
                            <td><?= $pendaftaran->id ?></td>
                            <td><?= $pendaftaran->mahasiswa()->nim ?></td>
                            <td><?= $pendaftaran->mahasiswa()->username ?></td>
                            <td><?= $pendaftaran->mahasiswa()->program_studi ?></td>
                            <td><?= $pendaftaran->created_at?></td>
                            <td>
                                <a href="<?= site_url('fakultas/yudisium-pendaftaran/edit/' . $pendaftaran->id) ?>" class="btn btn-primary">Edit</a>
                                <form action="<?= site_url('fakultas/yudisium-pendaftaran/delete/' . $pendaftaran->id) ?>" method="post" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
            <a href="<?= site_url('fakultas/yudisium-pendaftaran/new') ?>" class="btn btn-primary">Tambah</a>
            
            <?= $pager->links() ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>