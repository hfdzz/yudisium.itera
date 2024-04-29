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
            <h1 class="m-0">Kelola Data Bebas Pustaka</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Kelola Data Bebas Pustaka</li>
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
                      <select class="rounded font-weight-bold btn btn-default px-0 btn-sm" id="filterStatus" style="width: 120px;">
                        <option value="">Filter Status</option>
                        <option value="selesai">Selesai</option>
                        <option value="menunggu validasi">Menunggu Validasi</option>
                        <option value="ditolak">Ditolak</option>
                      </select>
                    </th>
                    <!-- <th style="background-color: #EEC01D;">Periode</th> -->
                    <!-- <th style="background-color: #EEC01D;">Tahun</th> -->
                    <!-- <th style="background-color: #EEC01D;">SK Bebas Pustaka</th> -->
                    <th style="background-color: #EEC01D;">Surat</th>
                    <th style="background-color: #EEC01D;">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($sk_bebas_perpustakaan as $sk) : ?>
                      <tr>
                        <td></td>
                        <td><?= $sk->tanggal_pengajuan; ?></td>
                        <td><?= $sk->mahasiswa_name; ?></td>
                        <td><?= $sk->mahasiswa_nim; ?></td>
                        <td><?= $sk->mahasiswa_program_studi; ?></td>
                        <td class="text-center"><?= view_cell('StatusSuratKeterangan::renderBadge', ['status' => $sk->status]) ?></td>
                        <td>
                          <?php if ($sk->isSelesai()) : ?>
                            <a href="<?= route_to('file_surat_keterangan', $sk->id) ?>" class="btn btn-sm btn-warning" target="_blank" >Lihat</a>
                          <?php endif; ?>
                        </td>
                        <td class="text-center">
                          <a href="<?= site_url('upt_perpustakaan/bebas-perpustakaan/edit/' . $sk->id) ?>" class="btn btn-warning btn-sm">Edit</a>
                          <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapus" data-action="<?= site_url('upt_perpustakaan/bebas-perpustakaan/delete/' . $sk->id) ?>">Hapus</button>
                          <a href="<?= site_url('upt_perpustakaan/bebas-perpustakaan/' . $sk->id) ?>" class="btn btn-success btn-sm">Detail</a>
                        </td>
                      </tr>
                    <?php endforeach; ?>

                  <!-- <tr>
                    <td>1</td>
                    <td>2020-01-01</td>
                    <td>Gery</td>
                    <td>123456</td>
                    <td>Sistem Informasi</td>
                    <td><p class="small text-center rounded bg-success" disabled>Diterima</p></td>
                    <td>Januari</td>
                    <td>2023</td>
                    <td>Diterbitkan</td>
                    <td><button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalBerkas">Lihat</button></td>
                    <td class="text-center">
                      <a href="edit.html" class="btn btn-warning btn-sm">Edit</a>
                      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapus">Hapus</button>
                      <a href="detail.html" class="btn btn-success btn-sm">Detail</a>
                    </td>
                  </tr> -->
                  </tbody>
                  <tfoot>
                  <tr>
                    <th style="background-color: #EEC01D;">No</th>
                    <th style="background-color: #EEC01D;">Tanggal</th>
                    <th style="background-color: #EEC01D;">Nama</th>
                    <th style="background-color: #EEC01D;">NIM</th>
                    <th style="background-color: #EEC01D;">Prodi</th>
                    <th style="background-color: #EEC01D;">Status Berkas</th>
                    <!-- <th style="background-color: #EEC01D;">Periode</th> -->
                    <!-- <th style="background-color: #EEC01D;">Tahun</th> -->
                    <!-- <th style="background-color: #EEC01D;">SK Bebas Pustaka</th> -->
                    <th style="background-color: #EEC01D;">Surat</th>
                    <th style="background-color: #EEC01D;">Aksi</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <a href="<?= site_url('upt_perpustakaan/bebas-perpustakaan/new') ?>" class="btn btn-primary">Tambah Data</a>
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
          <form action="" method="post">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">Hapus</button>
          </form>
        </div>

      </div>
    </div>
  </div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
  $('#modalHapus').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    let action = button.data('action');
    let modal = $(this);
    modal.find('form').attr('action', action);
  });
</script>
<?= $this->endSection(); ?>