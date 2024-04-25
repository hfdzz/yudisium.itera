<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<?= $this->extend('layout/default'); ?>

<?= $this->section('head'); ?>

  <title>SIYUDIS | Pengajuan Berkas</title>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper pt-5 mt-3">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pengajuan Berkas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Pengajuan Berkas</li>
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
          <div class="col-12 mb-5">
            <div class="pengajuan py-4">
              <div class="title-text">
                <div class="title">Bebas UKT</div>
              </div>

              <?php if ($sk_bebas_ukt?->isSelesai()): ?>

                <div class="alert alert-success">
                  <i class="icon fas fa-check"></i>
                  <span>Surat Keterangan Bebas Pustaka telah selesai.</span>
                </div>
                <div>
                  <?= view_cell('\App\Cells\StatusSuratKeterangan::renderLink', ['status' => $sk_bebas_ukt->status ?? 'selesai', 'url' => route_to('file_surat_keterangan', $sk_bebas_ukt->id ?? 4)]) ?>
                </div>

              <?php elseif ($sk_bebas_ukt && $sk_bebas_ukt->isSelesaiOrBeasiswa()): ?>

                <div class="alert alert-info">
                  <i class="icon fas fa-info"></i>
                  <span>Surat Keterangan Bebas Pustaka telah selesai (Beasiswa).</span>
                </div>
                <span>
                  Silahkan mengajukan <strong>Surat Keterangan Mahasiswa</strong> di Administrasi Akademik untuk daftar yudisium.
                </span>

              <?php elseif ($sk_bebas_ukt && $sk_bebas_ukt->isMenungguValidasi()): ?>

                <div class="alert alert-info">
                  <i class="icon fas fa-info"></i>
                  <span>Surat Keterangan Bebas Pustaka sedang dalam proses validasi.</span>
                </div>

              <?php elseif (!$sk_bebas_ukt || $sk_bebas_ukt?->canAjukan()): ?>
                
              <div class="form-container">
                <!-- Text Persyaratan bebas Pustaka in list -->
                <div>
                  <ul>
                    <li>Bayar UKT.</li>
                    <li>Sudah lunas.</li>
                    <li>Yang beasiswa minta Surat Keterangan Mahasiswa dari administrasi kampus.</li>
                  </ul>
                </div>

                <?php if ($sk_bebas_ukt?->keterangan): ?>
                
                  <!-- place for keterangan -->
                  <div class="alert <?= $sk_bebas_ukt->isDitolak() ? 'alert-danger' : 'alert-info' ?>">
                    <i class="icon fas <?= $sk_bebas_ukt->isDitolak() ? 'fa-times' : 'fa-info' ?>"></i>
                    <strong>Keterangan:</strong>
                    <div><?= $sk_bebas_ukt->keterangan ?></div>
                  </div>

                <?php endif; ?>

                <div class="form-inner">
                  <form action="<?= route_to('sk_bebas_ukt') ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                      <div class="form-group col-4">
                        <label class="form-label" for="berkas_ba_sidang">Berita Acara Sidang</label>
                        <input type="file" class="form-control" name="berkas_ba_sidang" id="berkas_ba_sidang" required placeholder="berkas_ba_sidang">
                      </div>
                      <div class="form-group col-4">
                        <label class="form-label" for="berkas_khs">Kartu Hasil Studi (TerTTD Dosen Wali)</label>
                        <input type="file" class="form-control" name="berkas_khs" id="berkas_khs" required placeholder="berkas_khs">
                      </div>
                      <div class="form-group col-4">
                        <label class="form-label" for="berkas_bukti_bayar_ukt">Screenshot Lunas UKT AVITA</label>
                        <input type="file" class="form-control" name="berkas_bukti_bayar_ukt" id="berkas_bukti_bayar_ukt" required placeholder="berkas_bukti_bayar_ukt">
                      </div>
                    </div>

                    <?php if(validation_errors()): ?>
                      <div class="alert alert-danger">
                        <ul class="m-0">
                          <?php foreach(validation_errors() as $error): ?>
                            <li><?= esc($error) ?></li>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    <?php endif; ?>

                    <div class="field btn">
                      <div class="btn-layer"></div>
                      <input type="submit" value="Ajukan" />
                    </div>
                  </form>
                </div>
              </div>
              <?php endif; ?>
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