<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengembalian - <?= $peminjaman['id_peminjaman'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .kop-surat h2 {
            margin: 0;
            font-weight: bold;
        }

        .kop-surat p {
            margin: 5px 0;
            font-size: 14px;
        }

        .judul-laporan {
            text-align: center;
            margin: 30px 0;
            font-weight: bold;
            text-decoration: underline;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 8px 0;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 200px;
            font-weight: 600;
        }

        .info-table td:nth-child(2) {
            width: 20px;
        }

        .denda-box {
            border: 2px solid #dc3545;
            padding: 15px;
            margin: 20px 0;
            background-color: #f8d7da;
        }

        .success-box {
            border: 2px solid #198754;
            padding: 15px;
            margin: 20px 0;
            background-color: #d1e7dd;
        }

        .ttd-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .ttd-box {
            text-align: center;
            width: 45%;
        }

        .ttd-box .nama {
            margin-top: 80px;
            border-top: 1px solid #000;
            padding-top: 5px;
            display: inline-block;
            min-width: 200px;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                padding: 0;
            }

            .container {
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Tombol Cetak (tidak akan tercetak) -->
        <div class="no-print mb-3">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i> Cetak Laporan
            </button>
            <a href="/peminjaman/cek-pengembalian/<?= $peminjaman['id_peminjaman'] ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Kop Surat -->
        <div class="kop-surat">
            <h2>SISTEM PEMINJAMAN ALAT</h2>
            <p>Jl. Sangkuriang No. 76, Cimahi, Jawa Barat 40511</p>
            <p>Telp: (021) 1234567 | Email: info@peminjamangrillbqq.com</p>
        </div>

        <!-- Judul Laporan -->
        <h4 class="judul-laporan">LAPORAN PENGEMBALIAN PEMINJAMAN ALAT</h4>

        <!-- Informasi Peminjaman -->
        <table class="info-table">
            <tr>
                <td>No. Peminjaman</td>
                <td>:</td>
                <td><?= str_pad($peminjaman['id_peminjaman'], 5, '0', STR_PAD_LEFT) ?></td>
            </tr>
            <tr>
                <td>Nama Peminjam</td>
                <td>:</td>
                <td><?= esc($peminjaman['nama']) ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td><?= esc($peminjaman['email']) ?></td>
            </tr>
        </table>

        <h5 style="margin-top: 30px; margin-bottom: 15px;">Detail Alat</h5>
        <table class="info-table">
            <tr>
                <td>Nama Alat</td>
                <td>:</td>
                <td><?= esc($peminjaman['nama_alat']) ?></td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>:</td>
                <td><?= isset($peminjaman['nama_category']) ? esc($peminjaman['nama_category']) : '-' ?></td>
            </tr>
            <tr>
                <td>Jumlah Dipinjam</td>
                <td>:</td>
                <td><?= $peminjaman['jumlah'] ?> unit</td>
            </tr>
        </table>

        <h5 style="margin-top: 30px; margin-bottom: 15px;">Informasi Waktu</h5>
        <table class="info-table">
            <tr>
                <td>Tanggal Peminjaman</td>
                <td>:</td>
                <td><?= date('d F Y', strtotime($peminjaman['tanggal_pinjam'])) ?></td>
            </tr>
            <tr>
                <td>Durasi Peminjaman</td>
                <td>:</td>
                <td><?= $peminjaman['durasi_pinjam'] ?> hari</td>
            </tr>
            <tr>
                <td>Tanggal Jatuh Tempo</td>
                <td>:</td>
                <td><?= date('d F Y', strtotime($peminjaman['tanggal_jatuh_tempo'])) ?></td>
            </tr>
            <tr>
                <td>Tanggal Pengembalian</td>
                <td>:</td>
                <td><?= date('d F Y', strtotime($peminjaman['tanggal_kembali'])) ?></td>
            </tr>
        </table>

        <!-- Info Denda atau Tepat Waktu -->
        <?php if ($denda > 0): ?>
            <div class="denda-box">
                <h5 style="color: #dc3545; margin-bottom: 15px;">⚠️ KETERLAMBATAN PENGEMBALIAN</h5>
                <table class="info-table" style="margin: 0;">
                    <tr>
                        <td>Hari Terlambat</td>
                        <td>:</td>
                        <td><strong><?= $hari_terlambat ?> hari</strong></td>
                    </tr>
                    <tr>
                        <td>Denda per Hari</td>
                        <td>:</td>
                        <td>Rp 10.000</td>
                    </tr>
                    <tr>
                        <td><strong>Total Denda</strong></td>
                        <td>:</td>
                        <td><strong style="font-size: 18px; color: #dc3545;">Rp <?= number_format($denda, 0, ',', '.') ?></strong></td>
                    </tr>
                </table>
            </div>
        <?php else: ?>
            <div class="success-box">
                <h5 style="color: #198754; margin: 0;">✓ PENGEMBALIAN TEPAT WAKTU</h5>
                <p style="margin: 10px 0 0 0;">Tidak ada denda keterlambatan.</p>
            </div>
        <?php endif; ?>

        <!-- Tanda Tangan -->
        <div class="ttd-section">
            <div class="ttd-box">
                <p>Peminjam,</p>
                <div class="nama"><?= esc($peminjaman['nama']) ?></div>
            </div>
            <div class="ttd-box">
                <p>Petugas,</p>
                <div class="nama">( _________________ )</div>
            </div>
        </div>

        <p style="margin-top: 50px; font-size: 12px; text-align: center; color: #666;">
            Laporan ini dicetak pada: <?= date('d F Y, H:i') ?> WIB
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
