<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<?= $this->extend('layout/default'); ?>

<?= $this->section('head'); ?>

<title>SIYUDIS | Buat Periode Baru</title>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper pt-5 mt-3">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kelola Periode</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Periode & Tanda Terima</li>
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tabel Periode & Tanda Terima</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <label for="periode">Periode : Maret/2024</label><br>
                <p class="badge badge-danger" id="periode">Periode Sudah Berakhir atau Belum Dimulai</p>
                <form action="../../admin_fti/periode/selesai.html" method="get">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label class="form-label" for="tanggal_awal">Tanggal Awal</label>
                        <input type="date" class="form-control" id="tanggal_awal" placeholder="tanggal_awal">
                      </div>
                      <div class="form-group">
                        <label class="form-label" for="tanggal_akhir">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tanggal_akhir" placeholder="tanggal_akhir">
                      </div>
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                    </div>
                      <div class="form-group" id="linkSection">
                        <button type="button" class="btn btn-primary my-2" id="addLinkButton">Tambah Link</button>
                        <div class="row linkRow">
                        </div>
                      </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->

<?= $this->endSection(); ?>