<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\AlatModel;
use CodeIgniter\HTTP\ResponseInterface;

class PeminjamanController extends BaseController
{
    public function index()
    {
        $peminjamanModel = new PeminjamanModel();
        $role = session()->get('role');
        $id_user = session()->get('id_user');

        $builder = $peminjamanModel
            ->select('peminjaman.*, alat.nama_alat, user.email, user.nama')
            ->join('alat', 'alat.id_alat = peminjaman.id_alat')
            ->join('user', 'user.id_user = peminjaman.id_user')
            ->orderBy('id_peminjaman', 'DESC');

        if ($role === 'Peminjam') {
            $builder->where('peminjaman.id_user', $id_user);
        }

        $data['peminjaman'] = $builder->findAll();

        return view('peminjaman/index', $data);
    }

    public function create()
    {
        $alatModel = new AlatModel();

        $data['alat'] = $alatModel
            ->where('status', 'tersedia')
            ->where('stok >', 0)
            ->findAll();

        return view('peminjaman/create', $data);
    }

    public function store()
    {
        $peminjamanModel = new PeminjamanModel();
        $alatModel = new AlatModel();

        $id_alat = $this->request->getPost('id_alat');
        $jumlah = (int) $this->request->getPost('jumlah');
        $durasi_pinjam = (int) $this->request->getPost('durasi_pinjam');
        $tanggal_pinjam = $this->request->getPost('tanggal_pinjam');
        $id_user = session()->get('id_user');

        $alat = $alatModel->find($id_alat);

        if ($jumlah > $alat['stok']) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi');
        }

        // Hitung tanggal jatuh tempo
        $tanggal_jatuh_tempo = date('Y-m-d', strtotime($tanggal_pinjam . ' + ' . $durasi_pinjam . ' days'));

        $id = $peminjamanModel->insert([
            'id_user'             => $id_user,
            'id_alat'             => $id_alat,
            'create_by'           => session('id_user'),
            'jumlah'              => $jumlah,
            'durasi_pinjam'       => $durasi_pinjam,
            'tanggal_pinjam'      => $tanggal_pinjam,
            'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
            'status'              => 'menunggu',
            'denda'               => 0
        ]);

        log_activity('Mengajukan peminjaman alat: ' . $alat['nama_alat'] . ' (Jumlah: ' . $jumlah . ', Durasi: ' . $durasi_pinjam . ' hari)', $id);

