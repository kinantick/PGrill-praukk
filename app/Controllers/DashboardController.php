<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AlatModel;

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

        return view('dashboard/admin', [
            'totalAlat' => $alatModel->countAllResults()
        ]);
    }

    private function petugasDashboard()
    {
        $alatModel = new AlatModel();

        return view('dashboard/petugas', [
            'totalAlat' => $alatModel->countAllResults()
        ]);
    }

    private function peminjamDashboard()
    {
        $alatModel = new AlatModel();

        return view('dashboard/peminjam', [
            'totalAlat' => $alatModel->countAllResults()
        ]);
    }
}