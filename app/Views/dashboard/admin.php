<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
                    <h2><i class="bi bi-speedometer2"></i> Dashboard Admin</h2>
                    <p class="mb-0 fs-5">Selamat datang, <strong><?= session()->get('nama') ?></strong></p>
                    <small class="opacity-75"><?= session()->get('email') ?></small>
                </div>
                <div class="col-md-4 text-end">
                    <i class="bi bi-person-circle" style="font-size: 5rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-people stat-icon"></i>
                        <h2 class="mt-3 mb-0"><?= $totalUser ?? 0 ?></h2>
                        <p class="mb-0">Total User</p>
                    </div>
                </div>
            </div>
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
                <div class="card stat-card border-0 shadow-sm bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-clipboard-check stat-icon"></i>
                        <h2 class="mt-3 mb-0"><?= $totalPeminjaman ?? 0 ?></h2>
                        <p class="mb-0">Total Peminjaman</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border-0 shadow-sm bg-info text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-clock-history stat-icon"></i>
                        <h2 class="mt-3 mb-0"><?= $peminjamanMenunggu ?? 0 ?></h2>
                        <p class="mb-0">Menunggu Validasi</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Peminjaman -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Disetujui</h6>
                                <h3 class="mb-0"><?= $peminjamanDisetujui ?? 0 ?></h3>
                            </div>
                            <div class="text-success">
                                <i class="bi bi-check-circle" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Dikembalikan</h6>
                                <h3 class="mb-0"><?= $peminjamanDikembalikan ?? 0 ?></h3>
                            </div>
                            <div class="text-primary">
                                <i class="bi bi-arrow-return-left" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Menunggu</h6>
                                <h3 class="mb-0"><?= $peminjamanMenunggu ?? 0 ?></h3>
                            </div>
                            <div class="text-warning">
                                <i class="bi bi-hourglass-split" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Admin -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0"><i class="bi bi-grid-3x3-gap"></i> Menu Utama</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-3">
                        <a href="/user" class="menu-card bg-primary">
                            <div class="text-center">
                                <i class="bi bi-people" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 mb-0">Kelola User</h5>
                                <small>Manajemen pengguna</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="/alat" class="menu-card bg-success">
                            <div class="text-center">
                                <i class="bi bi-box-seam" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 mb-0">Kelola Alat</h5>
                                <small>Manajemen alat</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="/peminjaman" class="menu-card bg-warning">
                            <div class="text-center">
                                <i class="bi bi-clipboard-check" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 mb-0">Peminjaman</h5>
                                <small>Data peminjaman</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="/activity-log" class="menu-card bg-info">
                            <div class="text-center">
                                <i class="bi bi-clock-history" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 mb-0">Activity Log</h5>
                                <small>Riwayat aktivitas</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
