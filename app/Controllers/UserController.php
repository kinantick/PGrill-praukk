<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function index()
    {
        // Hanya Admin yang bisa akses
        if (session()->get('role') !== 'Admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak! Hanya Admin yang dapat mengelola data user.');
        }

        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();

        return view('user/index', $data);
    }

    public function create()
    {
        // Hanya Admin yang bisa akses
        if (session()->get('role') !== 'Admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        return view('user/create');
    }

    public function store()
    {
        // Hanya Admin yang bisa akses
        if (session()->get('role') !== 'Admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $userModel = new UserModel();

        $id = $userModel->insert([
            'nama'      => $this->request->getPost('nama'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role_user' => $this->request->getPost('role_user'),
            'no_hp'     => $this->request->getPost('no_hp'),
            'alamat'    => $this->request->getPost('alamat')
        ]);

        log_activity('Menambahkan user baru: ' . $this->request->getPost('nama') . ' (' . $this->request->getPost('role_user') . ')', $id);

        return redirect()->to('/user')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Hanya Admin yang bisa akses
        if (session()->get('role') !== 'Admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $userModel = new UserModel();
        $data['user'] = $userModel->find($id);

        return view('user/edit', $data);
    }

    public function update($id)
    {
        // Hanya Admin yang bisa akses
        if (session()->get('role') !== 'Admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $userModel = new UserModel();

        $user = $userModel->find($id);

        $userModel->update($id, [
            'role_user' => $this->request->getPost('role_user')
        ]);

        log_activity('Mengupdate role user: ' . $user['nama'] . ' menjadi ' . $this->request->getPost('role_user'), $id);

        return redirect()->to('/user')->with('success', 'User berhasil diupdate');
    }

    public function delete($id)
    {
        // Hanya Admin yang bisa akses
        if (session()->get('role') !== 'Admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }

        $userModel = new UserModel();
        $user = $userModel->find($id);

        $userModel->delete($id);

        log_activity('Menghapus user: ' . $user['nama'] . ' (' . $user['email'] . ')', $id);

        return redirect()->to('/user')->with('success', 'User berhasil dihapus');
    }
}
