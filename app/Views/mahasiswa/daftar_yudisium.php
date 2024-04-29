<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<?= $this->extend('layout/default'); ?>

<?= $this->section('head'); ?>

  <title>SIYUDIS | Pendaftaran Yudisium</title>

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
        <div class="d-flex justify-content-center align-items-center">
          <div class="col-12 mb-5">
            <div class="card">
              <div class="card-body">

              <?php if ($yudisium_pendaftaran?->isSelesai()): ?>

                <div class="alert alert-success">
                  <i class="icon fas fa-check"></i>
                  <span>Pendaftaran Yudisium telah selesai.</span>
                </div>
                <div>
                  <a href="<?= route_to('file_tanda_terima_yudisium', $yudisium_pendaftaran?->id) ?>" class="mx-1" target="_blank">Lihat Tanda Terima Yudisium</a>
                </div>
                <?php if(isset($yudisium_pendaftaran->keterangan)) : ?>
                <div class="alert alert-info">
                  <p class="m-0"><strong>Keterangan:</strong></p>
                  <?= $yudisium_pendaftaran->keterangan ?>
                </div>
                <?php endif; ?>

              <?php elseif ($yudisium_pendaftaran?->isMenungguValidasi()): ?>

                <div class="alert alert-info">
                  <i class="icon fas fa-info"></i>
                  <span>Pendaftaran Yudisium sedang menunggu validasi.</span>
                </div>

              <?php elseif (!$yudisium_pendaftaran || $yudisium_pendaftaran?->canDafarYudisium()): ?>
                
                <form class="" action="" method="post" enctype="multipart/form-data">
                  <div class="d-flex justify-content-center align-items-center py-2 mb-3" style="background-color: #EEC01D; border-radius: 20px;">
                    <b>Form Pendaftaran Yudisium</b>
                  </div>

                  <?php if(isset($yudisium_pendaftaran->keterangan)) : ?>
                  <div class="alert <?= $yudisium_pendaftaran->isDitolak() ? 'alert-danger' : 'alert-warning' ?>">
                    <p class="m-0"><strong>Keterangan:</strong></p>
                    <?= $yudisium_pendaftaran->keterangan ?>
                  </div>
                  <?php endif; ?>
                  
                  <div class="row">
                    <div class="col-4">
                      <div><strong>Surat Bebas UKT</strong></div>
                      <div>
                        <?= view_cell('\App\Cells\StatusSuratKeterangan::renderBadgeAndLink', ['status' => $sk_bebas_perpustakaan?->status, 'url' => route_to('mahasiswa.sk_bebas_perpustakaan')]) ?>
                      </div>
                    </div>

                    <div class="col-4">
                      <div><strong>Surat Bebas UKT</strong></div>
                      <div>
                        <?= view_cell('\App\Cells\StatusSuratKeterangan::renderBadgeAndLink', ['status' => $sk_bebas_perpustakaan?->status, 'url' => route_to('mahasiswa.sk_bebas_ukt')]) ?>
                      </div>
                    </div>

                    <div class="col-4">
                      <div><strong>Surat Bebas Laboratorium</strong></div>
                      <div>
                        <?= view_cell('\App\Cells\StatusSuratKeterangan::renderBadgeAndLink', ['status' => $sk_bebas_laboratorium?->status, 'url' => $sk_bebas_laboratorium?->surat]) ?>
                      </div>
                    </div>

                    <div class="form-group col-6">
                      <label class="form-label" for="transkrip">Transkrip</label>
                      <input type="file" class="form-control" name="transkrip" id="transkrip"  placeholder="transkrip">
                    </div>

                    <div class="form-group col-6">
                      <label class="form-label" for="toefl">Sertifikat TOEFL</label>
                      <input type="file" class="form-control" name="toefl" id="toefl"  placeholder="toefl">
                    </div>

                    <div class="form-group col-6">
                      <label class="form-label" for="ijazah">Ijazah SMA</label>
                      <input type="file" class="form-control" name="ijazah" id="ijazah"  placeholder="ijazah">
                    </div>

                    <div class="form-group col-6">
                      <label class="form-label" for="foto">Foto 3x4</label>
                      <input type="file" class="form-control" name="foto" id="foto"  placeholder="foto">
                    </div>

                    <div class="form-group col-6">
                      <label class="form-label" for="akta">Akta kelahiran</label>
                      <input type="file" class="form-control" name="akta" id="akta"  placeholder="akta">
                    </div>

                    <div class="form-group col-6">
                      <label class="form-label" for="surat_lunas">Surat Keterangan Lunas (Opsional)</label>
                      <input type="file" class="form-control" name="surat_lunas" id="surat_lunas" enabled placeholder="surat_lunas">
                    </div>

                  </div>

                  <?php if(validation_errors()): ?>
                    <div class="alert alert-danger">
                      <ul class="m-0">
                        <?php foreach(validation_errors() as $error): ?>
                          <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  <?php endif; ?>

                  <div class="d-flex justify-content-center align-items-center">
                    <button type="submit" class="btn text-white px-5" style="background-color: #EEC01D;">DAFTAR</button>
                  </div>
                </form>
              <?php endif; ?>
              </div>
            </div>
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