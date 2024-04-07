<?php
    /**
     * @var \CodeIgniter\View\View $this
     */

    /**
     * If no latest periode (first time opening this page), offer to create new periode
     * 
     * If latest periode exists, show the form to edit the periode or offer to create new periode
     */
?>

<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="p-4">
    <div class="rounded p-3" style="background-color: #f3f3f3;">
        <div>
            <h1>Buat Periode Yudisium Baru</h1>
        </div>
        <div class="">

        <?= form_open(route_to('fakultas.periode_yudisium'), ['class' => 'form']) ?>
            <div class="row">

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="periode" class="form-label">Periode</label>
                        <?= form_input('periode', '', ['class' => 'form-control mb-2', 'id' => 'periode']) ?>
                        <button type="button" class="btn btn-primary" onclick="setPeriode()">Reset</button>
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

<script>
    function setPeriode() {
        var periodeInput = document.getElementById('periode');
        var date = new Date();
        var month = date.toLocaleString('id-ID', { month: 'long' });
        var year = date.getFullYear();
        periodeInput.value = month + '/' + year;
    }

    window.onload = setPeriode;

    const deleteFunction = function(e) {
        var index = e.target.getAttribute('target-index');
        var field = document.querySelector('.link-field[field-index="' + index + '"]');

        if (field.querySelector('input[name="link_grup_whatsapp[]"]').value.trim() !== '' || field.querySelector('input[name="keterangan[]"]').value.trim() !== '') {
            if (!confirm('Apakah anda yakin ingin menghapus link ini?')) {
                return;
            }
        }

        field.remove();
    };

    document.addEventListener('DOMContentLoaded', function() {
        var deleteFieldButtons = document.querySelectorAll('.delete-field');

        deleteFieldButtons.forEach(function(button) {
            button.addEventListener('click', deleteFunction);
        });

        var addFieldButton = document.getElementById('add-field');

        addFieldButton.addEventListener('click', function() {
            var fieldIndex = Date.now(); // Unique index
            var field = document.createElement('div');
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
<?= $this->endSection() ?>