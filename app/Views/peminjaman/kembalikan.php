<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pengembalian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard">Sistem Peminjaman Alat</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/alat">Alat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/peminjaman">Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="bi bi-check-circle"></i> Konfirmasi Pengembalian</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted">Informasi Peminjaman</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td width="40%"><strong>Peminjam</strong></td>
                                        <td>: <?= esc($peminjaman['nama']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alat</strong></td>
                                        <td>: <?= esc($peminjaman['nama_alat']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jumlah</strong></td>
                                        <td>: <?= $peminjaman['jumlah'] ?> unit</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Informasi Waktu</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td width="50%"><strong>Tanggal Pinjam</strong></td>
                                        <td>: <?= date('d/m/Y', strtotime($peminjaman['tanggal_pinjam'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jatuh Tempo</strong></td>
                                        <td>: <?= date('d/m/Y', strtotime($peminjaman['tanggal_jatuh_tempo'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Kembali</strong></td>
                                        <td>: <?= date('d/m/Y', strtotime($peminjaman['tanggal_kembali'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Durasi Pinjam</strong></td>
                                        <td>: <?= $peminjaman['durasi_pinjam'] ?> hari</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <?php
                        // Hitung denda
                        $denda = 0;
                        $hari_terlambat = 0;
                        $tanggal_kembali = $peminjaman['tanggal_kembali'];
                        $tanggal_jatuh_tempo = $peminjaman['tanggal_jatuh_tempo'];

                        if ($tanggal_kembali && $tanggal_jatuh_tempo) {
                            $date_kembali = new DateTime($tanggal_kembali);
                            $date_jatuh_tempo = new DateTime($tanggal_jatuh_tempo);

                            if ($date_kembali > $date_jatuh_tempo) {
                                $interval = $date_jatuh_tempo->diff($date_kembali);
                                $hari_terlambat = $interval->days;
                                $denda = $hari_terlambat * 10000;
                            }
                        }
                        ?>

                        <!-- Info Denda -->
                        <?php if ($denda > 0): ?>
                            <div class="alert alert-danger">
                                <h5><i class="bi bi-exclamation-triangle"></i> Keterlambatan Terdeteksi!</h5>
                                <hr>
                                <p class="mb-1"><strong>Hari Terlambat:</strong> <?= $hari_terlambat ?> hari</p>
                                <p class="mb-1"><strong>Denda per Hari:</strong> Rp 10.000</p>
                                <h4 class="mb-0 mt-2"><strong>Total Denda: Rp <?= number_format($denda, 0, ',', '.') ?></strong></h4>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle"></i> <strong>Tepat Waktu!</strong><br>
                                Tidak ada denda keterlambatan.
                            </div>
                        <?php endif; ?>

                        <form action="/peminjaman/selesai/<?= $peminjaman['id_peminjaman'] ?>" method="post">
                            <div class="d-grid gap-2">
                                <a href="/peminjaman/cetak-laporan/<?= $peminjaman['id_peminjaman'] ?>" class="btn btn-primary btn-lg" target="_blank">
                                    <i class="bi bi-printer"></i> Cetak Laporan
                                </a>
                                <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('Validasi pengembalian ini?')">
                                    <i class="bi bi-check-circle"></i> Validasi & Selesaikan
                                </button>
                                <a href="/peminjaman" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>