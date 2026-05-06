<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function store()
    {
        $rules = [
            'name'     => 'required|min_length[2]|max_length[100]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $model = new UserModel();
        $model->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/login')->with('success', 'Registered successfully!');
    }

    public function loginAuth()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $model = new UserModel();
        $user  = $model->where('email', $this->request->getPost('email'))->first();

        if ($user && password_verify((string) $this->request->getPost('password'), (string) $user['password'])) {
            session()->set(['id' => $user['id'], 'name' => $user['name'], 'isLoggedIn' => true]);

            return redirect()->to('/admin');
        }

        return redirect()->back()->withInput()->with('error', 'Login Failed');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}
