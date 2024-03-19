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
            <h1>Validasi Surat Keterangan</h1>
        </div>
        <div class="">
            <div>
                <table class="table table-bordered table-striped table-hover text-center"  style="font-size: 0.9em;">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Program Studi</th>
                            <th scope="col">Tanggal Diajukan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($surat_keterangan as $sk): ?>
                            <tr>
                                <th scope="row"><?= $i++ ?></th>
                                <td><?= $sk->mahasiswa_nim ?></td>
                                <td><?= $sk->mahasiswa_username ?></td>
                                <td><?= $sk->mahasiswa_program_studi ?></td>
                                <td><?= $sk->created_at->toLocalizedString('d MMM yyyy') ?></td>
                                <!-- make the action column shrink to fit the content -->
                                <td>
                                    <form action="<?= route_to('upt-perpustakaan.validasi-surat-keterangan', $sk->id)?>" method="post">
                                        <input type="hidden" name="id" value="<?= $sk->id ?>">
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" name="action" value="<?= 'validasi' ?>" class="btn btn-primary mx-1">Terima</button>
                                            <button type="submit" name="action" value="<?= 'tolak' ?>" class="btn btn-danger mx-1">Tolak</button>
                                            <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" style="width: 200px;">
                                            <input type="text" name="nomor_surat" class="form-control" placeholder="Nomor Surat" style="width: 200px;">
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                <?= $pager?->links() ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>