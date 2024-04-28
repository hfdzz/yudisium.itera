<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Bootstrap 5 FallBack -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Custom fonts for this template-->
    <link href=<?= base_url('assets/fontawesome/css/all.min.css') ?> rel="stylesheet" type="text/css">
    <link rel="stylesheet" href=<?= base_url('assets/css/style.css') ?>>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href=<?= base_url('assets/css/sb-admin-2.min.css') ?> rel="stylesheet">

</head>

<body style="background-color: #ECD586;">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6"  style="background-color:#6f6a5a;">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img class="img-fluid" width="150px" src=<?= base_url('assets/img/logo_fti.png') ?> alt="">
                                        </div>    
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4 font-weight-bold">LOGIN PAGE</h1>
                                    </div>
                                    <form class="user" action="<?= route_to('login') ?>" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." name="email"
                                                value="<?= old('email') ?>"
                                                >
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck" name="remember">
                                                <label class="custom-control-label text-white" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="tombol-utama" type="submit">
                                                Login
                                            </button>
                                        </div>
                                        <hr>
                                    </form>
                                    <hr>
                                    <!-- if current url = login_administrator -->
                                    <div class="text-center">
                                        <a class="small text-white" href=<?= route_to('register') ?>>Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 d-none d-lg-block p-0" style="background-image: url(<?= base_url('assets/img/bg-login.png') ?>); background-size: 100%; background-repeat: no-repeat; background-position: center;">
                            <h2 class="pt-5 text-center mt-5 font-weight-bold" style="color: black;">WELCOME TO STUDENT PORTAL </h2>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src=<?= base_url('assets/jquery/jquery.min.js') ?>></script>
    <script src=<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>></script>

    <!-- Core plugin JavaScript-->
    <script src=<?= base_url('assets/jquery-easing/jquery.easing.min.js') ?>></script>

    <!-- Custom scripts for all pages-->
    <script src=<?= base_url('assets/js/sb-admin-2.min.js') ?>></script>

</body>

</html>