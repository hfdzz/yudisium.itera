<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class YudisiumPendaftaranController extends BaseController
{
    protected $helpers = ['form', 'url'];

    public function index()
    {
        /**
         * @var \App\Models\YudisiumPendaftaranModel $model
         */
        $model = model('YudisiumPendaftaranModel');

        $pager = \Config\Services::pager();

        return view('fakultas/yudisium_pendaftaran/index', [
            'yudisium_pendaftaran' => $model->paginate(5),
            'pager' => $model->pager,
        ]);
    }

    public function show($id = null)
    {
        // return route 404
        return view('errors/html/error_404', ['message' => 'Page not found']);
    }

    public function new()
    {
        return view('fakultas/yudisium_pendaftaran/new');
    }

    public function create()
    {
        $model = model('YudisiumPendaftaranModel');

        $model->save($this->request->getPost());

        return redirect()->to('/fakultas/yudisium-pendaftaran');
    }

    public function edit($id = null)
    {
        $model = model('YudisiumPendaftaranModel');

        return view('fakultas/yudisium_pendaftaran/edit', [
            'yudisium_pendaftaran' => $model->find($id),
        ]);
    }

    public function update($id = null)
    {
        
        $model = model('YudisiumPendaftaranModel');

        $model->save($this->request->getPost());

        return redirect()->to('/fakultas/yudisium-pendaftaran');
    }

    public function delete($id = null)
    {
        $model = model('YudisiumPendaftaranModel');

        // $model->delete($id);

        if ($model->errors()) {
            dd ($model->errors());
        }

        return redirect()->to('/fakultas/yudisium-pendaftaran');
    }
}
