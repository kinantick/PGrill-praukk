<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Role User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-4">

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-4">Edit Role User</h4>

            <form action="/user/update/<?= $user['id_user'] ?>" method="post">

                <!-- Nama -->
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" value="<?= $user['nama'] ?>" readonly>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="<?= $user['email'] ?>" readonly>
                </div>

                <!-- No HP -->
                <div class="mb-3">
                    <label class="form-label">No Handphone</label>
                    <input type="text" class="form-control" value="<?= $user['no_hp'] ?>" readonly>
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" rows="2" readonly><?= $user['alamat'] ?></textarea>
                </div>

                <!-- ROLE (INI AJA YANG BISA DIUBAH) -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Role User</label>
                    <select name="role_user" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="Admin" <?= $user['role_user'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="Petugas" <?= $user['role_user'] == 'Petugas' ? 'selected' : '' ?>>Petugas</option>
                        <option value="Peminjam" <?= $user['role_user'] == 'Peminjam' ? 'selected' : '' ?>>Peminjam</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="/user" class="btn btn-secondary">Kembali</a>
                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>

