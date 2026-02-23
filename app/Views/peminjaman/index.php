<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman</title>
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
                        <h4 class="mb-0"><i class="bi bi-clipboard-check"></i> Data Peminjaman</h4>
                        <?php if (session()->get('role') === 'Peminjam'): ?>
                        <a href="/peminjaman/create" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> Ajukan Peminjaman
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

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="3%">No</th>
                                        <th width="12%">Peminjam</th>
                                        <th width="12%">Alat</th>
                                        <th width="5%">Jumlah</th>
                                        <th width="8%">Durasi</th>
                                        <th width="9%">Tgl Pinjam</th>
                                        <th width="9%">Jatuh Tempo</th>
                                        <th width="9%">Tgl Kembali</th>
                                        <th width="8%">Status</th>
                                        <th width="8%">Denda</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($peminjaman)): ?>
                                        <tr>
                                            <td colspan="11" class="text-center">Belum ada data peminjaman</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $no = 1; foreach ($peminjaman as $p): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <strong><?= esc($p['nama']) ?></strong><br>
                                                <small class="text-muted"><?= esc($p['email']) ?></small>
                                            </td>
                                            <td><?= esc($p['nama_alat']) ?></td>
                                            <td><span class="badge bg-primary"><?= $p['jumlah'] ?></span></td>
                                            <td><small><?= $p['durasi_pinjam'] ?? '-' ?> hari</small></td>
                                            <td><small><?= date('d/m/Y', strtotime($p['tanggal_pinjam'])) ?></small></td>
                                            <td>
                                                <?php 
                                                // Cek apakah tanggal valid
                                                if ($p['tanggal_jatuh_tempo'] && $p['tanggal_jatuh_tempo'] != '0000-00-00' && strtotime($p['tanggal_jatuh_tempo']) > 0): 
                                                ?>
                                                    <small><?= date('d/m/Y', strtotime($p['tanggal_jatuh_tempo'])) ?></small>
                                                    <?php
                                                    // Cek apakah sudah lewat jatuh tempo dan masih dipinjam
                                                    if ($p['status'] === 'Disetujui' && strtotime($p['tanggal_jatuh_tempo']) < strtotime(date('Y-m-d'))):
                                                    ?>
                                                        <br><span class="badge bg-danger">Lewat!</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <small>-</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                // Cek apakah tanggal valid (bukan NULL, bukan 0000-00-00, dan bukan tanggal invalid)
                                                if ($p['tanggal_kembali'] && $p['tanggal_kembali'] != '0000-00-00' && strtotime($p['tanggal_kembali']) > 0): 
                                                ?>
                                                    <small><?= date('d/m/Y', strtotime($p['tanggal_kembali'])) ?></small>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $badge = match($p['status']) {
                                                    'Menunggu' => 'bg-warning',
                                                    'Disetujui' => 'bg-success',
                                                    'Ditolak' => 'bg-danger',
                                                    'Dikembalikan' => 'bg-info',
                                                    'Selesai' => 'bg-dark',
                                                    default => 'bg-secondary'
                                                };
                                                ?>
                                                <span class="badge <?= $badge ?>"><?= $p['status'] ?></span>
                                                
                                                <?php if ($p['status'] === 'Ditolak' && !empty($p['keterangan_ditolak'])): ?>
                                                    <br>
                                                    <small class="text-danger">
                                                        <i class="bi bi-info-circle"></i> 
                                                        <?= esc($p['keterangan_ditolak']) ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($p['denda'] > 0): ?>
                                                    <span class="badge bg-danger">Rp <?= number_format($p['denda'], 0, ',', '.') ?></span>
                                                <?php else: ?>
                                                    <small class="text-muted">-</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($p['status'] === 'Menunggu'): ?>
                                                    <?php if (session()->get('role') === 'Petugas'): ?>
                                                        <a href="/peminjaman/edit/<?= $p['id_peminjaman'] ?>" class="btn btn-sm btn-warning">
                                                            <i class="bi bi-pencil"></i> Proses
                                                        </a>
                                                    <?php else: ?>
                                                        <small class="text-muted"><i class="bi bi-hourglass-split"></i> Menunggu</small>
                                                    <?php endif; ?>
                                                <?php elseif ($p['status'] === 'Disetujui'): ?>
                                                    <?php if (session()->get('role') === 'Peminjam'): ?>
                                                    <form action="/peminjaman/kembalikan/<?= $p['id_peminjaman'] ?>" method="post" style="display:inline;">
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Ajukan pengembalian alat ini?')">
                                                            <i class="bi bi-arrow-return-left"></i> Kembalikan
                                                        </button>
                                                    </form>
                                                    <?php else: ?>
                                                        <small class="text-success"><i class="bi bi-check-circle"></i> Dipinjam</small>
                                                    <?php endif; ?>
                                                <?php elseif ($p['status'] === 'Dikembalikan'): ?>
                                                    <?php if (session()->get('role') === 'Petugas'): ?>
                                                        <a href="/peminjaman/cek-pengembalian/<?= $p['id_peminjaman'] ?>" class="btn btn-sm btn-info">
                                                            <i class="bi bi-eye"></i> Cek
                                                        </a>
                                                    <?php else: ?>
                                                        <small class="text-info"><i class="bi bi-clock-history"></i> Menunggu</small>
                                                    <?php endif; ?>
                                                <?php elseif ($p['status'] === 'Selesai'): ?>
                                                    <small class="text-success"><i class="bi bi-check-circle-fill"></i> Selesai</small>
                                                <?php elseif ($p['status'] === 'Ditolak'): ?>
                                                    <small class="text-danger"><i class="bi bi-x-circle"></i> Ditolak</small>
                                                <?php endif; ?>
                                            </td>
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
