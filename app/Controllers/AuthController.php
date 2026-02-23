<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function loginForm()
    {
        return view('auth/login');
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak terdaftar');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password Salah');
        }

        session()->set([
            'id_user'   => $user['id_user'],
            'nama'      => $user['nama'],
            'email'     => $user['email'],
            'role'      => $user['role_user'],
            'logged_in' => true
        ]);

        log_activity('Login ke sistem');

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        try {
            // Log activity sebelum destroy session
            log_activity('Logout dari sistem');
        } catch (\Exception $e) {
            // Jika log gagal, tetap lanjut logout
            // Error log tidak boleh menghalangi logout
        }
        
        // Destroy session
        session()->destroy();
        
        return redirect()->to('/');
    }

    public function index()
    {
        //
    }
}
