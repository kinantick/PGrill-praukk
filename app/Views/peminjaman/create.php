<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Peminjaman</title>
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
                        <a class="nav-link" href="/alat/tersedia">Alat Tersedia</a>
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

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Ajukan Peminjaman Alat</h4>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="/peminjaman/store" method="post" id="formPeminjaman">
                            <!-- Pilih Alat -->
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-box-seam"></i> Pilih Alat <span class="text-danger">*</span></label>
                                <select name="id_alat" class="form-select" required>
                                    <option value="">-- Pilih Alat --</option>
                                    <?php foreach ($alat as $a): ?>
                                        <option value="<?= $a['id_alat'] ?>">
                                            <?= $a['nama_alat'] ?> (Stok: <?= $a['stok'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Jumlah -->
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-123"></i> Jumlah Pinjam <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah" class="form-control" min="1" placeholder="Masukkan jumlah" required>
                                <small class="text-muted">Jumlah alat yang ingin dipinjam</small>
                            </div>

                            <!-- Durasi Pinjam -->
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-calendar-range"></i> Durasi Peminjaman <span class="text-danger">*</span></label>
                                <select name="durasi_pinjam" id="durasi_pinjam" class="form-select" required>
                                    <option value="">-- Pilih Durasi --</option>
                                    <option value="1">1 Hari</option>
                                    <option value="3">3 Hari</option>
                                    <option value="7">7 Hari (1 Minggu)</option>
                                    <option value="14">14 Hari (2 Minggu)</option>
                                    <option value="30">30 Hari (1 Bulan)</option>
                                </select>
                                <small class="text-muted">Pilih berapa lama Anda akan meminjam alat</small>
                            </div>

                            <!-- Tanggal Pinjam -->
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-calendar-check"></i> Tanggal Pinjam <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>

                            <!-- Tanggal Jatuh Tempo (Auto Calculate) -->
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-calendar-x"></i> Tanggal Jatuh Tempo</label>
                                <input type="text" id="tanggal_jatuh_tempo_display" class="form-control" readonly placeholder="Pilih durasi terlebih dahulu">
                                <small class="text-muted">Tanggal maksimal pengembalian alat</small>
                            </div>

                            <!-- Info Denda -->
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> <strong>Informasi Denda:</strong><br>
                                Denda keterlambatan: <strong>Rp 10.000 per hari</strong><br>
                                Pastikan mengembalikan alat sebelum tanggal jatuh tempo!
                            </div>

                            <!-- Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Ajukan Peminjaman
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
        // Auto calculate tanggal jatuh tempo
        const tanggalPinjam = document.getElementById('tanggal_pinjam');
        const durasiPinjam = document.getElementById('durasi_pinjam');
        const tanggalJatuhTempoDisplay = document.getElementById('tanggal_jatuh_tempo_display');

        function calculateJatuhTempo() {
            const tglPinjam = tanggalPinjam.value;
            const durasi = parseInt(durasiPinjam.value);

            if (tglPinjam && durasi) {
                const date = new Date(tglPinjam);
                date.setDate(date.getDate() + durasi);
                
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                tanggalJatuhTempoDisplay.value = date.toLocaleDateString('id-ID', options);
            } else {
                tanggalJatuhTempoDisplay.value = '';
            }
        }

        tanggalPinjam.addEventListener('change', calculateJatuhTempo);
        durasiPinjam.addEventListener('change', calculateJatuhTempo);

        // Set min date to today
        tanggalPinjam.min = new Date().toISOString().split('T')[0];
    </script>
</body>
</html>
