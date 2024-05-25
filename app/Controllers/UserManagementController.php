<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class UserManagementController extends ResourceController
{
    protected $userModel;
    protected $format;

    public function __construct()
    {
        /** @var \App\Models\UserModel $userModel */
        $this->userModel = model('UserModel');
        $this->format = 'json';
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $query = $this->userModel->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
            ->select('users.id, username, nim, program_studi, nip, auth_groups_users.group');
        
        
        if ($user_group = $this->request->getGet('group')) {
            $query->where('auth_groups_users.group', $user_group);
        }

        if ($search = $this->request->getGet('search')) {
            $query->groupStart()
                ->like('username', $search)
                ->orLike('nim', $search)
                ->orLike('program_studi', $search)
                ->orLike('nip', $search)
                ->groupEnd();
        }

        return $this->respond($query->findAll());
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        return $this->respond($this->userModel->find($id));
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getPost();

        $rules = [
            'username' => 'required',
            'group' => 'required',
            'email' => 'required|valid_email',
            'password' => 'required',
        ];

        if ($data['group'] === 'user_mahasiswa') {
            $rules['nim'] = 'required|is_unique[users.nim]|max_length[9]|numeric';
            $rules['program_studi'] = 'required';
        } else {
            $rules['nip'] = 'required|is_unique[users.nip]|max_length[18]|numeric';
        }

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = $this->validator->getValidated();
        
        // return $this->respond($data);

        $newUser = new \App\Entities\UserEntity([
            ...$data,
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if ($this->userModel->save($newUser) === false) {
            return $this->fail($this->userModel->errors());
        }


        // To get the complete user object with ID, we need to get from the database
        $newUser = $this->userModel->findById($this->userModel->getInsertID());

        // Add to group
        $newUser->addGroup($data['group']);
        
        return $this->respondCreated($data);
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $data = $this->request->getPost();

        $user_groups = $this->userModel->findById($id)->getGroups();

        $rules = [
            'id' => 'required',
            'username' => 'permit_empty',
        ];

        // check if froup in $user_groups array
        if (in_array('user_mahasiswa', $user_groups)) {
            $rules['nim'] = 'required|is_unique[users.nim,id,{id}]|max_length[9]|numeric';
            $rules['program_studi'] = 'required';
        } else if (in_array('user_fakultas', $user_groups) || in_array('user_upt_perpustakaan', $user_groups) || in_array('user_keuangan', $user_groups)) {
            $rules['nip'] = 'required|is_unique[users.nip,id,{id}]|max_length[18]|numeric';
        }

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }
        
        $data = $this->validator->getValidated();

        // return $this->respond($data);

        if ($this->userModel->update($id, $data) === false) {
            return $this->fail($this->userModel->errors());
        }

        return $this->respondUpdated($data);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        if(auth()->id() == $id) {
            return $this->fail('Tidak bisa menghapus akun yang sedang digunakan.');
        }

        // return $this->respondDeleted($id);

        if ($this->userModel->delete($id, true) === false)
        {
            return $this->fail($this->userModel->errors());
        }

        return $this->respondDeleted($id);
    }
}
