<div style="background-color: #d5d5c5; box-shadow: 0 0 2px #000000; height: 90px">
    <div class="d-flex justify-content-between py-3 px-5 h-100" style="gap:60px">
        <div class=" d-flex flex-shrink-0">
            <!-- Navigation with permission -->
            <!-- or just title (for now) -->
            <div>
                <h1>Sistem Informasi Yudisium</h1>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-end">
            <!-- User Profile -->
            <div class="d-flex align-items-center" style="gap:6px">
                <?php if(auth()->loggedIn()): ?>
                    <div class=""><?= auth()->user()->username ?></div>
                    <div>|</div>
                    <div class="">
                        <a href="<?= route_to('logout') ?>">Logout</a>
                    </div>
                <?php else: ?>
                    <div class="">
                        <a href="<?= route_to('login') ?>">Login</a>
                    </div>
                    <div>|</div>
                    <div class="">
                        <a href="<?= route_to('register') ?>">Register</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>