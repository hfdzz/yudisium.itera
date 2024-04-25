<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
        <div class="user-panel d-flex">
        <div class="image">
            <img src="<?= base_url('assets/img/default.png') ?>"
             class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <div href="#" class="d-block warna-ketiga"><?= auth()->user()->username ?></div>
        </div>
        </a>
        </li>
    </ul>
</nav>