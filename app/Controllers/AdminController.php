<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    public function dashboard()
    {
        // Dashboard for admin
        return "Admin Dashboard";
    }
}
