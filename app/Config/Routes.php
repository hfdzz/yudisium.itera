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

    $routes->get('validasi-surat-keterangan', [App\Controllers\UptPerpustakaanController::class, 'validasiSuratKeterangan'], ['as' => 'upt_perpustakaan.validasi_surat_keterangan']);
    $routes->post('validasi-surat-keterangan', [App\Controllers\UptPerpustakaanController::class, 'validasiSuratKeterangan']);

    $routes->presenter('bebas-perpustakaan', ['controller' => 'SkBebasPerpustakaanController', 'websafe' => 1, 'as' => 'upt_perpustakaan.bebas_perpustakaan']);
});

$routes->group('keuangan', ['filter' => 'group:user_keuangan'], function ($routes) {
    $routes->get('/', [App\Controllers\KeuanganController::class, 'dashboard'], ['as' => 'keuangan.dashboard']);

    $routes->get('validasi-surat-keterangan', [App\Controllers\KeuanganController::class, 'validasiSuratKeterangan'], ['as' => 'keuangan.validasi_surat_keterangan']);
    $routes->post('validasi-surat-keterangan', [App\Controllers\KeuanganController::class, 'validasiSuratKeterangan']);

    // $routes->get('berkas-bebas-ukt/(:num)/(:segment)', [App\Controllers\KeuanganController::class, 'berkasBebasUkt']);

    $routes->presenter('bebas-ukt', ['controller' => 'SkBebasUktController', 'websafe' => 1, 'as' => 'keuangan.bebas_ukt']);
});

$routes->group('fakultas', ['filter' => 'group:user_fakultas'], function (RouteCollection $routes) {
    $routes->get('/', [App\Controllers\FakultasController::class, 'dashboard'], ['as' => 'fakultas.dashboard']);

    $routes->get('validasi-yudisium', [App\Controllers\FakultasController::class, 'validasiYudisium'], ['as' => 'fakultas.validasi_yudisium']);
    $routes->post('validasi-yudisium', [App\Controllers\FakultasController::class, 'validasiYudisium']);

    $routes->get('periode-yudisium', [App\Controllers\FakultasController::class, 'periodeYudisium'], ['as' => 'fakultas.periode_yudisium']);
    $routes->post('periode-yudisium', [App\Controllers\FakultasController::class, 'periodeYudisium']);

    $routes->get('periode-yudisium/new', [App\Controllers\FakultasController::class, 'newPeriodeYudisium'], ['as' => 'fakultas.new_periode_yudisium']);

    $routes->presenter('yudisium-pendaftaran', ['controller' => 'YudisiumPendaftaranController', 'websafe' => 1, 'as' => 'fakultas.yudisium_pendaftaran']);
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

$routes->get('berkas-bebas-ukt/(:num)/(:segment)', [App\Controllers\FileResourceController::class, 'berkasBebasUkt'], ['filter' => 'group:user_keuangan,user_mahasiswa', 'as' => 'berkas_bebas_ukt']);

$routes->get('file-surat-keterangan/(:num)', [App\Controllers\FileResourceController::class, 'fileSuratKeterangan'], ['as' => 'file_surat_keterangan']);

$routes->get('berkas-pendaftaran-yudisium/(:num)/(:segment)', [App\Controllers\FileResourceController::class, 'berkasPendaftaranYudisium'], ['filter' => 'group:user_fakultas,user_mahasiswa', 'as' => 'berkas_pendaftaran_yudisium']);

$routes->get('file-tanda-terima-yudisium/(:num)', [App\Controllers\FileResourceController::class, 'fileTandaTerimaYudisium'], ['as' => 'file_tanda_terima_yudisium']);

$routes->get('test/terminal', function () {
    return view('_test/terminal');
}, ['as' => 'test.terminal']);

$routes->post('test/terminal', function () {
    $data = service('request')->getPost();

    if (!isset($data['command'])) {
        return response()->setJSON([
            'output' => 'Server: Command not found.'
        ]);
    }
    
    try {
        $res = command($data['command']);
    }
    catch (\Exception $e) {
        $res = $e->getMessage();
    }

    return response()->setJSON([
        'output' => $res
    ]);
});