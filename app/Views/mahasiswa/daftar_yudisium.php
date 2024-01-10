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
            <h1>Daftar Yudisium</h1>
        </div>
        <div class="w-100">
            <div>
                <?= validation_list_errors() ?>

                <?= form_open('form') ?>

                <div class="mb-3">
                    
                </div>
    
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>