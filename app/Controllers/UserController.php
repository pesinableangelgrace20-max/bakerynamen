<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends AdminBaseController
{
    protected UserModel $uModel;

    public function __construct()
    {
        $this->uModel = new UserModel();
    }

    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        return view('admin/pages/users', [
            'page'  => 'users',
            'title' => 'Users',
            'users' => $this->uModel->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $rules = [
            'name'     => 'required|min_length[2]|max_length[100]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[Staff,Admin]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $this->uModel->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ]);

        return redirect()->to('/admin/users')->with('success', 'User added!');
    }

    public function edit($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $user = $this->uModel->find($id);
        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        return view('admin/pages/edit_user', [
            'page'  => 'users',
            'title' => 'Edit User',
            'user'  => $user,
        ]);
    }

    public function update($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $user = $this->uModel->find($id);
        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        $rules = [
            'name'  => 'required|min_length[2]|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role'  => 'required|in_list[Staff,Admin]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'role'  => $this->request->getPost('role'),
        ];

        $pwd = $this->request->getPost('password');
        if ($pwd !== null && $pwd !== '') {
            $data['password'] = password_hash((string) $pwd, PASSWORD_DEFAULT);
        }

        $this->uModel->update($id, $data);

        return redirect()->to('/admin/users')->with('success', 'User updated!');
    }

    public function delete($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        if ((int) $id === (int) session()->get('id')) {
            return redirect()->to('/admin/users')->with('error', 'You cannot delete your own account.');
        }

        $this->uModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User deleted!');
    }
}
