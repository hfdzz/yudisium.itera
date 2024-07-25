<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<?= $this->extend('layout/default'); ?>

<?= $this->section('head'); ?>

  <title>SIYUDIS | Pendaftaran Yudisium</title>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper pt-5 mt-3">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Cek Status Pendaftaran</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Cek Status Pendaftaran</li>
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
            <div class="card">
              <div class="card-body">

                <?php if ($yudisium_pendaftaran?->isSelesai()): ?>
                <!-- Yudisium Selesai View -->

                <div class="alert alert-success">
                  <i class="icon fas fa-check"></i>
                  <span>Pendaftaran Yudisium telah selesai.</span>
                </div>
                <div>
                  <a href="<?= route_to('file_tanda_terima_yudisium', $yudisium_pendaftaran?->id) ?>" class="mx-1" target="_blank">Lihat Tanda Terima Yudisium</a>
                </div>

                <?php if(!empty($yudisium_pendaftaran->keterangan)) : ?>
                <!-- Keterangan -->

                <div class="alert alert-info">
                  <p class="m-0"><strong>Keterangan:</strong></p>
                  <?= $yudisium_pendaftaran->keterangan ?>
                </div>
                <?php endif; ?>

                <div>
                  Informasi Yudisium:
                </div>

                <?php foreach($yudisium_pendaftaran->getYudisiumPeriode()->yudisiumPeriodeInformasi() as $informasi): ?>
                  <!-- Informasi Yudisium -->

                  <div class="alert alert-info">
                    <div>
                      <strong>
                        <?= $informasi->keterangan ?>
                      </strong>
                    </div>
                    <div>
                      <a href="<?= $informasi->link_grup_whatsapp ?>" target="_blank"><?= $informasi->link_grup_whatsapp ?></a>
                    </div>
                  </div>
                <?php endforeach; ?>

                <?php elseif ($yudisium_periode?->isOpen()): ?>
                <!-- Yudisium Periode Open View -->

                  <?php if ($yudisium_pendaftaran?->isMenungguValidasi()): ?>
                  <!-- Yudisium Menunggu Validasi View -->

                  <div class="alert alert-info">
                    <i class="icon fas fa-info"></i>
                    <span>Pendaftaran Yudisium sedang menunggu validasi.</span>
                  </div>

                  <?php elseif (!$yudisium_pendaftaran || $yudisium_pendaftaran?->canDafarYudisium()): ?>
                  <!-- Yudisium Form View -->
                  
                  <form class="" action="" method="post" enctype="multipart/form-data">
                    <div class="d-flex justify-content-center align-items-center py-2 mb-3" style="background-color: #EEC01D; border-radius: 20px;">
                      <b>Form Pendaftaran Yudisium</b>
                    </div>

                    <?php if(!empty($yudisium_pendaftaran->keterangan)): ?>
                    <div class="alert <?= $yudisium_pendaftaran->isDitolak() ? 'alert-danger' : 'alert-warning' ?>">
                      <p class="m-0"><strong>Keterangan:</strong></p>
                      <?= $yudisium_pendaftaran->keterangan ?>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                      <div class="col-lg-12 col-12">
                        <br>
                        <div class="card card-warning card-outline p-3">
                          <div class="inner">
                            <i class="fas fa-info-circle"></i>
                            <span class="card-info">Informasi Pendaftaran Yudisium</span>
                            <ol>
                              <li>Silahkan upload masing-masing berkas persyaratan dengan menggunakan format file pdf (max 2mb)</li>
                              <li>Pastikan untuk melakukan pengajuan Surat Keterangan Bebas UKT, Surat Keterangan Bebas Perpustakaan, dan Surat Keterangan Bebas Laboratorium terlebih dahulu sebelum berkas lainnya.</li>
                              <li>Khusus Mahasiswa beasiswa dapat mengajukan pendaftaran yudisium dengan mengupload Surat Keterangan Mahasiswa dari Bagian Akademik ITERA</li>
                              <li>Pastikan berkas yang diupload terlihat jelas dan tidak blur.</li>
                              <li>Pendaftaran hanya dapat dilakukan sekali dalam satu periode</li>
                              <li>Mahasiswa yang telah selesai melakukan pendaftaran yudisium diwajibkan untuk bergabung pada link whatsapp sesuai dengan prodi masing-masing</li>
                              <li>Apabila terdapat kendala dalam pendaftaran yudisium, silahkan menghubungi administrator fakultas di Gedung C Fakultas Teknologi Industri</li>
                            </ol>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-4">
                        <div><strong>Surat Bebas Perpustakaan</strong></div>
                        <div>
                          <?= view_cell('\App\Cells\StatusSuratKeterangan::renderBadgeAndLink', ['status' => $sk_bebas_perpustakaan?->status, 'url_ajukan' => route_to('mahasiswa.sk_bebas_perpustakaan'), 'url_lihat_surat' => $sk_bebas_perpustakaan ? route_to('file_surat_keterangan', $sk_bebas_perpustakaan?->id):null]) ?>
                        </div>
                      </div>

                      <div class="col-4">
                        <div><strong>Surat Bebas UKT</strong></div>
                        <div>
                          <?= view_cell('\App\Cells\StatusSuratKeterangan::renderBadgeAndLink', ['status' => $sk_bebas_ukt?->status, 'url_ajukan' => route_to('mahasiswa.sk_bebas_ukt'), 'url_lihat_surat' => $sk_bebas_ukt ? route_to('file_surat_keterangan', $sk_bebas_ukt?->id):null]) ?>
                        </div>
                      </div>

                      <div class="col-4">
                        <div><strong>Surat Bebas Laboratorium</strong></div>
                        <div>
                          <?= view_cell('\App\Cells\StatusSuratKeterangan::renderBadgeAndLink', ['status' => $sk_bebas_laboratorium?->status, 'url_ajukan' => 'https://silabor.itera.ac.id', 'url_lihat_surat' => $sk_bebas_laboratorium?->surat, 'target' => '_blank']) ?>
                        </div>
                      </div>

                      <div class="form-group col-6">
                        <label class="form-label" for="berkas_transkrip">Transkrip</label>
                        <input type="file" class="form-control" name="berkas_transkrip" id="berkas_transkrip"  placeholder="transkrip">
                      </div>

                      <div class="form-group col-6">
                        <label class="form-label" for="berkas_sertifikat_bahasa_inggris">Sertifikat TOEFL</label>
                        <input type="file" class="form-control" name="berkas_sertifikat_bahasa_inggris" id="berkas_sertifikat_bahasa_inggris"  placeholder="toefl">
                      </div>

                      <div class="form-group col-6">
                        <label class="form-label" for="berkas_ijazah">Ijazah SMA</label>
                        <input type="file" class="form-control" name="berkas_ijazah" id="berkas_ijazah"  placeholder="ijazah">
                      </div>

                      <div class="form-group col-6">
                        <label class="form-label" for="berkas_pas_foto">Foto 3x4</label>
                        <input type="file" class="form-control" name="berkas_pas_foto" id="berkas_pas_foto"  placeholder="foto">
                      </div>

                      <div class="form-group col-6">
                        <label class="form-label" for="berkas_akta_kelahiran">Akta kelahiran</label>
                        <input type="file" class="form-control" name="berkas_akta_kelahiran" id="berkas_akta_kelahiran"  placeholder="akta">
                      </div>

                      <div class="form-group col-6">
                        <label class="form-label" for="berkas_surat_keterangan_mahasiswa">Surat Keterangan Mahasiswa (Penerima Beasiswa)</label>
                        <input type="file" class="form-control" name="berkas_surat_keterangan_mahasiswa" id="berkas_surat_keterangan_mahasiswa" placeholder="surat_lunas"  <?= $sk_bebas_ukt?->status == STATUS_SELESAI_BEASISWA ? 'enabled required' : 'disabled' ?>>
                      </div>

                      <div class="form-group col-6">
                        <label class="form-label" for="berkas_surat_keterangan_mahasiswa">BA Sidang</label>
                        <input type="file" class="form-control" name="berkas_surat_keterangan_mahasiswa" id="berkas_surat_keterangan_mahasiswa" enabled placeholder="surat_lunas">
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

                    <div class="d-flex justify-content-center align-items-center">
                      <button type="submit" class="btn text-white px-5" style="background-color: #EEC01D;">DAFTAR</button>
                    </div>
                  </form>
                
                <?php endif; ?>

                <?php else: ?>
                <!-- Yudisium Closed View -->
                  
                  <div class="alert alert-danger">
                    <i class="icon fas fa-times"></i>
                    <span>Pendaftaran Yudisium belum dibuka atau sudah ditutup.</span>
                  </div>

                <?php endif; ?>
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