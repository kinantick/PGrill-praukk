<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Status Peminjaman</title>
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
                        <a class="nav-link active" href="/peminjaman">Peminjaman</a>
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Ubah Status Peminjaman</h4>
                    </div>
                    <div class="card-body">
                        <!-- Info Peminjaman -->
                        <div class="alert alert-info">
                            <h6 class="mb-2"><i class="bi bi-info-circle"></i> Informasi Peminjaman</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Peminjam:</strong> <?= esc($peminjaman['nama']) ?></p>
                                    <p class="mb-1"><strong>Email:</strong> <?= esc($peminjaman['email']) ?></p>
                                    <p class="mb-1"><strong>Alat:</strong> <?= esc($peminjaman['nama_alat']) ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Jumlah:</strong> <?= $peminjaman['jumlah'] ?> unit</p>
                                    <p class="mb-1"><strong>Durasi:</strong> <?= $peminjaman['durasi_pinjam'] ?? '-' ?> hari</p>
                                    <p class="mb-1"><strong>Tanggal Pinjam:</strong> <?= date('d/m/Y', strtotime($peminjaman['tanggal_pinjam'])) ?></p>
                                    <?php if ($peminjaman['tanggal_jatuh_tempo']): ?>
                                    <p class="mb-1"><strong>Jatuh Tempo:</strong> <?= date('d/m/Y', strtotime($peminjaman['tanggal_jatuh_tempo'])) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Form -->
                        <form action="/peminjaman/update/<?= $peminjaman['id_peminjaman'] ?>" method="post" id="formStatus">
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-flag"></i> Status Peminjaman <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="Menunggu" <?= $peminjaman['status'] === 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                                    <option value="Disetujui" <?= $peminjaman['status'] === 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                    <option value="Ditolak" <?= $peminjaman['status'] === 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                </select>
                            </div>

                            <!-- Form Keterangan Ditolak (Hidden by default) -->
                            <div class="mb-3" id="keteranganDitolakDiv" style="display: none;">
                                <label class="form-label"><i class="bi bi-chat-left-text"></i> Keterangan Penolakan <span class="text-danger">*</span></label>
                                <textarea name="keterangan_ditolak" id="keterangan_ditolak" class="form-control" rows="4" placeholder="Masukkan alasan penolakan peminjaman..."><?= esc($peminjaman['keterangan_ditolak'] ?? '') ?></textarea>
                                <small class="text-muted">Jelaskan alasan mengapa peminjaman ditolak</small>
                            </div>

                            <div class="alert alert-warning" id="alertDitolak" style="display: none;">
                                <i class="bi bi-exclamation-triangle"></i> <strong>Perhatian:</strong> Keterangan penolakan wajib diisi jika status diubah menjadi "Ditolak"
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-check-circle"></i> Simpan Perubahan
                                </button>
                                <a href="/peminjaman" class="btn btn-outline-secondary">
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
        const statusSelect = document.getElementById('status');
        const keteranganDiv = document.getElementById('keteranganDitolakDiv');
        const keteranganTextarea = document.getElementById('keterangan_ditolak');
        const alertDitolak = document.getElementById('alertDitolak');
        const form = document.getElementById('formStatus');

        // Show/hide keterangan based on status
        function toggleKeterangan() {
            if (statusSelect.value === 'Ditolak') {
                keteranganDiv.style.display = 'block';
                alertDitolak.style.display = 'block';
                keteranganTextarea.required = true;
            } else {
                keteranganDiv.style.display = 'none';
                alertDitolak.style.display = 'none';
                keteranganTextarea.required = false;
            }
        }

        statusSelect.addEventListener('change', toggleKeterangan);

        // Check on page load
        toggleKeterangan();

        // Validate form before submit
        form.addEventListener('submit', function(e) {
            if (statusSelect.value === 'Ditolak' && !keteranganTextarea.value.trim()) {
                e.preventDefault();
                alert('Keterangan penolakan wajib diisi!');
                keteranganTextarea.focus();
            }
        });
    </script>
</body>
</html>
