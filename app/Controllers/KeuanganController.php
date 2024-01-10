<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class KeuanganController extends BaseController
{
    public function dashboard()
    {
        // Dashboard for keuangan
        return "Keuangan Dashboard";
    }
}
