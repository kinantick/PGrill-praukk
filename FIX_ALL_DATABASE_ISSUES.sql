-- ============================================
-- FIX ALL DATABASE ISSUES
-- ============================================
-- File ini memperbaiki semua masalah database yang umum terjadi
-- Jalankan file ini di phpMyAdmin atau MySQL client
--
-- PENTING: Backup database Anda sebelum menjalankan query ini!
-- ============================================

-- ============================================
-- 1. FIX TABEL USER
-- ============================================
-- Cek dulu nama primary key dengan: DESCRIBE user;
-- Lalu uncomment salah satu baris di bawah sesuai kondisi:

-- Jika primary key bernama 'id':
-- ALTER TABLE `user` CHANGE `id` `id_user` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

-- Jika primary key bernama 'user_id':
-- ALTER TABLE `user` CHANGE `user_id` `id_user` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

-- Jika tabel user belum ada sama sekali, uncomment semua baris di bawah:
/*
CREATE TABLE `user` (
  `id_user` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_user` enum('Admin','Petugas','Peminjam') NOT NULL DEFAULT 'Peminjam',
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin (password: admin123)
INSERT INTO `user` (`nama`, `email`, `password`, `role_user`) VALUES
('Administrator', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin');
*/

-- ============================================
-- 2. FIX TABEL PEMINJAMAN
-- ============================================
-- Tambah kolom durasi_pinjam
ALTER TABLE `peminjaman` 
ADD COLUMN IF NOT EXISTS `durasi_pinjam` INT(11) NULL COMMENT 'Durasi peminjaman dalam hari' AFTER `jumlah`;

-- Tambah kolom tanggal_jatuh_tempo
ALTER TABLE `peminjaman` 
ADD COLUMN IF NOT EXISTS `tanggal_jatuh_tempo` DATE NULL COMMENT 'Tanggal jatuh tempo pengembalian' AFTER `tanggal_pinjam`;

-- Tambah kolom denda
ALTER TABLE `peminjaman` 
ADD COLUMN IF NOT EXISTS `denda` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT 'Denda keterlambatan' AFTER `tanggal_kembali`;

-- Tambah kolom keterangan_ditolak
ALTER TABLE `peminjaman` 
ADD COLUMN IF NOT EXISTS `keterangan_ditolak` TEXT NULL COMMENT 'Alasan penolakan peminjaman' AFTER `status`;

-- ============================================
-- 3. FIX TABEL ALAT (SOFT DELETE)
-- ============================================
-- Tambah kolom deleted_at untuk soft delete
ALTER TABLE `alat` 
ADD COLUMN IF NOT EXISTS `deleted_at` DATETIME NULL COMMENT 'Tanggal dihapus (soft delete)' AFTER `updated_at`;

-- Tambah created_at dan updated_at jika belum ada
ALTER TABLE `alat` 
ADD COLUMN IF NOT EXISTS `created_at` DATETIME NULL AFTER `status`;

ALTER TABLE `alat` 
ADD COLUMN IF NOT EXISTS `updated_at` DATETIME NULL AFTER `created_at`;

-- ============================================
-- 4. FIX TABEL ACTIVITY LOGS
-- ============================================
-- Rename tabel dari activity_log ke activity_logs (jika ada)
-- Uncomment baris di bawah jika tabel masih bernama activity_log:
-- RENAME TABLE `activity_log` TO `activity_logs`;

-- Perbaiki typo kolom ip_addres ke ip_address (jika ada)
-- Uncomment baris di bawah jika kolom masih bernama ip_addres:
-- ALTER TABLE `activity_logs` CHANGE `ip_addres` `ip_address` varchar(45) DEFAULT NULL;

-- Jika tabel activity_logs belum ada, uncomment semua baris di bawah:
/*
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id_log` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `role_user` varchar(50) DEFAULT NULL,
  `activity` text NOT NULL,
  `reference_id` int(11) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id_log`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
*/

-- ============================================
-- 5. VERIFIKASI
-- ============================================
-- Jalankan query di bawah untuk memastikan semua sudah benar:

-- DESCRIBE `user`;
-- DESCRIBE `peminjaman`;
-- DESCRIBE `alat`;
-- DESCRIBE `activity_logs`;

-- ============================================
-- CHECKLIST HASIL
-- ============================================
-- Tabel USER harus punya:
--   ✓ id_user (PRIMARY KEY)
--   ✓ nama, email, password, role_user, no_hp, alamat
--   ✓ created_at, updated_at
--
-- Tabel PEMINJAMAN harus punya:
--   ✓ durasi_pinjam
--   ✓ tanggal_jatuh_tempo
--   ✓ denda
--   ✓ keterangan_ditolak
--
-- Tabel ALAT harus punya:
--   ✓ created_at, updated_at, deleted_at
--
-- Tabel ACTIVITY_LOGS harus punya:
--   ✓ Nama tabel: activity_logs (plural)
--   ✓ Kolom: user_id, ip_address
--
-- ============================================
-- CATATAN
-- ============================================
-- 1. Jika ada error "Duplicate column name", abaikan (kolom sudah ada)
-- 2. Jika ada error "Table already exists", abaikan (tabel sudah ada)
-- 3. Setelah menjalankan query, logout dan login ulang
-- 4. Clear cache browser jika masih ada masalah
-- ============================================
