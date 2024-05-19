<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<?= $this->extend('layout/default'); ?>

<?= $this->section('head'); ?>

<title>SIYUDIS | Validasi Pendaftaran</title>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper pt-5 mt-3">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Validasi Pendaftaran</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Validasi Pendaftaran</li>
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
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">No</th>
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">Tanggal</th>
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">Nama</th>
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">NIM</th>
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">Prodi</th>
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">Transkrip</th>
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">FC Ijazah SMA</th>
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">Pas Foto 3x4</th>
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">Sertifikat TOEFL</th>
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">FC Akta Kelahiran</th>
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">Surat Keterangan Mahasiswa</th>
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">BA Sidang</th>
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">SK Bebas UKT</th>
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">SK Bebas Pustaka</th>
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">SK Bebas Lab</th>
                      <!-- <th class="small align-items-center m-0" style="background-color: #EEC01D;">Detail Berkas</th> -->
                      <th class="small align-items-center m-0" style="background-color: #EEC01D;">Status</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php $i=1; foreach($pendaftaran as $p): ?>
                    <tr>
                      <td><?= $i++; ?></td>
                      <td><?= $p->tanggal_daftar; ?></td>
                      <td><?= $p->username; ?></td>
                      <td><?= $p->nim; ?></td>
                      <td><?= $p->program_studi; ?></td>
                      <td><?= view_cell('\App\Cells\LinkTextCell::uploadedFileYudisiumLink', ['path' => $p->berkas_transkrip, 'id' => $p->id, 'jenis_berkas' => 'berkas_transkrip']) ?></td>
                      <td><?= view_cell('\App\Cells\LinkTextCell::uploadedFileYudisiumLink', ['path' => $p->berkas_ijazah, 'id' => $p->id, 'jenis_berkas' => 'berkas_ijazah']) ?></td>
                      <td><?= view_cell('\App\Cells\LinkTextCell::uploadedFileYudisiumLink', ['path' => $p->berkas_pas_foto, 'id' => $p->id, 'jenis_berkas' => 'berkas_pas_foto']) ?></td>
                      <td><?= view_cell('\App\Cells\LinkTextCell::uploadedFileYudisiumLink', ['path' => $p->berkas_sertifikat_bahasa_inggris, 'id' => $p->id, 'jenis_berkas' => 'berkas_sertifikat_bahasa_inggris']) ?></td>
                      <td><?= view_cell('\App\Cells\LinkTextCell::uploadedFileYudisiumLink', ['path' => $p->berkas_akta_kelahiran, 'id' => $p->id, 'jenis_berkas' => 'berkas_akta_kelahiran']) ?></td>
                      <td>
                        <?php if ($p->getSuratKeterangan(JENIS_SK_BEBAS_UKT)?->isBeasiswa()): ?>
                          <?= view_cell('\App\Cells\LinkTextCell::uploadedFileYudisiumLink', ['path' => $p->berkas_surat_keterangan_mahasiswa, 'id' => $p->id, 'jenis_berkas' => 'berkas_surat_keterangan_mahasiswa']) ?>
                        <?php else: ?>
                          <!-- Give user indication that this mahasiswa is not beasiswa -->
                          <span class="text-sm text-gray">Tidak Beasiswa</span>
                        <?php endif; ?>
                      </td>
                      <td><?= view_cell('\App\Cells\LinkTextCell::uploadedFileUKTLink', ['path' => $p->getSuratKeterangan(JENIS_SK_BEBAS_UKT)?->berkas_ba_sidang, 'id' => $p->getSuratKeterangan(JENIS_SK_BEBAS_UKT)?->id, 'jenis_berkas' => 'berkas_ba_sidang']) ?></td>
                      
                      <td><?= view_cell('\App\Cells\LinkTextCell::skLink', ['sk_id' => $p->getSuratKeterangan(JENIS_SK_BEBAS_PERPUSTAKAAN)?->id]) ?></td>
                      <td><?= view_cell('\App\Cells\LinkTextCell::skLink', ['sk_id' => $p->getSuratKeterangan(JENIS_SK_BEBAS_UKT)?->id]) ?></td>
                      <td><?= view_cell('\App\Cells\LinkTextCell::bebasLabLink', ['sk_bebaslab' => $p->getSuratKeterangan(JENIS_SK_BEBAS_LABORATORIUM)]) ?></td>
                      <td>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalTerima" data-id="<?= $p->id; ?>">Terima</button>
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalTolak" data-id="<?= $p->id; ?>">Tolak</button>
                      </td>
                    </tr>

                  <?php endforeach; ?>
                  </tbody>
                </table>
                </div>
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
          
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Terima -->
  <div class="modal fade" id="modalTerima">
    <div class="modal-dialog">
      <form class="modal-content" method="post" action="<?= route_to('fakultas.validasi_yudisium'); ?>">

        <input type="hidden" name="id" id="id">

        <div class="modal-header">
          <h4 class="modal-title">Terima Pengajuan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <p>Apakah Anda yakin ingin menerima pengajuan ini?</p>
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
      <form class="modal-content" method="post" action="<?= route_to('fakultas.validasi_yudisium'); ?>">

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
</script>

<?= $this->endSection(); ?>