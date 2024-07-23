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
                            <th scope="col">Mahasiswa</th>
                            <th scope="col">Program Studi</th>
                            <th scope="col">Tanggal Diajukan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($surat_keterangan as $p): ?>
                            <tr>
                                <th scope="row"><?= $i++ ?></th>
                                <td>
                                    <?= $p->mahasiswa_nim ?>
                                    <br>
                                    <?= $p->mahasiswa_username ?>
                                </td>
                                <td><?= $p->mahasiswa_program_studi ?></td>
                                <td><?= $p->created_at->toLocalizedString('d MMM yyyy') ?></td>
                                <!-- make the action column shrink to fit the content -->
                                <td>
                                    <form action="<?= route_to('keuangan.validasi-surat-keterangan', $p->id)?>" method="post">
                                        <input type="hidden" name="id" value="<?= $p->id ?>">
                                        <div class="d-flex justify-content-center">
                                            <!-- button for detail modal -->
                                            <button type="button" class="btn btn-info mx-1" data-bs-toggle="modal" data-bs-target="#berkasModal<?= $p->id ?>">Berkas</button>
                                            <button type="submit" name="action" value="<?= 'validasi' ?>" class="btn btn-primary mx-1">Terima</button>
                                            <button type="submit" name="action" value="<?= 'validasi_beasiswa' ?>" class="btn btn-warning mx-1">Beasiswa</button>
                                            <button type="submit" name="action" value="<?= 'tolak' ?>" class="btn btn-danger mx-1">Tolak</button>
                                            <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" style="width: 200px;" autocomplete="off">
                                            <input type="text" name="nomor_surat" class="form-control" placeholder="Nomor Surat" style="width: 200px;" autocomplete="off">
                                        </div>
                                        <div class="modal fade text-start" id="berkasModal<?= $p->id ?>" tabindex="-1" aria-labelledby="berkasModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="berkasModalLabel">Berkas Surat Keterangan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <div class="d-flex flex-column">
                                                            <a href="<?= route_to('berkas_bebas_ukt', $p->id, 'berkas_ba_sidang') ?>" target="_blank">BA Sidang</a>
                                                            <a href="<?= route_to('berkas_bebas_ukt', $p->id, 'berkas_transkrip') ?>" target="_blank">Transkrip</a>
                                                            <a href="<?= route_to('berkas_bebas_ukt', $p->id, 'berkas_bukti_bayar_ukt') ?>" target="_blank">Bukti Bayar UKT</a>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
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