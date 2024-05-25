<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class AdminController extends BaseController
{
    public function dashboard()
    {
        // Dashboard for admin
        $db = db_connect();

        $result = $db->table('users')->select('group, COUNT(*) as count')->groupBy('group')
        ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')->get()->getResultArray();

        $data = [
            'count_user_mahasiswa' => $result[0]['count'] ?? 0,
            'count_user_fakultas' => $result[1]['count'] ?? 0,
            'count_user_upt_perpustakaan' => $result[2]['count'] ?? 0,
            'count_user_keuangan' => $result[3]['count'] ?? 0,
        ];

        return view('admin/index', $data);
    }
}
