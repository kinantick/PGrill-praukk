<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Alat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4">Edit Alat</h3>

            <!-- FORM -->
             <form action="/alat/update/<?= $alat['id_alat']; ?>" method="post">

    <div class="mb-3">
        <label class="form-label fw-semibold">Nama Alat</label>
        <input type="text" name="nama_alat" class="form-control"
               value="<?= esc($alat['nama_alat']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Kategori</label>
        <select name="id_category" class="form-select" required>
            <?php foreach ($category as $c): ?>
                <option value="<?= $c['id_category']; ?>"
                    <?= ($c['id_category'] == $alat['id_category']) ? 'selected' : ''; ?>>
                    <?= esc($c['nama_category']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Kondisi</label>
        <input type="text" name="kondisi" class="form-control"
               value="<?= esc($alat['kondisi']); ?>">
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Stok</label>
        <input type="number" name="stok" class="form-control"
               value="<?= esc($alat['stok']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Harga Alat</label>
        <input type="number" name="harga_alat" class="form-control"
               value="<?= esc($alat['harga_alat']); ?>" required>
    </div>

    <div class="mb-4">
        <label class="form-label fw-semibold">Status</label>
        <select name="status" class="form-select">
            <option value="Tersedia" <?= $alat['status'] == 'Tersedia' ? 'selected' : ''; ?>>
                Tersedia
            </option>
            <option value="Dipinjam" <?= $alat['status'] == 'Dipinjam' ? 'selected' : ''; ?>>
                Dipinjam
            </option>
        </select>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-warning">
            Update
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
