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
            <h1>Validasi Yudisium</h1>
            <div class="mb-2">
                <span>Periode: </span>
                <span>
                    <?= $latest_periode->periode ?>
                </span>
                <br>
                <?php if ($latest_periode->isOpen()): ?>
                    <span class="badge bg-success">Periode sedang berlangsung</span>
                <?php else: ?>
                    <span class="badge bg-danger">Periode sudah berakhir atau belum dimulai</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="">
            <div>
                <table class="table table-bordered table-striped table-hover text-center"  style="font-size: 0.9em;">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Mahasiswa</th>
                            <th scope="col">Tanggal Daftar</th>
                            <th scope="col">Transkrip</th>
                            <th scope="col">Ijazah</th>
                            <th scope="col">Pas Foto</th>
                            <th scope="col">Sertifikat Bahasa Inggris</th>
                            <th scope="col">Akta Kelahiran</th>
                            <th scope="col">Surat Keterangan Mahasiswa</th>
                            <th scope="col">SK Bebas Perpustakaan</th>
                            <th scope="col">SK Bebas UKT</th>
                            <th scope="col">SK Bebas Laboratorium</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($pendaftaran as $p): ?>
                            <tr>
                                <th scope="row">
                                    <?= $i++ + ($pager->getPerPage() * ($pager->getCurrentPage() - 1)) ?>
                                </th>
                                <td>
                                    <span><?= $p->mahasiswa->username ?></span>
                                    <span><?= $p->mahasiswa->nim ?></span>
                                </td>
                                <td><?= $p->created_at?->toLocalizedString('d MMM yyyy') ?></td>
                                <td><a href="<?= route_to('berkas_pendaftaran_yudisium', $p->id, 'berkas_transkrip') ?>" target="_blank">Lihat</a></td>
                                <td><a href="<?= route_to('berkas_pendaftaran_yudisium', $p->id, 'berkas_ijazah') ?>" target="_blank">Lihat</a></td>
                                <td><a href="<?= route_to('berkas_pendaftaran_yudisium', $p->id, 'berkas_pas_foto') ?>" target="_blank">Lihat</a></td>
                                <td><a href="<?= route_to('berkas_pendaftaran_yudisium', $p->id, 'berkas_sertifikat_bahasa_inggris') ?>" target="_blank">Lihat</a></td>
                                <td><a href="<?= route_to('berkas_pendaftaran_yudisium', $p->id, 'berkas_akta_kelahiran') ?>" target="_blank">Lihat</a></td>
                                <td>
                                    <?php if (isset($p->berkas_surat_keterangan_mahasiswa)): ?>
                                        <a href="<?= route_to('berkas_pendaftaran_yudisium', $p->id, 'berkas_surat_keterangan_mahasiswa') ?>" target="_blank">Lihat</a>
                                    <?php else: ?>
                                        <span class="text-danger">Tidak diunggah</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= view_cell('LinkTextCell::skLink', ['sk_id' => $p->getSuratKeterangan(JENIS_SK_BEBAS_PERPUSTAKAAN)?->id]) ?></td>
                                <td><?= view_cell('LinkTextCell::skLink', ['sk_id' => $p->getSuratKeterangan(JENIS_SK_BEBAS_UKT)?->id]) ?></td>
                                <td><?= view_cell('LinkTextCell::bebasLabLink', ['sk_bebaslab' => $p->getSuratKeterangan(JENIS_SK_BEBAS_LABORATORIUM)]) ?></td>
                                <td>
                                    <form action="<?= route_to('fakultas.validasi_yudisium') ?>" method="post">
                                        <input type="hidden" name="id" value="<?= $p->id ?>">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-success" name="action" value="validasi">Terima</button>
                                            <button type="submit" class="btn btn-danger" name="action" value="tolak">Tolak</button>
                                        </div>
                                        <input type="text" name="keterangan" class="form-control" placeholder="Keterangan">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                <?= $pager->links() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>