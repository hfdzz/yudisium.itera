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
                <div class="d-flex justify-content-between mb-3">
                  <div class="d-flex align-items-center">
                    <label for="periode_filter" class="form-label mb-0 flex-shrink-0">
                      Periode Pengajuan:
                    </label>
                    <select class="form-control ml-2" name="periode_filter" id="periode_filter">
                      <option value="">Semua Periode</option>
                      <?php foreach ($tanggal_pengajuan_month_year_list as $tanggal_pengajuan) : ?>
                        <option value="<?= $tanggal_pengajuan['month'] . '_' . $tanggal_pengajuan['year']; ?>"
                          <?= $tanggal_pengajuan['month'] . '_' . $tanggal_pengajuan['year'] === $tanggal_pengajuan_filter ? 'selected' : ''; ?>>
                          <?= $tanggal_pengajuan['month'] . '/' . $tanggal_pengajuan['year']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th style="background-color: #EEC01D;">No</th>
                      <th style="background-color: #EEC01D;">Tanggal</th>
                      <th style="background-color: #EEC01D;">Nama</th>
                      <th style="background-color: #EEC01D;">NIM</th>
                      <th style="background-color: #EEC01D;">Prodi</th>
                      <th style="background-color: #EEC01D;">Status</th>
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
                          <td>
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalTerima" data-id="<?= $sk->id; ?>">Terima</button>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalTolak" data-id="<?= $sk->id; ?>">Tolak</button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
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

  <!-- Modal Terima -->
  <div class="modal fade" id="modalTerima">
    <div class="modal-dialog">
      <form class="modal-content" method="post" action="<?= route_to('upt-perpustakaan.validasi-surat-keterangan'); ?>">

        <input type="hidden" name="id" id="id">

        <div class="modal-header">
          <h4 class="modal-title">Terima Pengajuan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

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

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success" name="action" value="validasi">Terima</button>
        </div>

      </form>
    </div>
  </div>

  <!-- Modal Tolak -->
  <div class="modal fade" id="modalTolak">
    <div class="modal-dialog">
      <form class="modal-content" method="post" action="<?= route_to('upt-perpustakaan.validasi-surat-keterangan'); ?>">

        <input type="hidden" name="id" id="id">
      
        <div class="modal-header">
          <h4 class="modal-title">Tolak Pengajuan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
              <label for="keterangan">Alasan Penolakan</label>
              <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
        </div>

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

  $('#modalTolak').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    console.log(id);
    var modal = $(this);
    modal.find('input[name="id"]').val(id);
  });

  $(document).ready(function() {
    $('#periode_filter').on('change', function() {
      let params = new URLSearchParams(window.location.search);
      if ($(this).val() === '') {
        params.delete('tanggal_pengajuan');
        window.location.href = window.location.pathname;
      } else {
        params.set('tanggal_pengajuan', $(this).val());
        window.location.search = params.toString();
      }
    });
  });
</script>

<?= $this->endSection(); ?>