<?php
    /**
     * @var \CodeIgniter\View\View $this
     */
?>

<?= $this->extend('layout/guest') ?>

<?= $this->section('head') ?>

<title>SB Admin 2 - Register</title>

<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-6"  style="background-color:#bfa757;">
        <div class="p-5">
            <div class="text-center">
                <img class="img-fluid" width="150px" src="../../assets/img/logo_fti.png" alt="">
                </div>    
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4 font-weight-bold">REGISTER PAGE</h1>
            </div>
            <form class="user" action="<?= route_to('register') ?>" method="post">
                <div class="form-group">
                    <input type="email" class="form-control" name="email" value="<?= old('email') ?>"
                        id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder="Enter Email Address...">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="username" id="username" value="<?= old('username') ?>"
                        placeholder="Enter Name...">
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" name="nim" id="nim" value="<?= old('nim') ?>"
                        placeholder="Enter NIM...">
                </div>
                <div class="form-group">
                    <select class="form-control" name="program_studi" id="program_studi">
                     <option value="Teknik Geofisika">Teknik Geofisika</option>
                        <option value="Teknik Geologi">Teknik Geologi</option>
                        <option value="Teknik Industri">Teknik Industri</option>
                        <option value="Teknik Mesin">Teknik Mesin</option>
                        <option value="Teknik Pertambangan">Teknik Pertambangan</option>
                        <option value="Rekayasa Minyak dan Gas">Rekayasa Minyak dan Gas</option>
                        <option value="Teknik Material">Teknik Material</option>
                        <option value="Teknik Elektro">Teknik Elektro</option>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Teknik Sistem Energi">Teknik Sistem Energi</option>
                        <option value="Teknik Biomedis">Teknik Biomedis</option>
                        <option value="Teknik Fisika">Teknik Fisika</option>
                        <option value="Rekayasa Instrumentasi dan Automasi">Rekayasa Instrumentasi dan Automasi</option>
                        <option value="Teknik Telekomunikasi">Teknik Telekomunikasi</option>
                        <option value="Rekayasa Keolahragaan">Rekayasa Keolahragaan</option>
                        <option value="Teknik Kimia">Teknik Kimia</option>
                        <option value="Teknik Biosistem">Teknik Biosistem</option>
                        <option value="Teknologi Industri Pertanian">Teknologi Industri Pertanian</option>
                        <option value="Teknologi Pangan">Teknologi Pangan</option>
                        <option value="Rekayasa Kehutanan">Rekayasa Kehutanan</option>
                        <option value="Rekayasa Kosmetik">Rekayasa Kosmetik</option>

                    </select>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password"
                        id="exampleInputPassword" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password_confirm"
                        id="exampleInputPassword" placeholder="Confirm Password">
                </div>
                <div>
                    <button type="submit" class="btn btn-warning btn-user btn-block">
                        Register
                    </button>
                </div>
                <hr>
            </form>
            <hr>
            <div class="text-center">
                <a class="small text-white" href="<?= route_to('login') ?>">Already have an account? Login!</a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 d-none d-lg-block p-0" style="background-image: url('../../assets/img/bg-login.png'); background-size: 130%; background-repeat: no-repeat; background-position: center;">
    <h2 class="pt-5 text-center mt-5 font-weight-bold" style="color: black;">WELCOME TO STUDENT PORTAL </h2>
    </div>
</div>

<?= $this->endSection() ?>