<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<?= $this->extend('layout/guest') ?>

<?= $this->section('head') ?>

<title>SB Admin 2 - Login</title>

<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-6"  style="background-color:#bfa757;">
        <div class="p-5">
            <div class="text-center">
                <img class="img-fluid" width="150px" src="../../assets/img/logo_fti.png" alt="">
                </div>    
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4 font-weight-bold">LOGIN PAGE</h1>
            </div>
            <form class="user" action="<?= route_to('login') ?>" method="post">
                <div class="form-group">
                    <input type="email" class="form-control" name="email" value="<?= old('email') ?>"
                        id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder="Enter Email Address...">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password"
                        id="exampleInputPassword" placeholder="Password">
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                        <input type="checkbox" name="remember"
                            class="custom-control-input" id="customCheck">
                        <label class="custom-control-label text-white" for="customCheck">Remember
                            Me</label>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-warning btn-user btn-block">
                        Login
                    </button>
                </div>
                <hr>
            </form>
            <hr>
            <div class="text-center">
                <a class="small text-white" href="<?= route_to('register') ?>">Create an Account!</a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 d-none d-lg-block p-0" style="background-image: url('../../assets/img/bg-login.png'); background-size: 100%; background-repeat: no-repeat; background-position: center;">
    
    <br>    <h2 class="pt-5 text-center mt-5 font-weight-bold" style="color: black;">WELCOME TO STUDENT PORTAL </h2>
    </div>
</div>

<?= $this->endSection() ?>