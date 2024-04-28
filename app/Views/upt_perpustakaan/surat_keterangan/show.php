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
            <h1 class="m-0">Detail Berkas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Data Yudisium</a></li>
              <li class="breadcrumb-item active">Detail Berkas</li>
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
          <div class="col-6 mb-5">
                <form class="">
                  <div class="d-flex justify-content-center align-items-center">
                    <img class="profile-user-img img-fluid img-circle" src="../../../assets/img/default.png" alt="">
                  </div>
                  <div class="row text-center m-3 py-2">
                    <div class="col-6">
                        <label class="form-label" for="ijazah">Ijazah SMA</label>
                        <div class="bg-warning p-3 rounded">
                            <img class="img-fluid" src="../../../assets/img/default.png" alt="">
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="akta">Akta Kelahiran</label>
                        <div class="bg-warning p-3 rounded">
                            <img class="img-fluid" src="../../../assets/img/default.png" alt="">
                        </div>
                    </div>
                  </div>
                  <div class="row text-center m-3 py-2">
                    <div class="col-6">
                        <label class="form-label" for="transkrip">Transkrip Nilai (TTD Wali)</label>
                        <div class="bg-warning p-3 rounded">
                            <img class="img-fluid" src="../../../assets/img/default.png" alt="">
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="teofl">Sertifikat TOEFL</label>
                        <div class="bg-warning p-3 rounded">
                            <img class="img-fluid" src="../../../assets/img/default.png" alt="">
                        </div>
                    </div>
                  </div>
                </form>
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