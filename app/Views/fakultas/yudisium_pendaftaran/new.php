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
            <h1 class="m-0">Tambah Berkas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Data Bebas UKT</a></li>
              <li class="breadcrumb-item active">Tambah Berkas</li>
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

            <?= form_open_multipart('fakultas/yudisium-pendaftaran/create') ?>

            <div class="mb-3">
                <div class="mb-3">
                    <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                    <input type="text" class="form-control" name="nama_mahasiswa" id="nama_mahasiswa" value="<?= old('nama_mahasiswa') ?>">
                </div>

                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" name="nim" id="nim" value="<?= old('nim') ?>">
                </div>

                <div class="mb-3">
                    <label for="program_studi" class="form-label">Program Studi</label>
                    <input type="text" class="form-control" name="program_studi" id="program_studi" value="<?= old('program_studi') ?>">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="<?= STATUS_MENUNGGU_VALIDASI ?>">Menunggu Validasi</option>
                        <option value="<?= STATUS_SELESAI ?>">Selesai</option>
                        <option value="<?= STATUS_DITOLAK ?>">Ditolak</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="yudisium_periode_id" class="form-label">Periode Yudisium</label>
                    <select class="form-control" name="yudisium_periode_id" id="yudisium_periode_id">
                        <option value="">Pilih Periode</option>
                        <?php foreach ($list_periode as $periode) : ?>
                            <option value="<?= $periode->id ?>"><?= $periode->periode ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
                    <input type="date" class="form-control" name="tanggal_daftar" id="tanggal_daftar" value="<?= old('tanggal_daftar') ?>">
                </div>

                <div class="mb-3">
                    <label for="tanggal_penerimaan" class="form-label">Tanggal Penerimaan</label>
                    <input type="date" class="form-control" name="tanggal_penerimaan" id="tanggal_penerimaan" value="<?= old('tanggal_penerimaan') ?>">
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3" style="resize:none;"><?= old('keterangan') ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="peninjau" class="form-label">Peninjau</label>
                    <select class="form-control" name="peninjau" id="peninjau">
                        <option value="">Pilih Peninjau</option>
                        <?php foreach ($list_peninjau as $peninjau) : ?>
                            <option value="<?= $peninjau->id ?>"><?= $peninjau->username ?> (<?= $peninjau->nip ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3 row">
                    <div class="col">
                        <div class="mb-2">
                            <label for="berkas_transkrip" class="form-label">Berkas Transkrip</label>
                            <input class="form-control" type="file" name="berkas_transkrip" id="berkas_transkrip">
                        </div>
                        <div class="mb-2">
                            <label for="berkas_ijazah" class="form-label">Berkas Ijazah</label>
                            <input class="form-control" type="file" name="berkas_ijazah" id="berkas_ijazah">
                        </div>
                        <div class="mb-2">
                            <label for="berkas_pas_foto" class="form-label">Berkas Pas Foto</label>
                            <input class="form-control" type="file" name="berkas_pas_foto" id="berkas_pas_foto">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <label for="berkas_sertifikat_bahasa_inggris" class="form-label">Berkas Sertifikat Bahasa Inggris</label>
                            <input class="form-control" type="file" name="berkas_sertifikat_bahasa_inggris" id="berkas_sertifikat_bahasa_inggris">
                        </div>
                        <div class="mb-2">
                            <label for="berkas_akta_kelahiran" class="form-label">Berkas Akta Kelahiran</label>
                            <input class="form-control" type="file" name="berkas_akta_kelahiran" id="berkas_akta_kelahiran">
                        </div>
                        <div class="mb-2">
                            <label for="berkas_surat_keterangan_mahasiswa" class="form-label">Berkas Surat Keterangan Mahasiswa</label>
                            <input class="form-control" type="file" name="berkas_surat_keterangan_mahasiswa" id="berkas_surat_keterangan_mahasiswa">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= site_url('fakultas/yudisium-pendaftaran') ?>" class="btn btn-secondary">Kembali</a>
                </div>
                
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