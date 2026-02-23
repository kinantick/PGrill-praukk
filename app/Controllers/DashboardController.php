<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AlatModel;
use App\Models\UserModel;
use App\Models\PeminjamanModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $role = session()->get('role');

        switch ($role) {
            case 'Admin':
                return $this->adminDashboard();

            case 'Petugas':
                return $this->petugasDashboard();

            case 'Peminjam':
                return $this->peminjamDashboard();

            default:
                return redirect()->to('/');
        }
    }

    private function adminDashboard()
    {
        $alatModel = new AlatModel();
        $userModel = new UserModel();
        $peminjamanModel = new PeminjamanModel();

        $data = [
            'totalAlat' => $alatModel->countAllResults(),
            'totalUser' => $userModel->countAllResults(),
            'totalPeminjaman' => $peminjamanModel->countAllResults(),
            'peminjamanMenunggu' => $peminjamanModel->where('status', 'menunggu')->countAllResults(),
            'peminjamanDisetujui' => $peminjamanModel->where('status', 'Disetujui')->countAllResults(),
            'peminjamanDikembalikan' => $peminjamanModel->where('status', 'Dikembalikan')->countAllResults()
        ];

        return view('dashboard/admin', $data);
    }

    private function petugasDashboard()
    {
        $alatModel = new AlatModel();
        $peminjamanModel = new PeminjamanModel();

        $data = [
            'totalAlat' => $alatModel->countAllResults(),
            'alatTersedia' => $alatModel->where('status', 'tersedia')->countAllResults(),
            'peminjamanMenunggu' => $peminjamanModel->where('status', 'menunggu')->countAllResults(),
            'peminjamanDisetujui' => $peminjamanModel->where('status', 'Disetujui')->countAllResults(),
            'peminjamanDikembalikan' => $peminjamanModel->where('status', 'Dikembalikan')->countAllResults()
        ];

        return view('dashboard/petugas', $data);
    }

    private function peminjamDashboard()
    {
        $alatModel = new AlatModel();
        $peminjamanModel = new PeminjamanModel();
        $id_user = session()->get('id_user');

        $data = [
            'alatTersedia' => $alatModel->where('status', 'tersedia')->where('stok >', 0)->countAllResults(),
            'peminjamanSaya' => $peminjamanModel->where('id_user', $id_user)->countAllResults(),
            'peminjamanMenunggu' => $peminjamanModel->where('id_user', $id_user)->where('status', 'menunggu')->countAllResults(),
            'peminjamanDisetujui' => $peminjamanModel->where('id_user', $id_user)->where('status', 'Disetujui')->countAllResults(),
            'peminjamanSelesai' => $peminjamanModel->where('id_user', $id_user)->where('status', 'Selesai')->countAllResults()
        ];

        return view('dashboard/peminjam', $data);
    }
}