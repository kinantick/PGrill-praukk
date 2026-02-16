-- ============================================
-- FIX DATABASE - Jalankan di phpMyAdmin
-- ============================================
-- Copy dan paste query ini ke phpMyAdmin
-- Jalankan satu per satu atau sekaligus
-- ============================================

-- 1. CEK STRUKTUR TABEL PEMINJAMAN SAAT INI
DESCRIBE `peminjaman`;

-- 2. TAMBAHKAN KOLOM YANG DIPERLUKAN
-- Jika ada error "Duplicate column", skip query tersebut (berarti sudah ada)

-- Kolom durasi_pinjam
ALTER TABLE `peminjaman` 
ADD COLUMN `durasi_pinjam` INT(11) NULL COMMENT 'Durasi peminjaman dalam hari' AFTER `jumlah`;

-- Kolom tanggal_jatuh_tempo  
ALTER TABLE `peminjaman` 
ADD COLUMN `tanggal_jatuh_tempo` DATE NULL COMMENT 'Tanggal jatuh tempo pengembalian' AFTER `tanggal_pinjam`;

-- Kolom denda
ALTER TABLE `peminjaman` 
ADD COLUMN `denda` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT 'Denda keterlambatan' AFTER `tanggal_kembali`;

-- Kolom keterangan_ditolak (INI YANG PALING PENTING!)
ALTER TABLE `peminjaman` 
ADD COLUMN `keterangan_ditolak` TEXT NULL COMMENT 'Alasan penolakan peminjaman' AFTER `status`;

-- 3. VERIFIKASI HASIL
DESCRIBE `peminjaman`;

-- 4. UNTUK TABEL ALAT (SOFT DELETE)
-- Tambahkan kolom deleted_at jika belum ada

ALTER TABLE `alat` 
ADD COLUMN `deleted_at` DATETIME NULL COMMENT 'Tanggal dihapus (soft delete)' AFTER `updated_at`;

-- Jika kolom created_at dan updated_at belum ada, tambahkan:
-- ALTER TABLE `alat` 
-- ADD COLUMN `created_at` DATETIME NULL AFTER `status`,
-- ADD COLUMN `updated_at` DATETIME NULL AFTER `created_at`,
-- ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

-- 5. VERIFIKASI TABEL ALAT
DESCRIBE `alat`;

-- ============================================
-- SELESAI!
-- ============================================
