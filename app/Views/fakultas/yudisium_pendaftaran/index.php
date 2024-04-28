<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<?= $this->extend('layout/default'); ?>

<?= $this->section('head'); ?>

<title>SIYUDIS | Data Yudisium</title>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper pt-5 mt-3">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kelola Data Yudisium</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Kelola Data Yudisium</li>
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
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="background-color: #EEC01D;">No</th>
                    <th style="background-color: #EEC01D;">Tanggal</th>
                    <th style="background-color: #EEC01D;">Nama</th>
                    <th style="background-color: #EEC01D;">NIM</th>
                    <th style="background-color: #EEC01D;">Prodi</th>
                    <th style="background-color: #EEC01D;">
                      <select class="rounded font-weight-bold btn btn-default" id="filterStatus">
                        <option value="">Filter Status</option>
                        <option value="Sudah Divalidasi">Sudah Divalidasi</option>
                        <option value="Belum Divalidasi">Belum Divalidasi</option>
                      </select>
                    </th>
                    <th style="background-color: #EEC01D;">Periode</th>
                    <th style="background-color: #EEC01D;">Tahun</th>
                    <th style="background-color: #EEC01D;">SK</th>
                    <th style="background-color: #EEC01D;">Surat</th>
                    <th style="background-color: #EEC01D;">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>1</td>
                    <td>01-01-2023</td>
                    <td>Gery</td>
                    <td>123456</td>
                    <td>Sistem Informasi</td>
                    <td><p class="small text-center rounded bg-success" disabled>Sudah Divalidasi</p></td>
                    <td>Januari</td>
                    <td>2023</td>
                    <td>Diterbitkan</td>
                    <td><button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalBerkas">Lihat</button></td>
                    <td>
                      <a href="edit.html" class="btn btn-warning btn-sm">Edit</a>
                      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapus">Hapus</button>
                      <a href="detail.html" class="btn btn-success btn-sm">Detail</a>
                    </td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>01-01-2023</td>
                    <td>Gery</td>
                    <td>123456</td>
                    <td>Sistem Informasi</td>
                    <td><p class="small text-center rounded bg-danger" disabled>Belum Divalidasi</p></td>
                    <td>Januari</td>
                    <td>2023</td>
                    <td>Diterbitkan</td>
                    <td><button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalBerkas">Lihat</button></td>
                    <td>
                      <a href="edit.html" class="btn btn-warning btn-sm">Edit</a>
                      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapus">Hapus</button>
                      <a href="detail.html" class="btn btn-success btn-sm">Detail</a>
                    </td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>01-01-2023</td>
                    <td>Gery</td>
                    <td>123456</td>
                    <td>Sistem Informasi</td>
                    <td><p class="small text-center rounded bg-success" disabled>Sudah Divalidasi</p></td>
                    <td>Januari</td>
                    <td>2023</td>
                    <td>Diterbitkan</td>
                    <td><button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalBerkas">Lihat</button></td>
                    <td>
                      <a href="edit.html" class="btn btn-warning btn-sm">Edit</a>
                      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapus">Hapus</button>
                      <a href="detail.html" class="btn btn-success btn-sm">Detail</a>
                    </td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>01-01-2023</td>
                    <td>Gery</td>
                    <td>123456</td>
                    <td>Sistem Informasi</td>
                    <td><p class="small text-center rounded bg-danger" disabled>Belum Divalidasi</p></td>
                    <td>Januari</td>
                    <td>2023</td>
                    <td>Diterbitkan</td>
                    <td><button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalBerkas">Lihat</button></td>
                    <td>
                      <a href="edit.html" class="btn btn-warning btn-sm">Edit</a>
                      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapus">Hapus</button>
                      <a href="detail.html" class="btn btn-success btn-sm">Detail</a>
                    </td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>01-01-2023</td>
                    <td>Gery</td>
                    <td>123456</td>
                    <td>Sistem Informasi</td>
                    <td><p class="small text-center rounded bg-success" disabled>Sudah Divalidasi</p></td>
                    <td>Januari</td>
                    <td>2023</td>
                    <td>Diterbitkan</td>
                    <td><button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalBerkas">Lihat</button></td>
                    <td>
                      <a href="edit.html" class="btn btn-warning btn-sm">Edit</a>
                      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapus">Hapus</button>
                      <a href="detail.html" class="btn btn-success btn-sm">Detail</a>
                    </td>
                  </tr>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th style="background-color: #EEC01D;">No</th>
                    <th style="background-color: #EEC01D;">Tanggal</th>
                    <th style="background-color: #EEC01D;">Nama</th>
                    <th style="background-color: #EEC01D;">NIM</th>
                    <th style="background-color: #EEC01D;">Prodi</th>
                    <th style="background-color: #EEC01D;">Status</th>
                    <th style="background-color: #EEC01D;">Periode</th>
                    <th style="background-color: #EEC01D;">Tahun</th>
                    <th style="background-color: #EEC01D;">SK</th>
                    <th style="background-color: #EEC01D;">Surat</th>
                    <th style="background-color: #EEC01D;">Aksi</th>
                  </tr>
                  </tfoot>
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

  <!-- Modal Berkas -->
  <div class="modal fade" id="modalBerkas" tabindex="-1" role="dialog" aria-labelledby="modalBerkasLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalBerkasLabel">Berkas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <embed src="../../../assets/img/logo-fti.png" type="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
          <!-- Additional buttons can be added here -->
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Hapus -->
  <div class="modal fade" id="modalHapus">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Header modal -->
        <div class="modal-header">
          <h4 class="modal-title">Hapus Data</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Isi modal -->
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menghapus data ini?</p>
        </div>

        <!-- Footer modal -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger">Hapus</button>
        </div>

      </div>
    </div>
  </div>

<?= $this->endSection(); ?>