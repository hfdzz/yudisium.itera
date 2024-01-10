<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

service('auth')->routes($routes);

$routes->group('admin', ['filter' => 'group:admin'], function ($routes) {
    $routes->get('/', [App\Controllers\AdminController::class, 'dashboard'], ['as' => 'admin.dashboard']);
});

$routes->group('upt_perpustakaan', ['filter' => 'group:user_upt_perpustakaan'], function ($routes) {
    $routes->get('/', [App\Controllers\UptPerpustakaanController::class, 'dashboard'], ['as' => 'upt_perpustakaan.dashboard']);
});

$routes->group('keuangan', ['filter' => 'group:user_keuangan'], function ($routes) {
    $routes->get('/', [App\Controllers\KeuanganController::class, 'dashboard'], ['as' => 'keuangan.dashboard']);
});

$routes->group('fakultas', ['filter' => 'group:user_fakultas'], function ($routes) {
    $routes->get('/', [App\Controllers\FakultasController::class, 'dashboard'], ['as' => 'fakultas.dashboard']);
});

$routes->group('mahasiswa', ['filter' => 'group:user_mahasiswa'], function ($routes) {
    $routes->get('/', [App\Controllers\MahasiswaController::class, 'dashboard'], ['as' => 'mahasiswa.dashboard']);

    $routes->get('daftar-yudisium', [App\Controllers\MahasiswaController::class, 'daftarYudisium'], ['as' => 'mahasiswa.daftar_yudisium']);
    $routes->post('daftar-yudisium', [App\Controllers\MahasiswaController::class, 'daftarYudisium']);

    $routes->get('sk-bebas-perpustakaan', [App\Controllers\MahasiswaController::class, 'skBebasPerpustakaan'], ['as' => 'mahasiswa.sk_bebas_perpustakaan']);
    $routes->post('sk-bebas-perpustakaan', [App\Controllers\MahasiswaController::class, 'skBebasPerpustakaan']);

    $routes->get('sk-bebas-ukt', [App\Controllers\MahasiswaController::class, 'skBebasUkt'], ['as' => 'mahasiswa.sk_bebas_ukt']);
    $routes->post('sk-bebas-ukt', [App\Controllers\MahasiswaController::class, 'skBebasUkt']);

    $routes->get('status-yudisium', [App\Controllers\MahasiswaController::class, 'statusYudisium'], ['as' => 'mahasiswa.status_yudisium']);
});