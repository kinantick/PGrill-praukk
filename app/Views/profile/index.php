<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <?= view('components/navbar', ['active' => 'profile']) ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-person-circle"></i> Profile Saya</h4>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                <div class="mb-3">
                                    <i class="bi bi-person-circle" style="font-size: 8rem; color: #0d6efd;"></i>
                                </div>
                                <h5><?= esc($user['nama']) ?></h5>
                                <span class="badge bg-<?= $user['role_user'] === 'Admin' ? 'danger' : ($user['role_user'] === 'Petugas' ? 'warning' : 'info') ?> mb-3">
                                    <?= esc($user['role_user']) ?>
                                </span>
                            </div>
                            <div class="col-md-8">
                                <h5 class="mb-3"><i class="bi bi-info-circle"></i> Informasi Profile</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="30%"><strong><i class="bi bi-envelope"></i> Email</strong></td>
                                        <td>: <?= esc($user['email']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="bi bi-person-badge"></i> Nama</strong></td>
                                        <td>: <?= esc($user['nama']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="bi bi-shield-check"></i> Role</strong></td>
                                        <td>: <?= esc($user['role_user']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="bi bi-telephone"></i> No HP</strong></td>
                                        <td>: <?= esc($user['no_hp']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="bi bi-geo-alt"></i> Alamat</strong></td>
                                        <td>: <?= esc($user['alamat']) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <a href="/profile/edit" class="btn btn-warning btn-lg">
                                <i class="bi bi-pencil-square"></i> Edit Profile
                            </a>
                            <a href="/dashboard" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
