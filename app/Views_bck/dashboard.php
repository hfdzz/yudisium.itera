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
            <h1>Dashboard</h1>
        </div>
        <div class="d-flex">
           <div class="card col-2">
                <span>Total:</span>
                <span>100</span>
           </div>
           <div class="card col-2">
                <span>Total:</span>
                <span>100</span>
           </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
