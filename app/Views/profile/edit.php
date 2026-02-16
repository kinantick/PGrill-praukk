<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
                        <h4 class="mb-0"><i class="bi bi-person-gear"></i> Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="/profile/update" id="formProfile">
                            <?= csrf_field() ?>

                            <h5 class="mb-3"><i class="bi bi-person"></i> Informasi Pribadi</h5>
                            
                            <!-- Email (Read Only) -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?= esc($user['email']) ?>" readonly>
                                <small class="text-muted">Email tidak dapat diubah</small>
                            </div>

                            <!-- Nama -->
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-person-badge"></i> Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control" value="<?= esc($user['nama']) ?>" required>
                            </div>

                            <!-- No HP -->
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-telephone"></i> No Handphone <span class="text-danger">*</span></label>
                                <input type="text" name="no_hp" class="form-control" value="<?= esc($user['no_hp']) ?>" required>
                            </div>

                            <!-- Alamat -->
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-geo-alt"></i> Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control" rows="3" required><?= esc($user['alamat']) ?></textarea>
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3"><i class="bi bi-shield-lock"></i> Ubah Password (Opsional)</h5>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> Kosongkan jika tidak ingin mengubah password
                            </div>

                            <!-- Password Lama -->
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-key"></i> Password Lama</label>
                                <div class="input-group">
                                    <input type="password" name="password_lama" id="password_lama" class="form-control" placeholder="Masukkan password lama">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_lama')">
                                        <i class="bi bi-eye" id="icon_password_lama"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Password Baru -->
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-key-fill"></i> Password Baru</label>
                                <div class="input-group">
                                    <input type="password" name="password_baru" id="password_baru" class="form-control" placeholder="Masukkan password baru (min. 6 karakter)">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_baru')">
                                        <i class="bi bi-eye" id="icon_password_baru"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-key-fill"></i> Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <input type="password" name="password_konfirmasi" id="password_konfirmasi" class="form-control" placeholder="Ulangi password baru">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_konfirmasi')">
                                        <i class="bi bi-eye" id="icon_password_konfirmasi"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle"></i> Simpan Perubahan
                                </button>
                                <a href="/profile" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById('icon_' + fieldId);
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        // Validasi form
        document.getElementById('formProfile').addEventListener('submit', function(e) {
            const passwordLama = document.getElementById('password_lama').value;
            const passwordBaru = document.getElementById('password_baru').value;
            const passwordKonfirmasi = document.getElementById('password_konfirmasi').value;

            // Jika salah satu field password diisi, semua harus diisi
            if (passwordLama || passwordBaru || passwordKonfirmasi) {
                if (!passwordLama) {
                    e.preventDefault();
                    alert('Password lama harus diisi!');
                    document.getElementById('password_lama').focus();
                    return false;
                }
                
                if (!passwordBaru) {
                    e.preventDefault();
                    alert('Password baru harus diisi!');
                    document.getElementById('password_baru').focus();
                    return false;
                }
                
                if (!passwordKonfirmasi) {
                    e.preventDefault();
                    alert('Konfirmasi password harus diisi!');
                    document.getElementById('password_konfirmasi').focus();
                    return false;
                }

                if (passwordBaru.length < 6) {
                    e.preventDefault();
                    alert('Password minimal 6 karakter!');
                    document.getElementById('password_baru').focus();
                    return false;
                }

                if (passwordBaru !== passwordKonfirmasi) {
                    e.preventDefault();
                    alert('Password baru dan konfirmasi tidak sama!');
                    document.getElementById('password_konfirmasi').focus();
                    return false;
                }
            }
        });
    </script>
</body>
</html>
