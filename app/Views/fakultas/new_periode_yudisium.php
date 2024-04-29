<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<?= $this->extend('layout/default'); ?>

<?= $this->section('head'); ?>

<title>SIYUDIS | Buat Periode Baru</title>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper pt-5 mt-3">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kelola Periode</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a class="warna-ketiga" href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Periode Baru</li>
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Buat Periode Yudisium Baru</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="">
            <?php if ($warning): ?>
                <div class=" bg-danger text-white p-2 mb-3 rounded">
                    <strong>Perhatian!</strong>
                    <br>
                    Membuka periode baru akan menutup periode sebelumnya.
                    <br>
                    Pendafataran yudisium yang belum divalidasi akan ditolak otomatis.
                    <br>
                    
                </div>
            <?php endif; ?>
            
            <?= form_open(route_to('fakultas.periode_yudisium'), ['class' => 'form']) ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="periode" class="form-label">Periode</label>
                            <?= form_input('periode', '', ['class' => 'form-control mb-2', 'id' => 'periode', 'onkeydown' => 'document.getElementById("reset-periode").classList.remove("disabled")']) ?>
                            <button type="button" class="btn btn-warning disabled" onclick="setPeriode()" id="reset-periode">Reset</button>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                            <?= form_input('tanggal_awal', '', ['class' => 'form-control', 'id' => 'tanggal_awal'], 'date') ?>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                            <?= form_input('tanggal_akhir', '', ['class' => 'form-control', 'id' => 'tanggal_akhir'], 'date') ?>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Buat Periode</button>
                            <a href="<?= route_to('fakultas.periode_yudisium') ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="field-container">
                        </div>

                        <button type="button" class="btn btn-primary" id="add-field">Tambah Link</button>
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

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script>
    function setPeriode() {
        let periodeInput = document.getElementById('periode');
        let date = new Date();
        let month = date.toLocaleString('id-ID', { month: 'long' });
        let year = date.getFullYear();
        periodeInput.value = month + '/' + year;
        document.getElementById('reset-periode').classList.add('disabled');
    }

    window.onload = setPeriode;

    const deleteFunction = function(e) {
        let index = e.target.getAttribute('target-index');
        let field = document.querySelector('.link-field[field-index="' + index + '"]');

        if (field.querySelector('input[name="link_grup_whatsapp[]"]').value.trim() !== '' || field.querySelector('input[name="keterangan[]"]').value.trim() !== '') {
            if (!confirm('Apakah anda yakin ingin menghapus link ini?')) {
                return;
            }
        }

        field.remove();
    };

    document.addEventListener('DOMContentLoaded', function() {
        let deleteFieldButtons = document.querySelectorAll('.delete-field');

        deleteFieldButtons.forEach(function(button) {
            button.addEventListener('click', deleteFunction);
        });

        let addFieldButton = document.getElementById('add-field');

        addFieldButton.addEventListener('click', function() {
            let fieldIndex = Date.now(); // Unique index
            let field = document.createElement('div');
            field.classList.add('link-field');
            field.setAttribute('field-index', fieldIndex);
            field.innerHTML = `
                <div class="row mb-2">
                    <div class="col">
                        <label for="link" class="form-label col">Link</label>
                        <input type="text" name="link_grup_whatsapp[]" class="form-control col">
                    </div>
                    <div class="col">
                        <label for="keterangan" class="form-label col">Keterangan</label>
                        <input type="text" name="keterangan[]" class="form-control col">
                    </div>
                </div>
                <button type="button" class="btn btn-danger delete-field" target-index="${fieldIndex}">Hapus</button>
                <hr>
            `;

            field.querySelector('.delete-field').addEventListener('click', deleteFunction);

            document.querySelector('.field-container').appendChild(field);
        });
    });

</script>
<?= $this->endSection(); ?>