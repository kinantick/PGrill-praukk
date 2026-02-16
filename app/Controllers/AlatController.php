<?php

namespace App\Controllers;

use App\Models\AlatModel;
use App\Models\UserModel;
use App\Models\CategoryModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AlatController extends BaseController
{
    public function index()
    {
        $alatModel = new AlatModel();
        $categoryModel = new CategoryModel();

        $keyword = $this->request->getGet('keyword');
        $category = $this->request->getGet('category');

        $alat = $alatModel->getAlatFiltered($keyword, $category);

        $data = [
            'title'     => 'Alat',
            'alat'      => $alatModel->getAlatWithCategory(),
            'pager'     => $alatModel->pager,
            'category'  => $categoryModel->findAll(),
            'keyword'   => '',
            'catFilter' => $category
        ];

        return view('/alat/index', $data);
    }

    public function create()
    {
        $categoryModel = new CategoryModel();
        $data['category'] = $categoryModel->findAll();

        return view('/alat/create', $data);
    }

    public function store()
    {
        $alatModel = new AlatModel();

        $id = $alatModel->insert([
            'nama_alat'   => $this->request->getPost('nama_alat'),
            'id_category' => $this->request->getPost('id_category'),
            'harga_alat'  => $this->request->getPost('harga_alat'),
            'kondisi'     => $this->request->getPost('kondisi'),
            'stok'        => $this->request->getPost('stok'),
            'status'      => $this->request->getPost('status')
        ]);

        log_activity('Menambahkan alat baru: ' . $this->request->getPost('nama_alat'), $id);

        return redirect()->to('/alat')->with('success', 'Alat Baru Berhasil Ditambahkan!');
    }

    public function edit($id)
    {
        $alatModel = new AlatModel();
        $categoryModel = new CategoryModel();

        return view('/alat/edit', [
            'alat'     => $alatModel->find($id),
            'category' => $categoryModel->findAll()
        ]);
    }

    public function update($id)
    {
        $alatModel = new AlatModel();

        $alat = $alatModel->find($id);

        $alatModel->update($id, [
            'nama_alat'   => $this->request->getPost('nama_alat'),
            'id_category' => $this->request->getPost('id_category'),
            'harga_alat'  => $this->request->getPost('harga_alat'),
            'kondisi'     => $this->request->getPost('kondisi'),
            'stok'        => $this->request->getPost('stok'),
            'status'      => $this->request->getPost('status')
        ]);

        log_activity('Mengupdate data alat: ' . $alat['nama_alat'], $id);

        return redirect()->to('/alat')->with('success', 'Data Berhasil Update');
    }

    public function delete($id)
    {
        $alatModel = new AlatModel();
        $alat = $alatModel->find($id);
        
        $alatModel->delete($id);

        log_activity('Memindahkan alat ke trash: ' . $alat['nama_alat'], $id);

        return redirect()->to('/alat')->with('success', 'Alat berhasil dipindahkan ke trash');
    }

    public function trash()
    {
        $alatModel = new AlatModel();
        $categoryModel = new CategoryModel();

        $data = [
            'title'    => 'Trash Alat',
            'alat'     => $alatModel->onlyDeleted()->findAll(),
            'category' => $categoryModel->findAll()
        ];

        return view('/alat/trash', $data);
    }

    public function restore($id)
    {
        $alatModel = new AlatModel();
        
        $alat = $alatModel->onlyDeleted()->find($id);
        
        if (!$alat) {
            return redirect()->to('/alat/trash')->with('error', 'Data tidak ditemukan');
        }

        // Restore (set deleted_at to null)
        $alatModel->update($id, ['deleted_at' => null]);

        log_activity('Mengembalikan alat dari trash: ' . $alat['nama_alat'], $id);

        return redirect()->to('/alat/trash')->with('success', 'Alat berhasil dikembalikan');
    }

    public function permanentDelete($id)
    {
        $alatModel = new AlatModel();
        
        $alat = $alatModel->onlyDeleted()->find($id);
        
        if (!$alat) {
            return redirect()->to('/alat/trash')->with('error', 'Data tidak ditemukan');
        }

        // Permanent delete
        $alatModel->delete($id, true);

        log_activity('Menghapus permanen alat: ' . $alat['nama_alat'], $id);

        return redirect()->to('/alat/trash')->with('success', 'Alat berhasil dihapus permanen');
    }

    public function emptyTrash()
    {
        $alatModel = new AlatModel();
        
        $trashedAlat = $alatModel->onlyDeleted()->findAll();
        $count = count($trashedAlat);

        foreach ($trashedAlat as $alat) {
            $alatModel->delete($alat['id_alat'], true);
        }

        log_activity('Mengosongkan trash alat (' . $count . ' item)');

        return redirect()->to('/alat/trash')->with('success', $count . ' alat berhasil dihapus permanen');
    }

    public function tersedia()
    {
        $alatModel = new AlatModel();
        return view('alat/tersedia', [
            'alat' => $alatModel->where('status', 'tersedia')->findAll()
        ]);
    }
}
