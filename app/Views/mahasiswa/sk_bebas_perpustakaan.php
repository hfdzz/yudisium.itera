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
                <div class="title">Bebas Pustaka</div>
              </div>

              <?php if ($sk_bebas_perpustakaan?->isSelesai()): ?>

                <div class="alert alert-success">
                  <i class="icon fas fa-check"></i>
                  <span>Surat Keterangan Bebas Pustaka telah selesai.</span>
                </div>
                <div>
                  <?= view_cell('\App\Cells\StatusSuratKeterangan::renderLink', ['status' => $sk_bebas_perpustakaan->status ?? 'selesai', 'url' => '', 'url2' => route_to('file_surat_keterangan', $sk_bebas_perpustakaan->id ?? 4)]) ?>
                </div>

              <?php elseif ($sk_bebas_perpustakaan?->isMenungguValidasi()): ?>

                <div class="alert alert-info">
                  <i class="icon fas fa-info"></i>
                  <span>Surat Keterangan Bebas Pustaka sedang dalam proses validasi.</span>
                </div>

              <?php elseif (!$sk_bebas_perpustakaan || $sk_bebas_perpustakaan?->canAjukan()): ?>

              <div class="form-container">
                <!-- Text Persyaratan bebas Pustaka in list -->
                <div>
                  <ul>
                    <li>Sudah mengumpulkan TA Hardcopy.</li>
                    <li>Sudah mengumpulkan TA softcopy.</li>
                    <li>Turnitin.</li>
                  </ul>
                </div>

                <?php if ($sk_bebas_perpustakaan?->keterangan): ?>
                
                  <!-- place for keterangan -->
                  <div class="alert <?= $sk_bebas_perpustakaan->isDitolak() ? 'alert-danger' : 'alert-info' ?>">
                    <i class="icon fas <?= $sk_bebas_perpustakaan->isDitolak() ? 'fa-times' : 'fa-info' ?>"></i>
                    <strong>Keterangan:</strong>
                    <div><?= $sk_bebas_perpustakaan->keterangan ?></div>
                  </div>

                <?php endif; ?>

                <div class="form-inner">
                  <form action="<?= route_to('sk_bebas_perpustakaan') ?>" method="post">
                    <div class="row">
                    </div>
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