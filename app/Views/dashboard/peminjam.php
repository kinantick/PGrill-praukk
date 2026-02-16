<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peminjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <?= view('components/navbar', ['active' => 'profile']) ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="bi bi-speedometer2"></i> Dashboard Peminjam</h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">Selamat datang, <strong><?= session()->get('nama') ?></strong></p>
                        <small class="text-muted"><?= session()->get('email') ?></small>
                    </div>
                </div>

                <!-- Menu Peminjam -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-grid"></i> Menu Peminjam</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <a href="/alat/tersedia" class="btn btn-success w-100 py-3">
                                    <i class="bi bi-box-seam" style="font-size: 2rem;"></i>
                                    <div class="mt-2">Lihat Alat Tersedia</div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="/peminjaman" class="btn btn-warning w-100 py-3">
                                    <i class="bi bi-clipboard-check" style="font-size: 2rem;"></i>
                                    <div class="mt-2">Peminjaman Saya</div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="/peminjaman/create" class="btn btn-primary w-100 py-3">
                                    <i class="bi bi-plus-circle" style="font-size: 2rem;"></i>
                                    <div class="mt-2">Ajukan Peminjaman</div>
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
