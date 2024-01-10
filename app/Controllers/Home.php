<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $user_home = [
        'superadmin' => 'admin.dashboard',
        'admin' => 'admin.dashboard',
        'user_mahasiswa' => 'mahasiswa.dashboard',
        'user_fakultas' => 'fakultas.dashboard',
        'user_upt_perpustakaan' => 'upt_perpustakaan.dashboard',
        'user_keuangan' => 'keuangan.dashboard',
    ];

    public function index(): string | \CodeIgniter\HTTP\RedirectResponse
    {
        $user = auth()->user();

        if (! $user) {
            return view('home');
        }

        // if ($user->inGroup('admin') || $user->inGroup('superadmin')) {
        //     return redirect('admin.dashboard');
        // }
        // else if ($user->inGroup('user_fakultas')) {
        //     return redirect('fakultas.dashboard');
        // }
        // else if ($user->inGroup('user_upt_perpustakaan')) {
        //     return redirect('upt_perpustakaan.dashboard');
        // }
        // else if ($user->inGroup('user_keuangan')) {
        //     return redirect('keuangan.dashboard');
        // }
        // else if ($user->inGroup('user_mahasiswa')) {
        //     return redirect('mahasiswa.dashboard');
        // }   
        // return 'Invalid user group';

        if (array_key_exists($user->getGroups()[0], $this->user_home)) {
            return redirect()->route($this->user_home[$user->getGroups()[0]]);
        } else {
            return 'Invalid user group';
        }
    }
}
