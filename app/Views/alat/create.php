<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Alat</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">

    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="mb-4">Tambah Alat</h3>

                <!-- FORM -->
                <form action="/alat/store" method="post">

                    <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Alat</label>
                    <input type="text" name="nama_alat" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="id_category" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($category as $c): ?>
                                <option value="<?= $c['id_category'] ?>">
                                    <?= $c['nama_category'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Harga Alat</label>
                        <input type="number" name="harga_alat" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kondisi</label>
                        <input type="text" name="kondisi" class="form-control" placeholder="contoh: bagus">
                    </div>

                    <div class="mb-3">
                    <label class="form-label fw-semibold">Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold d-block">Status</label>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" value="Tersedia" checked>
                            <label class="form-check-label">Tersedia</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" value="Dipinjam">
                            <label class="form-check-label">Dipinjam</label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                        <a href="/alat" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</body>
</html>