<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Alat Tersedia</title>
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
                        <a class="nav-link active" href="/alat/tersedia">Alat Tersedia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/peminjaman">Peminjaman Saya</a>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="bi bi-box-seam"></i> Daftar Alat Tersedia</h4>
                        <a href="/peminjaman/create" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Ajukan Peminjaman
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="30%">Nama Alat</th>
                                        <th width="20%">Harga</th>
                                        <th width="15%">Kondisi</th>
                                        <th width="15%">Stok</th>
                                        <th width="15%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($alat)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada alat tersedia saat ini</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $no = 1; foreach ($alat as $a): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><strong><?= esc($a['nama_alat']) ?></strong></td>
                                            <td>Rp <?= number_format($a['harga_alat'], 0, ',', '.') ?></td>
                                            <td>
                                                <?php
                                                $kondisiBadge = match($a['kondisi']) {
                                                    'baik' => 'bg-success',
                                                    'rusak' => 'bg-danger',
                                                    default => 'bg-warning'
                                                };
                                                ?>
                                                <span class="badge <?= $kondisiBadge ?>"><?= ucfirst($a['kondisi']) ?></span>
                                            </td>
                                            <td>
                                                <?php if ($a['stok'] > 0): ?>
                                                    <span class="badge bg-primary"><?= $a['stok'] ?> unit</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Habis</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($a['stok'] > 0): ?>
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle"></i> Tersedia
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">
                                                        <i class="bi bi-x-circle"></i> Tidak Tersedia
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
