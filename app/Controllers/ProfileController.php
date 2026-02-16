<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        $user = $userModel->find(session()->get('id_user'));

        return view('profile/index', ['user' => $user]);
    }

    public function edit()
    {
        $userModel = new UserModel();

        $user = $userModel->find(session()->get('id_user'));

        return view('/profile/edit', ['user' => $user]);
    }

    public function update()
    {
        $userModel = new UserModel();
        $id = session()->get('id_user');

        // Data yang akan diupdate
        $updateData = [
            'nama'   => $this->request->getPost('nama'),
            'no_hp'  => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat')
        ];

        // Cek apakah password diisi
        $password_baru = $this->request->getPost('password_baru');
        $password_lama = $this->request->getPost('password_lama');
        $password_konfirmasi = $this->request->getPost('password_konfirmasi');

        // Jika password baru diisi, lakukan validasi
        if (!empty($password_baru)) {
            // Validasi password lama
            $user = $userModel->find($id);
            
            if (!password_verify($password_lama, $user['password'])) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai!')->withInput();
            }

            // Validasi password baru dan konfirmasi
            if ($password_baru !== $password_konfirmasi) {
                return redirect()->back()->with('error', 'Password baru dan konfirmasi tidak sama!')->withInput();
            }

            // Validasi panjang password
            if (strlen($password_baru) < 6) {
                return redirect()->back()->with('error', 'Password minimal 6 karakter!')->withInput();
            }

            // Tambahkan password ke data update
            $updateData['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
            
            log_activity('Mengubah password profile');
        }

        $userModel->update($id, $updateData);

        // Update session nama jika nama berubah
        session()->set('nama', $updateData['nama']);

        log_activity('Mengupdate profile');

        return redirect()->to('/profile')->with('success', 'Profile berhasil diperbarui');
    }
}
