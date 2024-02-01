<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>
<?= $this->extend('layout/guest') ?>

<?= $this->section('content') ?>
<div>
    <div>
        <h1>Login</h1>
        <?php if(session()->has('errors')): ?>
            <ul>
                <?php foreach(session()->get('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
            </ul>
        <?php endif ?>
    </div>
    <div>
        <form action="<?= route_to('login') ?>" method="post">
            <?= csrf_field() ?>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>