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
              <?= validation_list_errors() ?>

              <?= form_open_multipart('fakultas/yudisium-pendaftaran/update/' . $yudisium_pendaftaran->id) ?>

              <div class="mb-3">
                  <div class="form-group mb-3">
                      <label for="status" class="form-label">Status</label>
                      <select class="form-control" name="status" id="status">
                          <option value="<?= STATUS_SELESAI ?>" <?= $yudisium_pendaftaran?->status == STATUS_SELESAI ? 'selected' : '' ?>>Selesai</option>
                          <option value="<?= STATUS_MENUNGGU_VALIDASI ?>" <?= $yudisium_pendaftaran?->status == STATUS_MENUNGGU_VALIDASI ? 'selected' : '' ?>>Menunggu Validasi</option>
                          <option value="<?= STATUS_DITOLAK ?>" <?= $yudisium_pendaftaran?->status == STATUS_DITOLAK ? 'selected' : '' ?>>Ditolak</option>
                      </select>
                  </div>

                  <div class="mb-3">
                    <label for="yudisium_periode_id" class="form-label">Periode Yudisium</label>
                    <select class="form-control" name="yudisium_periode_id" id="yudisium_periode_id">
                        <option value="">Pilih Periode</option>
                        <?php foreach ($list_periode as $periode) : ?>
                            <option value="<?= $periode->id ?>" <?= $yudisium_pendaftaran?->yudisium_periode_id == $periode->id ? 'selected' : '' ?>><?= $periode->periode ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="form-group mb-3">
                      <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
                      <input type="date" class="form-control" name="tanggal_daftar" id="tanggal_daftar" value="<?= $yudisium_pendaftaran?->tanggal_daftar ?>">
                  </div>
      
                  <div class="form-group mb-3">
                      <label for="tanggal_penerimaan" class="form-label">Tanggal Penerimaan</label>
                      <input type="date" class="form-control" name="tanggal_penerimaan" id="tanggal_penerimaan" value="<?= $yudisium_pendaftaran?->tanggal_penerimaan ?>">
                  </div>

                  <div class="form-group mb-3">
                      <label for="keterangan" class="form-label">Keterangan</label>
                      <textarea class="form-control" name="keterangan" id="keterangan" rows="3" style="resize:none;"><?= $yudisium_pendaftaran?->keterangan ?></textarea>
                  </div>

                  <div class="form-group mb-3">
                      <label for="peninjau_id" class="form-label">Peninjau</label>
                      <select class="form-control" name="peninjau_id" id="peninjau_id" disabled>
                        <option> <?= auth()->user()->username ?> (<?= auth()->user()->nip ?>)</option>
                          <!-- <option value="">Pilih Peninjau</option> -->
                          <?php foreach ($list_peninjau as $peninjau) : ?>
                              <!-- <option value="<?= $peninjau->id ?>" <?= $yudisium_pendaftaran?->peninjau_id == $peninjau->id ? 'selected' : '' ?>><?= $peninjau->username ?> (<?= $peninjau->nip ?>)</option> -->
                          <?php endforeach; ?>
                      </select>
                  </div>
              </div>

              <div class="mb-3">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <a href="<?= site_url('fakultas/yudisium-pendaftaran') ?>" class="btn btn-secondary">Kembali</a>
              </div>

              <?= form_close() ?>
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