        return redirect()->to('/peminjaman')->with('success', 'Pengajuan berhasil dikirim');
    }

    public function edit($id)
    {
        if (session()->get('role') !== 'Petugas') {
            return redirect()->to('/dashboard');
        }

        $peminjamanModel = new PeminjamanModel();
        
        $data['peminjaman'] = $peminjamanModel
            ->select('peminjaman.*, alat.nama_alat, user.nama, user.email')
            ->join('alat', 'alat.id_alat = peminjaman.id_alat')
            ->join('user', 'user.id_user = peminjaman.id_user')
            ->where('peminjaman.id_peminjaman', $id)
            ->first();

        return view('/peminjaman/edit', $data);
    }


    public function update($id)
    {
        if (session()->get('role') !== 'Petugas') {
            return redirect()->to('/dashboard');
        }

        $db = \Config\Database::connect();
        $peminjamanModel = new PeminjamanModel();
        $alatModel = new AlatModel();

        $p = $peminjamanModel->find($id);
        $statusBaru = $this->request->getPost('status');
        $keterangan_ditolak = $this->request->getPost('keterangan_ditolak');

        // Validasi keterangan jika ditolak
        if ($statusBaru === 'Ditolak' && empty($keterangan_ditolak)) {
            return redirect()->back()->with('error', 'Keterangan penolakan wajib diisi!');
        }

        if ($statusBaru === 'Disetujui' && $p['status'] !== 'Disetujui') {
            $alat = $alatModel->find($p['id_alat']);

            if ($alat['stok'] < $p['jumlah']) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi');
            }

            $db->transStart();

            $alatModel->update($alat['id_alat'], [
                'stok' => $alat['stok'] - $p['jumlah']
            ]);

            $peminjamanModel->update($id, [
                'status' => 'Disetujui',
                'keterangan_ditolak' => null
            ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Gagal menyetujui peminjaman');
            }

            log_activity('Menyetujui peminjaman ID: ' . $id . ' - Alat: ' . $alat['nama_alat'], $id);

            return redirect()->to('/peminjaman')->with('success', 'Peminjaman disetujui');
        }

        // Update untuk status ditolak atau lainnya
        $updateData = ['status' => $statusBaru];
        
        if ($statusBaru === 'Ditolak') {
            $updateData['keterangan_ditolak'] = $keterangan_ditolak;
            log_activity('Menolak peminjaman ID: ' . $id . ' - Alasan: ' . $keterangan_ditolak, $id);
        } else {
            $updateData['keterangan_ditolak'] = null;
            log_activity('Mengubah status peminjaman ID: ' . $id . ' menjadi ' . $statusBaru, $id);
        }

        $peminjamanModel->update($id, $updateData);

        return redirect()->to('/peminjaman')->with('success', 'Status peminjaman berhasil diubah');
    }


    public function kembalikan($id)
    {
        if (session()->get('role') !== 'Peminjam') {
            return redirect()->to('/dashboard');
        }

        $peminjamanModel = new PeminjamanModel();
        $alatModel = new AlatModel();
        
        $p = $peminjamanModel->find($id);

        if ($p['status'] !== 'Disetujui') {
            return redirect()->back();
        }

        $alat = $alatModel->find($p['id_alat']);

        $peminjamanModel->update($id, [
            'status'          => 'Dikembalikan',
            'tanggal_kembali' => date('Y-m-d')
        ]);

        log_activity('Mengajukan pengembalian alat: ' . $alat['nama_alat'] . ' (ID Peminjaman: ' . $id . ')', $id);

        return redirect()->to('peminjaman')->with('success', 'Pengembalian berhasil diajukan');
    }

    public function cekPengembalian($id)
    {
        if (session()->get('role') !== 'Petugas') {
            return redirect()->to('/dashboard');
        }

        $peminjamanModel = new PeminjamanModel();

        $data['peminjaman'] = $peminjamanModel
            ->select('peminjaman.*, alat.nama_alat, user.nama')
            ->join('alat', 'alat.id_alat = peminjaman.id_alat')
            ->join('user', 'user.id_user = peminjaman.id_user')
            ->where('peminjaman.id_peminjaman', $id)
            ->first();

        if (!$data['peminjaman'] || $data['peminjaman']['status'] !== 'Dikembalikan') {
            return redirect()->to('/peminjaman');
        }

        return view('peminjaman/kembalikan', $data);
    }


    public function selesai($id)
    {
        if (session()->get('role') !== 'Petugas') {
            return redirect()->back();
        }

        $peminjamanModel = new PeminjamanModel();
        $alatModel = new AlatModel();

        $p = $peminjamanModel->find($id);

        if ($p['status'] !== 'Dikembalikan') {
            return redirect()->back();
        }

        $alat = $alatModel->find($p['id_alat']);

        // Hitung denda jika terlambat
        $denda = 0;
        $tanggal_kembali = $p['tanggal_kembali'];
        $tanggal_jatuh_tempo = $p['tanggal_jatuh_tempo'];

        if ($tanggal_kembali && $tanggal_jatuh_tempo) {
            $date_kembali = new \DateTime($tanggal_kembali);
            $date_jatuh_tempo = new \DateTime($tanggal_jatuh_tempo);

            if ($date_kembali > $date_jatuh_tempo) {
                $interval = $date_jatuh_tempo->diff($date_kembali);
                $hari_terlambat = $interval->days;
                $denda = $hari_terlambat * 10000; // Rp 10.000 per hari
            }
        }

        $alatModel->update($alat['id_alat'], [
            'stok'   => $alat['stok'] + $p['jumlah'],
            'status' => 'tersedia'
        ]);

        $peminjamanModel->update($id, [
            'status' => 'Selesai',
            'denda'  => $denda
        ]);

        $message = 'Peminjaman selesai';
        if ($denda > 0) {
            $message .= ' dengan denda Rp ' . number_format($denda, 0, ',', '.');
        }

        log_activity('Menyelesaikan peminjaman ID: ' . $id . ' - Alat: ' . $alat['nama_alat'] . ' dikembalikan' . ($denda > 0 ? ' (Denda: Rp ' . number_format($denda, 0, ',', '.') . ')' : ''), $id);

        return redirect()->to('/peminjaman')->with('success', $message);
    }

    public function cetakLaporan($id)
    {
        if (session()->get('role') !== 'Petugas') {
            return redirect()->to('/dashboard');
        }

        $peminjamanModel = new PeminjamanModel();

        $data['peminjaman'] = $peminjamanModel
            ->select('peminjaman.*, alat.nama_alat, category.nama_category, user.nama, user.email')
            ->join('alat', 'alat.id_alat = peminjaman.id_alat')
            ->join('category', 'category.id_category = alat.id_category', 'left')
            ->join('user', 'user.id_user = peminjaman.id_user')
            ->where('peminjaman.id_peminjaman', $id)
            ->first();

        if (!$data['peminjaman'] || $data['peminjaman']['status'] !== 'Dikembalikan') {
            return redirect()->to('/peminjaman');
        }

        // Hitung denda
        $denda = 0;
        $hari_terlambat = 0;
        $tanggal_kembali = $data['peminjaman']['tanggal_kembali'];
        $tanggal_jatuh_tempo = $data['peminjaman']['tanggal_jatuh_tempo'];

        if ($tanggal_kembali && $tanggal_jatuh_tempo) {
            $date_kembali = new \DateTime($tanggal_kembali);
            $date_jatuh_tempo = new \DateTime($tanggal_jatuh_tempo);

            if ($date_kembali > $date_jatuh_tempo) {
                $interval = $date_jatuh_tempo->diff($date_kembali);
                $hari_terlambat = $interval->days;
                $denda = $hari_terlambat * 10000;
            }
        }

        $data['denda'] = $denda;
        $data['hari_terlambat'] = $hari_terlambat;

        return view('peminjaman/cetak_laporan', $data);
    }
}
