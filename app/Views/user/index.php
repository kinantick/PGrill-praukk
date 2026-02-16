<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
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
                        <h4 class="mb-0"><i class="bi bi-people"></i> Data User</h4>
                        <?php if (session()->get('role') === 'Admin'): ?>
                        <a href="/user/create" class="btn btn-success btn-sm">
                            <i class="bi bi-person-plus"></i> Tambah User
                        </a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="20%">Nama</th>
                                        <th width="20%">Email</th>
                                        <th width="10%">Role</th>
                                        <th width="15%">No Handphone</th>
                                        <th width="20%">Alamat</th>
                                        <?php if (session()->get('role') === 'Admin'): ?>
                                        <th width="10%">Aksi</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($users)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data user</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $no = 1; foreach ($users as $u): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><strong><?= esc($u['nama']) ?></strong></td>
                                            <td><?= esc($u['email']) ?></td>
                                            <td>
                                                <?php
                                                $badgeClass = match($u['role_user']) {
                                                    'Admin' => 'bg-danger',
                                                    'Petugas' => 'bg-warning',
                                                    'Peminjam' => 'bg-info',
                                                    default => 'bg-secondary'
                                                };
                                                ?>
                                                <span class="badge <?= $badgeClass ?>"><?= esc($u['role_user']) ?></span>
                                            </td>
                                            <td><?= esc($u['no_hp']) ?></td>
                                            <td><?= esc($u['alamat']) ?></td>
                                            <?php if (session()->get('role') === 'Admin'): ?>
                                            <td>
                                                <a href="/user/edit/<?= $u['id_user'] ?>" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="/user/delete/<?= $u['id_user'] ?>"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Hapus user ini?')">
                                                    <i class="bi bi-trash"></i>
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
