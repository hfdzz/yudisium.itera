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
            <h1 class="m-0">Validasi Berkas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Validasi Berkas</li>
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
                    <th style="background-color: #EEC01D;">Tanggal Sidang</th>
                    <th style="background-color: #EEC01D;">BA Sidang</th>
                    <th style="background-color: #EEC01D;">Transkrip (Tertanda tangan)</th>
                    <th style="background-color: #EEC01D;">SS AVITA</th>
                    <!-- <th style="background-color: #EEC01D;">Detail Berkas</th> -->
                    <th style="background-color: #EEC01D;">Status</th>
                    <!-- <th style="background-color: #EEC01D;">Surat Bebas UKT</th> -->
                  </tr>
                  </thead>
                  <tbody>

                  <?php foreach ($surat_keterangan as $sk) : ?>
                    <tr>
                      <td></td>
                        <td><?= $sk->tanggal_pengajuan; ?></td>
                        <td><?= $sk->mahasiswa_username; ?></td>
                        <td><?= $sk->mahasiswa_nim; ?></td>
                        <td><?= $sk->mahasiswa_program_studi; ?></td>
                        <td><?= $sk->tanggal_sidang; ?></td>
                        <!-- <td><button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalBerkas">Lihat</button></td> -->
                        <td><a href="<?= route_to('berkas_bebas_ukt', $sk->id, 'berkas_ba_sidang') ?>" target="_blank" class="btn btn-sm btn-warning">Lihat</a></td>
                        <td><a href="<?= route_to('berkas_bebas_ukt', $sk->id, 'berkas_transkrip') ?>" target="_blank" class="btn btn-sm btn-warning">Lihat</a></td>
                        <td><a href="<?= route_to('berkas_bebas_ukt', $sk->id, 'berkas_bukti_bayar_ukt') ?>" target="_blank" class="btn btn-sm btn-warning">Lihat</a></td>
                        <!-- <td><button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#detailBerkas">Lihat</button></td> -->
                        <td>
                          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalTerima" data-id="<?= $sk->id; ?>">Terima</button>
                          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalBeasiswa" data-id="<?= $sk->id; ?>">Beasiswa</button>
                          <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalTolak" data-id="<?= $sk->id; ?>">Tolak</button>
                        </td>
                        <!-- <td><button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal">Buat</button></td> -->
                    </tr>
                  <?php endforeach; ?>

                  <!-- <tr>
                    <td>1</td>
                    <td>2020-01-01</td>
                    <td>Gery</td>
                    <td>123456</td>
                    <td>Sistem Informasi</td>
                    <td><button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalBerkas">Lihat</button></td>
                    <td><button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalBerkas">Lihat</button></td>
                    <td><button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalBerkas">Lihat</button></td>
                    <td><button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#detailBerkas">Lihat</button></td>
                    <td>
                      <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalTerima">Terima</button>
                      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalTolak">Tolak</button>
                    </td>
                    <td><button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal">Buat</button></td>
                  </tr> -->

                  </tbody>
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

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Modal Content Goes Here
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
          <!-- Additional buttons can be added here -->
        </div>
      </div>
    </div>
  </div>
  
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

  <!-- Modal Detail Berkas -->
  <div class="modal fade" id="detailBerkas" tabindex="-1" role="dialog" aria-labelledby="detailBerkasLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailBerkasLabel">Detail Berkas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <embed src="../../../assets/img/logo-fti.png" type="">
          <embed src="../../../assets/img/logo-fti.png" type="">
          <embed src="../../../assets/img/logo-fti.png" type="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
          <!-- Additional buttons can be added here -->
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Terima -->
  <div class="modal fade" id="modalTerima">
    <div class="modal-dialog">
      <form class="modal-content" method="post" action="<?= route_to('keuangan.validasi-surat-keterangan'); ?>">
        <?= csrf_field(); ?>
        <input type="hidden" name="id" id="id">
                  
        <!-- Header modal -->
        <div class="modal-header">
          <h4 class="modal-title">Terima Pengajuan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Isi modal -->
        <div class="modal-body">
          <div class="form-group">
            <label for="nomor_surat">Nomor Surat</label>
            <input type="text" class="form-control" name="nomor_surat" placeholder="Nomor Surat" required>
          </div>
          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan..."></textarea>
          </div>
        </div>

        <!-- Footer modal -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success" name="action" value="validasi">Terima</button>
        </div>

      </form>
    </div>
  </div>

  <!-- Modal Beasiswa -->
  <div class="modal fade" id="modalBeasiswa">
    <div class="modal-dialog">
      <form class="modal-content" method="post" action="<?= route_to('keuangan.validasi-surat-keterangan'); ?>">
        <?= csrf_field(); ?>
        <input type="hidden" name="id" id="id">
                  
        <!-- Header modal -->
        <div class="modal-header">
          <h4 class="modal-title">Terima Pengajuan (Beasiswa)</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Isi modal -->
        <div class="modal-body">
          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Keterangan..."></textarea>
          </div>
        </div>

        <!-- Footer modal -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-info" name="action" value="validasi_beasiswa">Terima (Beasiswa)</button>
        </div>

      </form>
    </div>
  </div>

  <!-- Modal Tolak -->
  <div class="modal fade" id="modalTolak">
    <div class="modal-dialog">
      <form method="post" action="<?= route_to('upt-perpustakaan.validasi-surat-keterangan'); ?>" class="modal-content">
        <?= csrf_field(); ?>
        <input type="hidden" name="id" id="id">

        <!-- Header modal -->
        <div class="modal-header">
          <h4 class="modal-title">Tolak Pengajuan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Isi modal -->
        <div class="modal-body">
            <label for="keterangan">Alasan Penolakan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
        </div>

        <!-- Footer modal -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger" name="action" value="tolak">Tolak</button>
        </div>

      </form>
    </div>
  </div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script>
  $('#modalTerima').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    console.log(id);
    var modal = $(this);
    modal.find('input[name="id"]').val(id);
  });

  $('#modalBeasiswa').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    console.log(id);
    var modal = $(this);
    modal.find('input[name="id"]').val(id);
  });

  $('#modalTolak').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    console.log(id);
    var modal = $(this);
    modal.find('input[name="id"]').val(id);
  });
</script>

<?= $this->endSection(); ?>