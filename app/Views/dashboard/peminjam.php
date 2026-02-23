<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peminjam</title>
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
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .info-box {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            border-radius: 10px;
            padding: 1.5rem;
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
                    <h2><i class="bi bi-speedometer2"></i> Dashboard Peminjam</h2>
                    <p class="mb-0 fs-5">Selamat datang, <strong><?= session()->get('nama') ?></strong></p>
                    <small class="opacity-75"><?= session()->get('email') ?></small>
                </div>
                <div class="col-md-4 text-end">
                    <i class="bi bi-person-circle" style="font-size: 5rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="info-box">
            <div class="row align-items-center">
                <div class="col-md-1 text-center">
                    <i class="bi bi-info-circle" style="font-size: 2.5rem; color: #0dcaf0;"></i>
                </div>
                <div class="col-md-11">
                    <h6 class="mb-1" style="color: #0d6efd;">Informasi Peminjaman</h6>
                    <p class="mb-0 small" style="color: #495057;">
                        Anda dapat meminjam alat yang tersedia dengan mengajukan peminjaman. 
                        Petugas akan memvalidasi pengajuan Anda. Pastikan mengembalikan alat tepat waktu untuk menghindari denda.
                    </p>
                </div>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card border-0 shadow-sm bg-success text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam stat-icon"></i>
                        <h2 class="mt-3 mb-0"><?= $alatTersedia ?? 0 ?></h2>
                        <p class="mb-0">Alat Tersedia</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-clipboard-data stat-icon"></i>
                        <h2 class="mt-3 mb-0"><?= $peminjamanSaya ?? 0 ?></h2>
                        <p class="mb-0">Total Peminjaman</p>
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
                        <i class="bi bi-check-circle stat-icon"></i>
                        <h2 class="mt-3 mb-0"><?= $peminjamanDisetujui ?? 0 ?></h2>
                        <p class="mb-0">Sedang Dipinjam</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Detail -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Peminjaman Selesai</h6>
                                <h3 class="mb-0 text-success"><?= $peminjamanSelesai ?? 0 ?></h3>
                                <small class="text-muted">Riwayat peminjaman</small>
                            </div>
                            <div class="text-success">
                                <i class="bi bi-check-circle-fill" style="font-size: 3rem; opacity: 0.3;"></i>
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
                                <h6 class="text-muted mb-1">Sedang Dipinjam</h6>
                                <h3 class="mb-0 text-primary"><?= $peminjamanDisetujui ?? 0 ?></h3>
                                <small class="text-muted">Jangan lupa kembalikan</small>
                            </div>
                            <div class="text-primary">
                                <i class="bi bi-clipboard-check" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Peminjam -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4">
                <h5 class="mb-0"><i class="bi bi-grid-3x3-gap"></i> Menu Utama</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <a href="/alat/tersedia" class="menu-card bg-success">
                            <div class="text-center">
                                <i class="bi bi-box-seam" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 mb-0">Alat Tersedia</h5>
                                <small>Lihat alat yang bisa dipinjam</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/peminjaman/create" class="menu-card bg-primary">
                            <div class="text-center">
                                <i class="bi bi-plus-circle" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 mb-0">Ajukan Peminjaman</h5>
                                <small>Buat pengajuan baru</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/peminjaman" class="menu-card bg-warning">
                            <div class="text-center">
                                <i class="bi bi-clipboard-check" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 mb-0">Peminjaman Saya</h5>
                                <small>Lihat status peminjaman</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <?php if ($peminjamanDisetujui > 0): ?>
        <div class="card border-0 shadow-sm mt-4 border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="mb-1"><i class="bi bi-exclamation-circle text-primary"></i> Pengingat</h6>
                        <p class="mb-0 small text-muted">
                            Anda memiliki <strong><?= $peminjamanDisetujui ?></strong> peminjaman aktif. 
                            Jangan lupa untuk mengembalikan alat tepat waktu!
                        </p>
                    </div>
                    <div>
                        <a href="/peminjaman" class="btn btn-primary">
                            <i class="bi bi-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
