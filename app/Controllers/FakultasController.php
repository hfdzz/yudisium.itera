<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class FakultasController extends BaseController
{
    public function dashboard()
    {
        // Dashboard for fakultas
        return "Fakultas Dashboard";
    }
}
