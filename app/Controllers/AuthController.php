<?php
namespace App\Controllers;
use App\Models\UserModel;

class AuthController extends BaseController {
    public function login() { return view('auth/login'); }
    public function register() { return view('auth/register'); }

    public function store() {
        $model = new UserModel();
        $model->save([
            'name'     => $this->request->getVar('name'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash((string)$this->request->getVar('password'), PASSWORD_DEFAULT),
        ]);
        return redirect()->to('/login')->with('success', 'Registered successfully!');
    }

    public function loginAuth() {
        $session = session();
        $model = new UserModel();
        $user = $model->where('email', $this->request->getVar('email'))->first();

        if ($user && password_verify((string)$this->request->getVar('password'), $user['password'])) {
            $session->set(['id' => $user['id'], 'name' => $user['name'], 'isLoggedIn' => true]);
            return redirect()->to('/admin');
        }
        return redirect()->back()->with('error', 'Login Failed');
    }

    public function logout() { session()->destroy(); return redirect()->to('/login'); }
}