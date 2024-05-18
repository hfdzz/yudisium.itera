<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<?= $this->extend('layout/default'); ?>

<?= $this->section('head'); ?>

  <title>SIYUDIS | Dashboard</title>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper pt-5 mt-3">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Mahasiswa</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
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
          <div class="col-lg-4 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>
                  <?= $belum_mengajukan ?>
                </h3>

                <p>Belum Divalidasi</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>
                  <?= $menunggu_validasi ?>
                </h3>

                <p>Berkas Diajukan</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-12">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>
                  <?= $selesai ?>
                </h3>

                <p>Sudah Divalidasi</p>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-lg-12 col-12">
            <br>
            <div class="card card-warning card-outline p-3">
              <div class="inner">
                <i class="fas fa-info-circle"></i>
                <span class="card-info">Informasi Pendaftaran Yudisium</span>
                <p class="text-justify px-3">
                  1. Periode pendaftaran  yudisium FTI dilakukan setiap bulan dan biasanya dilakukan pada akhir bulan. <br>
                  2. Mahasiswa diharuskan untuk mendaftarkan akun dan mengumpulkan berkas pendaftaran yudisium dengan mengajukan berkas terlebih dahulu lewat menu pengajuan berkas. <br>
                  3. Setelah mengajukan berkas, mahasiswa harus melengkapi seluruh berkas pendaftaran dan dapat melihat status dari pendaftaran pada menu cek status. <br>
                  4. Apabila pendaftaran sudah divalidasi, silahkan unduh tanda terima dan join di grup whatsapp yang tersedia sesuai dengan program studi. <br>
                  5. Apabila terdapat hal yang tidak dimengerti silahkan tanyakan pada Admin Fakultas.
                </p>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer fixed-bottom">
      <strong>Copyright &copy; 2024 <a href="#">SIYUDIS</a>.</strong> All rights reserved.
  </footer>

<?= $this->endSection(); ?>