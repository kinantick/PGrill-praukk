-- SQL untuk menambahkan soft delete ke tabel alat
-- Jalankan query ini di database Anda jika kolom deleted_at belum ada

-- Cek apakah kolom deleted_at sudah ada
-- Jika belum, jalankan query berikut:

ALTER TABLE `alat` 
ADD COLUMN `deleted_at` DATETIME NULL COMMENT 'Tanggal dihapus (soft delete)' AFTER `updated_at`;

-- Jika kolom created_at dan updated_at belum ada, tambahkan juga:
-- ALTER TABLE `alat` 
-- ADD COLUMN `created_at` DATETIME NULL AFTER `status`,
-- ADD COLUMN `updated_at` DATETIME NULL AFTER `created_at`,
-- ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;
