<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash Alat</title>
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
                    <div class="card-header d-flex justify-content-between align-items-center bg-danger text-white">
                        <h4 class="mb-0"><i class="bi bi-trash"></i> Trash Alat</h4>
                        <div>
                            <a href="/alat" class="btn btn-light btn-sm">
                                <i class="bi bi-arrow-left"></i> Kembali ke Alat
                            </a>
                            <?php if (!empty($alat)): ?>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#emptyTrashModal">
                                <i class="bi bi-trash3"></i> Kosongkan Trash
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (empty($alat)): ?>
                            <div class="alert alert-info text-center">
                                <i class="bi bi-info-circle" style="font-size: 3rem;"></i>
                                <h5 class="mt-3">Trash Kosong</h5>
                                <p class="mb-0">Tidak ada alat yang dihapus</p>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> <strong>Perhatian:</strong> 
                                Alat di trash dapat dikembalikan atau dihapus permanen. Penghapusan permanen tidak dapat dibatalkan!
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="20%">Nama Alat</th>
                                            <th width="15%">Kategori</th>
                                            <th width="15%">Harga</th>
                                            <th width="10%">Kondisi</th>
                                            <th width="8%">Stok</th>
                                            <th width="12%">Dihapus Pada</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($alat as $a): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><strong><?= esc($a['nama_alat']) ?></strong></td>
                                            <td>
                                                <?php
                                                $cat = array_filter($category, fn($c) => $c['id_category'] == $a['id_category']);
                                                $cat = reset($cat);
                                                echo esc($cat['nama_category'] ?? '-');
                                                ?>
                                            </td>
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
                                            <td><span class="badge bg-secondary"><?= $a['stok'] ?></span></td>
                                            <td><small><?= date('d/m/Y H:i', strtotime($a['deleted_at'])) ?></small></td>
                                            
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty Trash Modal -->
    <div class="modal fade" id="emptyTrashModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Kosongkan Trash</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin mengosongkan trash?</p>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i> 
                        <strong>Semua alat di trash (<?= count($alat) ?> item) akan dihapus permanen!</strong><br>
                        Data yang dihapus tidak dapat dikembalikan!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="/alat/empty-trash" class="btn btn-danger">
                        <i class="bi bi-trash3"></i> Kosongkan Trash
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
