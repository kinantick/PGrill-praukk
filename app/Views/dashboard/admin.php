<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <?= view('components/navbar', ['active' => 'profile']) ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-speedometer2"></i> Dashboard Admin</h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">Selamat datang, <strong><?= session()->get('nama') ?></strong></p>
                        <small class="text-muted"><?= session()->get('email') ?></small>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-success">
                            <div class="card-body text-center">
                                <i class="bi bi-box-seam" style="font-size: 2rem;"></i>
                                <h3 class="mt-2"><?= $totalAlat ?? 0 ?></h3>
                                <p class="mb-0">Total Alat</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Admin -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-grid"></i> Menu Admin</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="/user" class="btn btn-primary w-100 py-3">
                                    <i class="bi bi-people" style="font-size: 2rem;"></i>
                                    <div class="mt-2">Kelola User</div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="/alat" class="btn btn-success w-100 py-3">
                                    <i class="bi bi-box-seam" style="font-size: 2rem;"></i>
                                    <div class="mt-2">Kelola Alat</div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="/peminjaman" class="btn btn-warning w-100 py-3">
                                    <i class="bi bi-clipboard-check" style="font-size: 2rem;"></i>
                                    <div class="mt-2">Data Peminjaman</div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="/activity-log" class="btn btn-info w-100 py-3">
                                    <i class="bi bi-clock-history" style="font-size: 2rem;"></i>
                                    <div class="mt-2">Activity Log</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
