<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <?= view('components/navbar', ['active' => 'profile']) ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="bi bi-box-seam"></i> Data Alat</h4>
                        <div>
                            <?php if (session()->get('role') === 'Admin'): ?>
                            <a href="/alat/trash" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Trash
                            </a>
                            <a href="/alat/create" class="btn btn-success btn-sm">
                                <i class="bi bi-plus-circle"></i> Tambah Alat
                            </a>
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

                        <!-- Filter Form -->
                        <form method="get" action="/alat" class="row g-3 mb-4">
                            <div class="col-md-4">
                                <input type="text" name="keyword" class="form-control" placeholder="Cari alat..." value="<?= esc($keyword ?? '') ?>">
                            </div>
                            <div class="col-md-4">
                                <select name="category" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    <?php foreach ($category as $c): ?>
                                        <option value="<?= $c['id_category'] ?>" <?= ($catFilter ?? '') == $c['id_category'] ? 'selected' : '' ?>>
                                            <?= $c['nama_category'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="/alat" class="btn btn-secondary w-100">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </a>
                            </div>
                        </form>

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
                                        <th width="10%">Status</th>
                                        <?php if (session()->get('role') === 'Admin'): ?>
                                        <th width="17%">Aksi</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($alat)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data alat</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $no = 1; foreach ($alat as $a): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><strong><?= esc($a['nama_alat']) ?></strong></td>
                                            <td><?= esc($a['nama_category']) ?></td>
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
                                            <td><span class="badge bg-primary"><?= $a['stok'] ?></span></td>
                                            <td>
                                                <?php
                                                $statusBadge = $a['status'] === 'tersedia' ? 'bg-success' : 'bg-secondary';
                                                ?>
                                                <span class="badge <?= $statusBadge ?>"><?= ucfirst($a['status']) ?></span>
                                            </td>
                                            <?php if (session()->get('role') === 'Admin'): ?>
                                            <td>
                                                <a href="/alat/edit/<?= $a['id_alat'] ?>" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <a href="/alat/delete/<?= $a['id_alat'] ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Yakin hapus data alat ini?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            </td>
                                            <?php endif; ?>
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
