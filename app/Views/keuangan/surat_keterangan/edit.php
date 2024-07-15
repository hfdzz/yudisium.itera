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
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Data Bebas UKT</a></li>
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
                <div class="">
            <?= validation_list_errors() ?>

            <?= form_open_multipart('keuangan/bebas-ukt/update/' . $sk_bebas_ukt->id) ?>

            <div class="mb-3">
                <div class="form-group mb-3">
                    <label for="tanggal_sidang" class="form-label">Tanggal Sidang</label>
                    <input type="date" class="form-control" name="tanggal_sidang" id="tanggal_sidang" value="<?= $sk_bebas_ukt->tanggal_sidang ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="<?= STATUS_SELESAI ?>" <?= $sk_bebas_ukt?->status == STATUS_SELESAI ? 'selected' : '' ?>>Selesai</option>
                        <option value="<?= STATUS_MENUNGGU_VALIDASI ?>" <?= $sk_bebas_ukt?->status == STATUS_MENUNGGU_VALIDASI ? 'selected' : '' ?>>Menunggu Validasi</option>
                        <option value="<?= STATUS_DITOLAK ?>" <?= $sk_bebas_ukt?->status == STATUS_DITOLAK ? 'selected' : '' ?>>Ditolak</option>
                        <option value="<?= STATUS_SELESAI_BEASISWA ?>" <?= $sk_bebas_ukt?->status == STATUS_SELESAI_BEASISWA ? 'selected' : '' ?>>Selesai Beasiswa</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="nomor_surat" class="form-label">Nomor Surat</label>
                    <input type="text" class="form-control" name="nomor_surat" id="nomor_surat" value="<?= $sk_bebas_ukt?->nomor_surat ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                    <input type="date" class="form-control" name="tanggal_pengajuan" id="tanggal_pengajuan" value="<?= $sk_bebas_ukt?->tanggal_pengajuan ?>">
                </div>
    
                <div class="form-group mb-3">
                    <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                    <input type="date" class="form-control" name="tanggal_terbit" id="tanggal_terbit" value="<?= $sk_bebas_ukt?->tanggal_terbit ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3" style="resize:none;"><?= $sk_bebas_ukt?->keterangan ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="peninjau_id" class="form-label">Peninjau</label>
                    <select class="form-control" name="peninjau_id" id="peninjau_id" disabled>
                      <option> <?= auth()->user()->username ?> (<?= auth()->user()->nip ?>)</option>
                        <!-- <option value="">Pilih Peninjau</option> -->
                        <?php foreach ($list_peninjau as $peninjau) : ?>
                            <!-- <option value="<?= $peninjau->id ?>" <?= $sk_bebas_ukt?->peninjau_id == $peninjau->id ? 'selected' : '' ?>><?= $peninjau->username ?> (<?= $peninjau->nip ?>)</option> -->
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= site_url('keuangan/bebas-ukt') ?>" class="btn btn-secondary">Kembali</a>
            </div>

            <?= form_close() ?>
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