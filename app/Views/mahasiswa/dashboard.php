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
            <div class="small-box">
              <div class="inner">
                <h3>Pengumuman</h3>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab similique vitae quisquam optio? Quod, nulla eius exercitationem corporis repudiandae neque excepturi deleniti maiores earum aut, ipsa architecto minus vel, vero ex facilis qui voluptate magni. Laudantium, exercitationem, consectetur, provident distinctio temporibus veritatis unde dolorum dolores itaque tempore quas possimus? Quibusdam?</p>
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