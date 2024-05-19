<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<?= $this->extend('layout/default'); ?>

<?= $this->section('head'); ?>

  <title>SIYUDIS | Cek Status Pendaftaran</title>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper pt-5 mt-3">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Cek Status Pendaftaran</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Cek Status Pendaftaran</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card mb-5">
              <div class="m-3">
                <ul class="bar-progres">
                  <li class="progres">Pengisian Data</li>
                  <li class="<?= (( $sk_bebas_perpustakaan?->isMenungguValidasi() || $sk_bebas_perpustakaan?->isSelesai() ) &&
                    ( $sk_bebas_ukt?->isMenungguValidasi() || $sk_bebas_ukt?->isSelesaiOrBeasiswa() ) &&
                    ( $sk_bebas_laboratorium?->isMenungguValidasi() || $sk_bebas_laboratorium?->isSelesai()))
                    ? 'progres' : '' ?>">Pengajuan Berkas SK</li>

                  <li class="<?= ($sk_bebas_perpustakaan?->isSelesai() && $sk_bebas_ukt?->isSelesaiOrBeasiswa() && $sk_bebas_laboratorium?->isSelesai()) ? 'progres' : '' ?>">Submit Pendaftaran</li>

                  <li class="<?= ( $yudisium_pendaftaran?->isMenungguValidasi() || $yudisium_pendaftaran?->isSelesai() ) ? 'progres' : '' ?>">Validasi Admin FTI</li>

                  <li class="<?= ($yudisium_pendaftaran?->isSelesai()) ? 'progres' : '' ?>">Selesai</li>
                </ul>
              </div>
              <div class="card-header">
                  <div class="d-flex justify-content-center align-items-center">
                      <div class="col-6">
                        <div class="form-group">
                          <label class="form-label" for="nama">Nama :</label>
                          <input class="form-control" type="text" disabled name="nama" id="nama" placeholder="Andi" value="<?= $user->username ?>">
                        </div>
                        <div class="form-group">
                          <label class="form-label" for="nim">NIM :</label>
                          <input class="form-control" type="text" disabled name="nim" id="nim" placeholder="Andi" value="<?= $user->nim ?>">
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label class="form-label" for="prodi">Program Studi :</label>
                          <select class="form-control" disabled name="prodi" id="prodi">
                            <option value="<?= $user->program_studi ?>" selected><?= $user->program_studi ?></option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="form-label" for="status">Status Yudisium :</label>
                          <input class="form-control" type="text" disabled name="status" id="status" placeholder="Belum Mendaftar" style="color: red"  value="<?= $yudisium_pendaftaran?->getStatus(true) ?>">
                          <!-- <div>
                            <?= view_cell('\App\Cells\StatusBadgeCell::render', ['status' => $yudisium_pendaftaran?->status]) ?>
                          </div> -->
                        </div>
                      </div>
                    </div>
              </div>
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Detail</th>
                    <th>Keterangan</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php $i=1; if ($sk_bebas_perpustakaan) : ?>
                    <tr>
                      <td><?= $i++ ?></td>
                      <td><?= $sk_bebas_perpustakaan?->getJenis(true) ?></td>
                      <td><?= view_cell('\App\Cells\StatusBadgeCell::render', ['status' => $sk_bebas_perpustakaan?->status]) ?></td>
                      <td>
                        <?php if ($sk_bebas_perpustakaan?->isSelesai()) : ?>
                          <a href="<?= route_to('file_surat_keterangan', $sk_bebas_perpustakaan?->id) ?>" class="btn btn-primary" target="_blank">Lihat</a>
                        <?php endif ?>
                      </td>
                      <td><?= $sk_bebas_perpustakaan?->keterangan ?></td>
                    </tr>
                  <?php endif; ?>

                  <?php if ($sk_bebas_ukt) : ?>
                    <tr>
                      <td><?= $i++ ?></td>
                      <td><?= $sk_bebas_ukt?->getJenis(true) ?></td>
                      <td><?= view_cell('\App\Cells\StatusBadgeCell::render', ['status' => $sk_bebas_ukt?->status]) ?></td>
                      <td>
                        <?php if ($sk_bebas_ukt?->isSelesai()) : ?>
                          <a href="<?= route_to('file_surat_keterangan', $sk_bebas_ukt?->id) ?>" class="btn btn-primary" target="_blank">Lihat</a>
                        <?php endif ?>
                      </td>
                      
                      <td><?= $sk_bebas_ukt?->keterangan ?></td>
                    </tr>
                  <?php endif; ?>
                  
                  <?php if ($sk_bebas_laboratorium) : ?>
                    <tr>
                      <td><?= $i++ ?></td>
                      <td><?= $sk_bebas_laboratorium?->getJenis(true) ?></td>
                      <td><?= view_cell('\App\Cells\StatusBadgeCell::render', ['status' => $sk_bebas_laboratorium?->status]) ?></td>
                      <td>
                        <?php if ($sk_bebas_laboratorium?->isSelesai()) : ?>
                          <a href="<?=$sk_bebas_laboratorium?->surat ?>" class="btn btn-primary" target="_blank">Lihat</a>
                        <?php endif ?>
                      </td>
                      <td><?= $sk_bebas_laboratorium?->keterangan ?></td>
                    </tr>
                  <?php endif; ?>

                  <?php if ($yudisium_pendaftaran) : ?>
                    <tr>
                      <td><?= $i++ ?></td>
                      <td>Tanda Terima Yudisium</td>
                      <td><?= view_cell('\App\Cells\StatusBadgeCell::render', ['status' => $yudisium_pendaftaran?->status]) ?></td>
                      <td>
                        <?php if ($yudisium_pendaftaran?->isSelesai()) : ?>
                          <a href="<?= route_to('file_tanda_terima_yudisium', $yudisium_pendaftaran?->id) ?>" class="btn btn-primary" target="_blank">Lihat</a>
                        <?php endif ?>
                      </td>
                      <td><?= $yudisium_pendaftaran?->keterangan ?></td>
                    </tr>
                  <?php endif; ?>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

    </div>
  <!-- /.content-wrapper -->

<?= $this->endSection(); ?>