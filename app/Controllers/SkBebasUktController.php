<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * @var \App\Models\SuratKeteranganModel $model
 */
class SkBebasUktController extends BaseController
{
    public function index()
    {
        $model = model('SuratKeteranganModel');

        // return view
    }

    public function show($id = null)
    {
        // return route 404
        return PageNotFoundException::forPageNotFound();
    }

    public function new()
    {
        // return view
    }

    public function create()
    {
        $model = model('SuratKeteranganModel');

        $model->save($this->request->getPost());

        // return redirect
    }

    public function edit($id = null)
    {
        $model = model('SuratKeteranganModel');

        // return view with data
    }

    public function update($id = null)
    {
        
        $model = model('SuratKeteranganModel');

        $model->save($this->request->getPost());

        // return redirect
    }

    public function delete($id = null)
    {
        $model = model('SuratKeteranganModel');

        $model->delete($id);

        // return redirect
    }
}
