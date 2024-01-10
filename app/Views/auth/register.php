<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>
<?= $this->extend('layout/guest') ?>

<?= $this->section('content') ?>
<div>
    <div>
        <h1>Register</h1>
        <?php if(session()->has('errors')): ?>
            <ul>
                <?php foreach(session()->get('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
            </ul>
        <?php endif ?>
    </div>
    <div>
        <form action="<?= route_to('register') ?>" method="post">
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div>
                <label for="password_confirm">Password Confirm</label>
                <input type="password" name="password_confirm" id="password_confirm" required>
            </div>
            <div>
                <label for="nim">NIM</label>
                <input type="text" name="nim" id="nim" required>
            </div>
            <div>
                <label for="proram_studi">Program Studi</label>
                <input type="text" name="program_studi" id="program_studi" required>
            </div>
            </div>
            <div>
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>