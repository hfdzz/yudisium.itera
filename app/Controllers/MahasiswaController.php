<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MahasiswaController extends BaseController
{
    protected $helpers = ['form'];

    public function dashboard()
    {
        // Dashboard for mahasiswa
        return view('dashboard');
    }

    public function daftarYudisium()
    {
        // Daftar yudisium for mahasiswa
        if (! $this->request->is('post')) {
            return view('mahasiswa/daftar_yudisium');
        }


        
    }

    public function skBebasPerpustakaan()
    {
        // SK bebas perpustakaan for mahasiswa
        return view('mahasiswa/sk_bebas_perpustakaan');
    }

    public function skBebasUkt()
    {
        // SK bebas ukt for mahasiswa
        return view('mahasiswa/sk_bebas_ukt');
    }

    public function statusYudisium()
    {
        // Status yudisium for mahasiswa
        return view('mahasiswa/status_yudisium');
    }
}
