<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Activity Log' ?></title>
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
                        <h4 class="mb-0"><i class="bi bi-clock-history"></i> Activity Log</h4>
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

                        <!-- Filter Form -->
                        <form method="get" action="/activity-log" class="row g-3 mb-4">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="keyword" placeholder="Cari aktivitas, nama, email..." value="<?= esc($keyword ?? '') ?>">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="role">
                                    <option value="">Semua Role</option>
                                    <option value="Admin" <?= ($role ?? '') === 'Admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="Petugas" <?= ($role ?? '') === 'Petugas' ? 'selected' : '' ?>>Petugas</option>
                                    <option value="Peminjam" <?= ($role ?? '') === 'Peminjam' ? 'selected' : '' ?>>Peminjam</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" name="date" value="<?= esc($date ?? '') ?>">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                            </div>
                        </form>

                        <!-- Activity Log Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Waktu</th>
                                        <th width="15%">User</th>
                                        <th width="10%">Role</th>
                                        <th width="40%">Aktivitas</th>
                                        <th width="15%">IP Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($logs)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data activity log</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $no = 1 + (20 * ($pager->getCurrentPage() - 1)); ?>
                                        <?php foreach ($logs as $log): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td>
                                                    <small>
                                                        <?= date('d/m/Y', strtotime($log['created_at'])) ?><br>
                                                        <?= date('H:i:s', strtotime($log['created_at'])) ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <strong><?= esc($log['nama'] ?? 'Unknown') ?></strong><br>
                                                    <small class="text-muted"><?= esc($log['email'] ?? '-') ?></small>
                                                </td>
                                                <td>
                                                    <?php
                                                    $badgeClass = match($log['role_user']) {
                                                        'Admin' => 'bg-danger',
                                                        'Petugas' => 'bg-warning',
                                                        'Peminjam' => 'bg-info',
                                                        default => 'bg-secondary'
                                                    };
                                                    ?>
                                                    <span class="badge <?= $badgeClass ?>"><?= esc($log['role_user']) ?></span>
                                                </td>
                                                <td><?= esc($log['activity']) ?></td>
                                                <td><small><?= esc($log['ip_addres']) ?></small></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if (!empty($logs)): ?>
                            <div class="mt-3">
                                <?= $pager->links() ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clear Log Modal -->
    <div class="modal fade" id="clearLogModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Log Lama</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="/activity-log/clear">
                    <div class="modal-body">
                        <p>Hapus log yang lebih lama dari:</p>
                        <div class="mb-3">
                            <select class="form-select" name="days" required>
                                <option value="">Pilih periode...</option>
                                <option value="7">7 hari</option>
                                <option value="30">30 hari</option>
                                <option value="60">60 hari</option>
                                <option value="90">90 hari</option>
                            </select>
                        </div>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> 
                            Data yang dihapus tidak dapat dikembalikan!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
