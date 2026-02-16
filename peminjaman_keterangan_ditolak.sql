-- SQL untuk menambahkan kolom keterangan_ditolak
-- Jalankan query ini di database Anda

ALTER TABLE `peminjaman` 
ADD COLUMN `keterangan_ditolak` TEXT NULL COMMENT 'Alasan penolakan peminjaman' AFTER `status`;
