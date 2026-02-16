-- SQL untuk membuat tabel activity_log
-- Jalankan query ini di database Anda jika belum ada tabel activity_log

CREATE TABLE IF NOT EXISTS `activity_log` (
  `id_log` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `role_user` varchar(50) DEFAULT NULL,
  `activity` text NOT NULL,
  `reference_id` int(11) UNSIGNED DEFAULT NULL,
  `ip_addres` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id_log`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
