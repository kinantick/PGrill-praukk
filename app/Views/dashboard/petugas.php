<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .stat-card {
            border-radius: 10px;
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .stat-icon {
            font-size: 3rem;
            opacity: 0.8;
        }
        .menu-card {
            border-radius: 10px;
            transition: all 0.3s;
            text-decoration: none;
            color: white;
            display: block;
            padding: 2rem 1rem;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            color: white;
        }
        .welcome-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body class="bg-light">
    <?= view('components/navbar', ['active' => 'dashboard']) ?>

    <div class="container mt-4">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2><i class="bi bi-speedometer2"></i> Dashboard Petugas</h2>
                    <p class="mb-0 fs-5">Selamat datang, <strong><?= session()->get('nama') ?></strong></p>
                    <small class="opacity-75"><?= session()->get('email') ?></small>
                </div>
                <div class="col-md-4 text-end">
                    <i class="bi bi-person-badge" style="font-size: 5rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card border-0 shadow-sm bg-success text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam stat-icon"></i>
                        <h2 class="mt-3 mb-0"><?= $totalAlat ?? 0 ?></h2>
                        <p class="mb-0">Total Alat</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle stat-icon"></i>
                        <h2 class="mt-3 mb-0"><?= $alatTersedia ?? 0 ?></h2>
                        <p class="mb-0">Alat Tersedia</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border-0 shadow-sm bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-hourglass-split stat-icon"></i>
                        <h2 class="mt-3 mb-0"><?= $peminjamanMenunggu ?? 0 ?></h2>
                        <p class="mb-0">Menunggu Validasi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border-0 shadow-sm bg-info text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-return-left stat-icon"></i>
                        <h2 class="mt-3 mb-0"><?= $peminjamanDikembalikan ?? 0 ?></h2>
                        <p class="mb-0">Perlu Dicek</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Peminjaman Detail -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Peminjaman Disetujui</h6>
                                <h3 class="mb-0 text-success"><?= $peminjamanDisetujui ?? 0 ?></h3>
                                <small class="text-muted">Sedang dipinjam</small>
                            </div>
                            <div class="text-success">
                                <i class="bi bi-clipboard-check" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Menunggu Validasi</h6>
                                <h3 class="mb-0 text-warning"><?= $peminjamanMenunggu ?? 0 ?></h3>
                                <small class="text-muted">Perlu diproses</small>
                            </div>
                            <div class="text-warning">
                                <i class="bi bi-exclamation-triangle" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Petugas -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0"><i class="bi bi-grid-3x3-gap"></i> Menu Utama</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <a href="/peminjaman" class="menu-card bg-warning">
                            <div class="text-center">
                                <i class="bi bi-clipboard-check" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 mb-0">Kelola Peminjaman</h5>
                                <small>Validasi & pengembalian</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/alat" class="menu-card bg-success">
                            <div class="text-center">
                                <i class="bi bi-box-seam" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 mb-0">Data Alat</h5>
                                <small>Lihat data alat</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/user" class="menu-card bg-primary">
                            <div class="text-center">
                                <i class="bi bi-people" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 mb-0">Data User</h5>
                                <small>Lihat data pengguna</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0"><i class="bi bi-lightning"></i> Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex">
                    <a href="/peminjaman" class="btn btn-outline-warning">
                        <i class="bi bi-hourglass-split"></i> Lihat Peminjaman Menunggu (<?= $peminjamanMenunggu ?? 0 ?>)
                    </a>
                    <a href="/peminjaman" class="btn btn-outline-info">
                        <i class="bi bi-arrow-return-left"></i> Cek Pengembalian (<?= $peminjamanDikembalikan ?? 0 ?>)
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
