-- SQL untuk menambahkan kolom durasi_pinjam, tanggal_jatuh_tempo, dan denda
-- Jalankan query ini di database Anda

ALTER TABLE `peminjaman` 
ADD COLUMN `durasi_pinjam` INT(11) NULL COMMENT 'Durasi peminjaman dalam hari' AFTER `jumlah`,
ADD COLUMN `tanggal_jatuh_tempo` DATE NULL COMMENT 'Tanggal jatuh tempo pengembalian' AFTER `tanggal_pinjam`,
ADD COLUMN `denda` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT 'Denda keterlambatan' AFTER `tanggal_kembali`;
