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

    $routes->presenter('bebas-perpustakaan', ['controller' => 'SkBebasPerpustakaanController', 'websafe' => 1]);
});

$routes->group('keuangan', ['filter' => 'group:user_keuangan'], function ($routes) {
    $routes->get('/', [App\Controllers\KeuanganController::class, 'dashboard'], ['as' => 'keuangan.dashboard']);

    $routes->get('validasi-surat-keterangan', [App\Controllers\KeuanganController::class, 'validasiSuratKeterangan'], ['as' => 'keuangan.validasi_surat_keterangan']);
    $routes->post('validasi-surat-keterangan', [App\Controllers\KeuanganController::class, 'validasiSuratKeterangan']);

    // $routes->get('berkas-bebas-ukt/(:num)/(:segment)', [App\Controllers\KeuanganController::class, 'berkasBebasUkt']);

    $routes->presenter('bebas-ukt', ['controller' => 'SkBebasUktController', 'websafe' => 1]);
});

$routes->group('fakultas', ['filter' => 'group:user_fakultas'], function (RouteCollection $routes) {
    $routes->get('/', [App\Controllers\FakultasController::class, 'dashboard'], ['as' => 'fakultas.dashboard']);

    $routes->get('validasi-yudisium', [App\Controllers\FakultasController::class, 'validasiYudisium'], ['as' => 'fakultas.validasi_yudisium']);
    $routes->post('validasi-yudisium', [App\Controllers\FakultasController::class, 'validasiYudisium']);

    $routes->get('periode-yudisium', [App\Controllers\FakultasController::class, 'periodeYudisium'], ['as' => 'fakultas.periode_yudisium']);
    $routes->post('periode-yudisium', [App\Controllers\FakultasController::class, 'periodeYudisium']);

    $routes->presenter('yudisium-pendaftaran', ['controller' => 'YudisiumPendaftaranController', 'websafe' => 1]);
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

/** 
 * Test route
 * 
 * TODO: Remove this route
 */

$routes->get('test', function (){
    $silabor_service = new \App\Services\SILABORService();
    $data = $silabor_service->getAllBebasLab();
    dd($data);
});

// with parameter
// $routes->get('test/id/(:num)', function ($id){
//     $silabor_service = new \App\Services\SILABORService();
//     $data = $silabor_service->getBebasLabById($id);
//     dd($data);
//     return $data ? redirect()->to($data->surat) : 'Surat tidak ditemukan';
// });

$routes->get('test/nim/(:num)', function ($nim){
    $silabor_service = new \App\Services\SILABORService();
    $data = $silabor_service->getBebasLabByNim($nim, null);
    // sort by 'id_bebas_lab' ASC
    usort($data, function($a, $b) {
        return $a->id_bebaslab <=> $b->id_bebaslab;
    });
    // return json_encode($data);
    dd($data);
    return $data ? redirect()->to($data[0]->surat) : 'Surat tidak ditemukan';
});

use Dompdf\Dompdf;
$routes->get('testTemplate/(:any)', function ($template){

    $dompdf = new Dompdf();

    // kop from public folder
    $kop_surat = 'kop.png';

    $options = new \Dompdf\Options();    
    $options->set( 'chroot', $kop_surat );
    $dompdf = new Dompdf( $options );

    $data = [
        'kop_surat' => 'kop.png',
        'nama' => 'Kuncup Hapeed',
        'nim' => '120140234',
        'program_studi' => 'Teknik Informatika',
        'tanggal' => '12 Agustus 2021',
        'nomor_surat' => '1234/UN40.14/SP/2021'

    ];

    $fContent = view('template_surat/bebas_perpustakaan.php', $data);

    // return $fContent;

    $dompdf->loadHtml($fContent);
    
    $dompdf->setPaper('A4', 'portrait');

    

    ob_end_clean();

    $dompdf->render();

    $dompdf->stream('test.pdf', ['Attachment' => 0]);   
});