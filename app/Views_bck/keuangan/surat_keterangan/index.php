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
            <h1>Kelola Surat Keterangan Bebas UKT</h1>
        </div>
        <div class="">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mahasiswa</th>
                        <th>Nomor Surat</th>
                        <th>Tanggal Terbit</th>
                        <th>Status</th>
                        <th>Peninjau</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sk_bebas_perpustakaan as $index => $p) : ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <?= $p->mahasiswa_name ?>
                                <br>
                                <?= $p->mahasiswa_nim ?>
                            </td>
                            <td><?= $p->nomor_surat ?></td>
                            <td><?= $p->tanggal_terbit ?></td>
                            <td><?= view_cell('StatusSuratKeterangan::renderBadge', ['status' => $p->status]) ?></td>
                            <td>
                                <?= $p->peninjau_name ?>
                                <br>
                                <?= $p->peninjau_nip ?>
                            </td>
                            <td><?= $p->keterangan ?></td>
                            <td>
                                <a href="<?= site_url('keuangan/bebas-ukt/show/' . $p->id) ?>" class="btn btn-primary">Detail</a>
                                <a href="<?= site_url('keuangan/bebas-ukt/edit/' . $p->id) ?>" class="btn btn-warning">Edit</a>
                                <?= form_open('keuangan/bebas-ukt/delete/' . $p->id, ['onsubmit' => 'return confirm("Apakah Anda yakin ingin menghapus data ini?")', 'class' => 'd-inline']) ?>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                                <?= form_close() ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <a href="<?= site_url('keuangan/bebas-ukt/new') ?>" class="btn btn-primary">Tambah</a>
            
            <?= $pager->links() ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>