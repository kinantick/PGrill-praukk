-- SQL Lengkap untuk Update Tabel Peminjaman
-- Jalankan query ini di database Anda
-- PENTING: Jalankan satu per satu, skip jika kolom sudah ada

-- 1. Tambahkan kolom durasi_pinjam
ALTER TABLE `peminjaman` 
ADD COLUMN `durasi_pinjam` INT(11) NULL COMMENT 'Durasi peminjaman dalam hari' AFTER `jumlah`;

-- 2. Tambahkan kolom tanggal_jatuh_tempo
ALTER TABLE `peminjaman` 
ADD COLUMN `tanggal_jatuh_tempo` DATE NULL COMMENT 'Tanggal jatuh tempo pengembalian' AFTER `tanggal_pinjam`;

-- 3. Tambahkan kolom denda
ALTER TABLE `peminjaman` 
ADD COLUMN `denda` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT 'Denda keterlambatan' AFTER `tanggal_kembali`;

-- 4. Tambahkan kolom keterangan_ditolak
ALTER TABLE `peminjaman` 
ADD COLUMN `keterangan_ditolak` TEXT NULL COMMENT 'Alasan penolakan peminjaman' AFTER `status`;

-- Verifikasi struktur tabel
DESCRIBE `peminjaman`;

-- Jika ada error "Duplicate column name", berarti kolom sudah ada, skip saja query tersebut
