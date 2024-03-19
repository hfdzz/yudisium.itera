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

            <?php if ($current_periode): ?>

            <div class="mb-3">
                <?= form_open('fakultas/periode-yudisium') ?>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="periode" class="form-label">Periode sedang aktif</label>
                            <input type="text" class="form-control" id="periode" name="periode" value="<?= $current_periode->periode ?>" readonly>
                        </div>
    
                        <div class="form-group">
                            <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                            <input type="date" class="form-control" id="tanggal_awal"
                            name="tanggal_awal"
                            value="<?= $current_periode->tanggal_awal ?>"
                            >
                        </div>
                        <div class="form-group">
                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="tanggal_akhir"
                            name="tanggal_akhir"
                            value="<?= $current_periode->tanggal_akhir ?>"
                            >
                        </div>
                    </div>
                    <div class="col-4">
                        <div id="link-container">
                            <?php if (isset($informasi)): ?>
                                <?php foreach ($informasi as $index => $info): ?>
                                    <div class="border-bottom pb-2">
                                        <div class="form-group">
                                            <label for="link_<?= $index ?>" class="form-label">Link Grup WhatsApp</label>
                                            <input type="text" class="form-control" id="link_<?= $index ?>" name="link[]" value="<?= $info->link ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan_<?= $index ?>" class="form-label">Keterangan</label>
                                            <input type="text" class="form-control" id="keterangan_<?= $index ?>" name="keterangan[]" value="<?= $info->keterangan ?>">
                                        </div>
                                        <button type="button" class="btn btn-danger" target-index="<?= $index ?>">
                                            X
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <button type="button-addLink" class="btn btn-primary">
                            Tambah Link
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" disabled>
                    Simpan
                </button>

                <button type="reset" class="btn btn-secondary">
                    Reset
                </button>
                <?= form_close() ?>
            </div>

            <?php else: ?>

            <div>
                <?= validation_list_errors() ?>

                <?= form_open('fakultas/periode-yudisium') ?>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="periode" class="form-label">Buka Periode Baru</label>
                            <input type="text" class="form-control" id="periode" name="periode" value="<?= date('m') . '/' . (date('Y')) ?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                            <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="<?= old('tanggal_awal') ?>">
                        </div>
        
                        <div class="form-group">
                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?= old('tanggal_akhir') ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <div class="col-4">
                        <!-- Informasi Periode -->
                        <div id="link-container">
                        </div>
                        <div id="add-link" class="mt-3">
                            <button type="button-addLink" class="btn btn-primary">
                                Tambah Link
                            </button>
                        </div>
                    </div>
                </div>
                <?= form_close() ?>
            </div>

            <?php endif; ?>

        </div>
    </div>
</div>

<script>
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input');

    inputs.forEach(input => {
        input.addEventListener('change', () => {
            form.querySelector('button').disabled = false;
        });
    });

    form.querySelector('button[type="reset"]').addEventListener('click', () => {
        form.querySelector('#tanggal_awal').value = '';
        form.querySelector('#tanggal_akhir').value = '';
        form.querySelector('button').disabled = true;
    });

</script>
<script>
    const addLink = document.querySelectorAll('button[type="button-addLink"]');
    const linkContainer = document.querySelector('#link-container');
    const deleteButtons = linkContainer.querySelectorAll('button[target-index]');
    let index = linkContainer.children.length;
    
    addLink.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const link = document.createElement('div');
            link.classList.add('border-bottom', 'pb-2');
            link.innerHTML = `
                <div class="form-group">
                    <label for="link_${index}" class="form-label">Link Grup WhatsApp</label>
                    <input type="text" class="form-control" id="link_${index}" name="link[]" value="<?= old('link_[${index}]') ?>">
                </div>
                <div class="form-group">
                    <label for="keterangan_${index}" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan_${index}" name="keterangan[]" value="<?= old('keterangan_[${index}]') ?>">
                </div>
                <button type="button" class="btn btn-danger" target-index="${index}">
                    X
                </button>
            `;
            link.setAttribute('field-index', index);
            link.querySelector('button').addEventListener('click', () => {
                link.remove();
            });
            linkContainer.appendChild(link);
            index++;
        });
    });

    addLink.addEventListener('click', () => {
    });
</script>
<?= $this->endSection() ?>