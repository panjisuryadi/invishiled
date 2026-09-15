<?php
namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->findAll();
        
        $totalUser = count($users);

        $data = [
            'title'        => 'Data User',
            'users'     => $users,
            'total_user' => $totalUser,
        ];

        return view('user/index', $data);
    }

    public function store()
    {
        $data = [
            'name'         => $this->request->getPost('name'),
        ];

        $this->userModel->save($data);

        return redirect()->to(base_url('users'))->with('success', 'User berhasil ditambahkan!');
    }

    public function update($id)
    {
        $data = [
            'name'         => $this->request->getPost('name'),
        ];

        $this->userModel->update($id, $data);

        return redirect()->to(base_url('users'))->with('success', 'User berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);

        return redirect()->to(base_url('users'))->with('success', 'User berhasil dihapus!');
    }
}