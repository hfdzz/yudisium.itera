<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="p-4">
    <div class="rounded p-3" style="background-color: #f3f3f3;">
        <div>
            <h1>Periode Yudisium</h1>
        </div>
        <div class="">
            
            <div class="mb-2">
                <a href="<?= route_to('fakultas.new_periode_yudisium') ?>" class="btn btn-primary">
                    Buat Periode Baru
                </a>
            </div>

        <?php if ($latest_periode): ?>

            <?= form_open(route_to('fakultas.periode_yudisium'), ['class' => 'form']) ?>
                <?= form_hidden('id', $latest_periode->id) ?>
                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="mb-1">
                                <span>Periode Terakhir: </span>
                                <br>
                                <span><?= $latest_periode->periode ?></span>
                            </div>
                            <div class="mb-1">
                                <?php if ($latest_periode->isOpen()): ?>
                                    <span class="badge bg-success">Periode sedang berlangsung</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Periode sudah berakhir atau belum dimulai</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                            <?= form_input('tanggal_awal', $latest_periode->tanggal_awal, ['class' => 'form-control', 'id' => 'tanggal_awal'], 'date') ?>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                            <?= form_input('tanggal_akhir', $latest_periode->tanggal_akhir, ['class' => 'form-control', 'id' => 'tanggal_akhir'], 'date') ?>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <?php if ($latest_periode->isOpen()): ?>
                                <button type="button" class="btn btn-danger" onclick="if (confirm('Apakah anda yakin ingin menutup periode ini?')) { closePeriode(); }">Tutup Periode</button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="field-container">
                            <?php foreach ($informasi as $info): ?>
                                <div class="link-field mb-3" field-index="<?= $info->id ?>">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label for="link" class="form-label col">Link</label>
                                            <?= form_input('link_grup_whatsapp[]', $info->link_grup_whatsapp, ['class' => 'form-control col']) ?>
                                        </div>
                                        <div class="col">
                                            <label for="keterangan" class="form-label col">Keterangan</label>
                                            <?= form_input('keterangan[]', $info->keterangan, ['class' => 'form-control col']) ?>
                                        </div>
                                    </div>
                                    <!-- index from current loop index -->
                                    <button type="button" class="btn btn-danger delete-field" target-index="<?= $info->id ?>">Hapus</button>
                                    <hr>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button type="button" class="btn btn-primary" id="add-field">Tambah Link</button>
                    </div>

                </div>
            <?= form_close() ?>

        <?php else: ?>
                
                <div class="alert alert-warning" role="alert">
                    Belum ada periode yudisium yang dibuat
                </div>

        <?php endif; ?>

        </div>
    </div>
</div>

<script>

    function closePeriode() {
        var form = document.querySelector('.form');
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'close_periode';
        input.value = '1';
        form.appendChild(input);
        form.submit();
    }

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