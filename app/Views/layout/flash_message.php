
<?php if(session()->getFlashdata() != null) : ?>
    <?php if(session()->getFlashdata('success') != null) : ?>
    <div>
        <div class="container-fluid px-4 py-2">
            <div class="bg-success text-white p-3 rounded">
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
        </div>
    </div>
    <?php endif ?>

    <?php if(session()->getFlashdata('error') != null) : ?>
    <div>
        <div class="container-fluid px-4 py-2">
            <?php foreach(session()->getFlashdata('error') as $error) : ?>
            <div class="bg-danger text-white p-3 rounded my-2">
                <span><?= $error ?></span>
            </div>
            <?php endforeach ?>
        </div>
    </div>
    <?php endif ?>
<?php endif ?>