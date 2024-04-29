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
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Data Bebas UKT</a></li>
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
      <div class="row">
        <div class="col-12">
          <div class="card mb-5">
            <div class="card-body">
            <div class="">
            <div class="mb-3">
                <div class="form-group mb-3">
                    <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                    <input type="text" class="form-control" name="nama_mahasiswa" id="nama_mahasiswa" value="<?= $sk_bebas_ukt->mahasiswa->username ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" name="nim" id="nim" value="<?= $sk_bebas_ukt->mahasiswa->nim ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="program_studi" class="form-label">Program Studi</label>
                    <input type="text" class="form-control" name="program_studi" id="program_studi" value="<?= $sk_bebas_ukt->mahasiswa->program_studi ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <input type="text" class="form-control" name="status" id="status" value="<?= $sk_bebas_ukt->getStatus(true) ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="nomor_surat" class="form-label">Nomor Surat</label>
                    <input type="text" class="form-control" name="nomor_surat" id="nomor_surat" value="<?= $sk_bebas_ukt->nomor_surat ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                    <input type="date" class="form-control" name="tanggal_terbit" id="tanggal_terbit" value="<?= $sk_bebas_ukt->tanggal_terbit ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3" style="resize:none;" readonly><?= $sk_bebas_ukt->keterangan ?></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="peninjau" class="form-label">Peninjau</label>
                    <input type="text" class="form-control" name="peninjau" id="peninjau" value="<?= $sk_bebas_ukt->peninjau?->username . ' (' . $sk_bebas_ukt->peninjau?->nip . ')' ?>" readonly>
                </div>
                <div>
                    <label for="file" class="form-label">Berkas</label>
                    <div class="d-flex flex-column flex-shrink-1">
                        <a href="<?= site_url('berkas-bebas-ukt/' . $sk_bebas_ukt->id . '/berkas_ba_sidang') ?>" target="_blank">Berkas BA Sidang</a>
                        <a href="<?= site_url('berkas-bebas-ukt/' . $sk_bebas_ukt->id . '/berkas_khs') ?>" target="_blank">Berkas KHS</a>
                        <a href="<?= site_url('berkas-bebas-ukt/' . $sk_bebas_ukt->id . '/berkas_bukti_bayar_ukt') ?>" target="_blank">Berkas Bukti Bayar UKT</a>
                        <a href="<?= site_url('file-surat-keterangan/' . $sk_bebas_ukt->id) ?>" target="_blank" class="btn btn-primary mt-2">Lihat Surat Keterangan</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-start">
            <a href="<?= site_url('keuangan/bebas-ukt/edit/' . $sk_bebas_ukt->id) ?>" class="btn btn-primary mr-1">Edit</a>
            <a href="<?= site_url('keuangan/bebas-ukt') ?>" class="btn btn-secondary">Kembali</a>
        </div>
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