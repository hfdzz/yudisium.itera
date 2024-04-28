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
            <h1 class="m-0">Edit Berkas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Data Yudisium</a></li>
              <li class="breadcrumb-item active">Edit Berkas</li>
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
              <div class="card-body">
                <form class="">
                  <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-control" name="status" id="status">
                      <option value="1">asd (123)</option>
                      <option value="1">asd (123)</option>
                      <option value="1">asd (123)</option>
                      <option value="1">asd (123)</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="no_surat">No Surat</label>
                    <input type="text" class="form-control" id="no_surat" placeholder="no_surat">
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="terbit">Tanggal Terbit</label>
                    <input type="date" class="form-control" id="terbit" placeholder="terbit">
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="keterangan">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" cols="10" rows="10"></textarea>
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="peninjau">Peninjau</label>
                    <select class="form-control" name="peninjau" id="peninjau">
                      <option value="1">asd (123)</option>
                      <option value="1">asd (123)</option>
                      <option value="1">asd (123)</option>
                      <option value="1">asd (123)</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <button type="button" class="btn btn-secondary">Kembali</button></button>
                </form>
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