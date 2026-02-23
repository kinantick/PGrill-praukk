<?php
/**
 * Script untuk memperbaiki database secara otomatis
 * Jalankan file ini di browser: http://localhost/your-project/fix_database_auto.php
 */

// Load CodeIgniter
require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap CodeIgniter
$app = require_once FCPATH . '../app/Config/Paths.php';
$app = new \CodeIgniter\Config\DotEnv(ROOTPATH);
$app->load();

// Load database
$db = \Config\Database::connect();

echo "<h1>Fix Database - Automatic</h1>";
echo "<pre>";

$errors = [];
$success = [];

// ============================================
// 1. FIX TABEL USER
// ============================================
echo "\n=== CHECKING TABLE: user ===\n";

try {
    // Cek apakah tabel user ada
    if (!$db->tableExists('user')) {
        echo "❌ Tabel 'user' tidak ditemukan!\n";
        echo "   Membuat tabel user...\n";
        
        $forge = \Config\Database::forge();
        $forge->addField([
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'role_user' => [
                'type'       => 'ENUM',
                'constraint' => ['Admin', 'Petugas', 'Peminjam'],
                'default'    => 'Peminjam',
            ],
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $forge->addKey('id_user', true);
        $forge->addUniqueKey('email');
        $forge->createTable('user');
        
        // Insert admin default
        $db->table('user')->insert([
            'nama'     => 'Administrator',
            'email'    => 'admin@example.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role_user' => 'Admin',
        ]);
        
        $success[] = "✅ Tabel 'user' berhasil dibuat dengan admin default";
        echo "✅ Tabel 'user' berhasil dibuat\n";
        echo "   Login: admin@example.com / admin123\n";
    } else {
        echo "✅ Tabel 'user' ditemukan\n";
        
        // Cek struktur kolom
        $fields = $db->getFieldNames('user');
        echo "   Kolom yang ada: " . implode(', ', $fields) . "\n";
        
        // Cek apakah primary key bernama id_user
        if (!in_array('id_user', $fields)) {
            echo "⚠️  Kolom 'id_user' tidak ditemukan!\n";
            
            // Cek kemungkinan nama lain
            if (in_array('id', $fields)) {
                echo "   Menemukan kolom 'id', akan di-rename ke 'id_user'...\n";
                $db->query("ALTER TABLE `user` CHANGE `id` `id_user` int(11) UNSIGNED NOT NULL AUTO_INCREMENT");
                $success[] = "✅ Kolom 'id' berhasil di-rename ke 'id_user'";
                echo "✅ Berhasil rename 'id' -> 'id_user'\n";
            } elseif (in_array('user_id', $fields)) {
                echo "   Menemukan kolom 'user_id', akan di-rename ke 'id_user'...\n";
                $db->query("ALTER TABLE `user` CHANGE `user_id` `id_user` int(11) UNSIGNED NOT NULL AUTO_INCREMENT");
                $success[] = "✅ Kolom 'user_id' berhasil di-rename ke 'id_user'";
                echo "✅ Berhasil rename 'user_id' -> 'id_user'\n";
            } else {
                $errors[] = "❌ Tidak dapat menemukan primary key untuk di-rename";
                echo "❌ Tidak dapat menemukan primary key\n";
            }
        } else {
            echo "✅ Kolom 'id_user' sudah ada\n";
        }
    }
} catch (\Exception $e) {
    $errors[] = "❌ Error pada tabel user: " . $e->getMessage();
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// ============================================
// 2. FIX TABEL PEMINJAMAN
// ============================================
echo "\n=== CHECKING TABLE: peminjaman ===\n";

try {
    if ($db->tableExists('peminjaman')) {
        $fields = $db->getFieldNames('peminjaman');
        
        // Tambah durasi_pinjam
        if (!in_array('durasi_pinjam', $fields)) {
            $db->query("ALTER TABLE `peminjaman` ADD COLUMN `durasi_pinjam` INT(11) NULL COMMENT 'Durasi peminjaman dalam hari' AFTER `jumlah`");
            $success[] = "✅ Kolom 'durasi_pinjam' ditambahkan";
            echo "✅ Kolom 'durasi_pinjam' ditambahkan\n";
        } else {
            echo "✅ Kolom 'durasi_pinjam' sudah ada\n";
        }
        
        // Tambah tanggal_jatuh_tempo
        if (!in_array('tanggal_jatuh_tempo', $fields)) {
            $db->query("ALTER TABLE `peminjaman` ADD COLUMN `tanggal_jatuh_tempo` DATE NULL COMMENT 'Tanggal jatuh tempo pengembalian' AFTER `tanggal_pinjam`");
            $success[] = "✅ Kolom 'tanggal_jatuh_tempo' ditambahkan";
            echo "✅ Kolom 'tanggal_jatuh_tempo' ditambahkan\n";
        } else {
            echo "✅ Kolom 'tanggal_jatuh_tempo' sudah ada\n";
        }
        
        // Tambah denda
        if (!in_array('denda', $fields)) {
            $db->query("ALTER TABLE `peminjaman` ADD COLUMN `denda` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT 'Denda keterlambatan' AFTER `tanggal_kembali`");
            $success[] = "✅ Kolom 'denda' ditambahkan";
            echo "✅ Kolom 'denda' ditambahkan\n";
        } else {
            echo "✅ Kolom 'denda' sudah ada\n";
        }
        
        // Tambah keterangan_ditolak
        if (!in_array('keterangan_ditolak', $fields)) {
            $db->query("ALTER TABLE `peminjaman` ADD COLUMN `keterangan_ditolak` TEXT NULL COMMENT 'Alasan penolakan peminjaman' AFTER `status`");
            $success[] = "✅ Kolom 'keterangan_ditolak' ditambahkan";
            echo "✅ Kolom 'keterangan_ditolak' ditambahkan\n";
        } else {
            echo "✅ Kolom 'keterangan_ditolak' sudah ada\n";
        }
    } else {
        echo "⚠️  Tabel 'peminjaman' tidak ditemukan\n";
    }
} catch (\Exception $e) {
    $errors[] = "❌ Error pada tabel peminjaman: " . $e->getMessage();
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// ============================================
// 2.1. FIX INVALID DATES IN PEMINJAMAN
// ============================================
echo "\n=== FIXING INVALID DATES IN PEMINJAMAN ===\n";

try {
    if ($db->tableExists('peminjaman')) {
        // Fix tanggal_kembali yang invalid
        $result = $db->query("UPDATE `peminjaman` SET `tanggal_kembali` = NULL WHERE `tanggal_kembali` = '0000-00-00' OR `tanggal_kembali` = '0000-00-00 00:00:00' OR `tanggal_kembali` < '1970-01-01'");
        $affected = $db->affectedRows();
        if ($affected > 0) {
            $success[] = "✅ {$affected} tanggal_kembali invalid diperbaiki";
            echo "✅ {$affected} tanggal_kembali invalid diperbaiki\n";
        } else {
            echo "✅ Tidak ada tanggal_kembali invalid\n";
        }
        
        // Fix tanggal_jatuh_tempo yang invalid
        $result = $db->query("UPDATE `peminjaman` SET `tanggal_jatuh_tempo` = NULL WHERE `tanggal_jatuh_tempo` = '0000-00-00' OR `tanggal_jatuh_tempo` = '0000-00-00 00:00:00' OR `tanggal_jatuh_tempo` < '1970-01-01'");
        $affected = $db->affectedRows();
        if ($affected > 0) {
            $success[] = "✅ {$affected} tanggal_jatuh_tempo invalid diperbaiki";
            echo "✅ {$affected} tanggal_jatuh_tempo invalid diperbaiki\n";
        } else {
            echo "✅ Tidak ada tanggal_jatuh_tempo invalid\n";
        }
    }
} catch (\Exception $e) {
    $errors[] = "❌ Error saat fix invalid dates: " . $e->getMessage();
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// ============================================
// 3. FIX TABEL ALAT
// ============================================
echo "\n=== CHECKING TABLE: alat ===\n";

try {
    if ($db->tableExists('alat')) {
        $fields = $db->getFieldNames('alat');
        
        // Tambah created_at
        if (!in_array('created_at', $fields)) {
            $db->query("ALTER TABLE `alat` ADD COLUMN `created_at` DATETIME NULL AFTER `status`");
            $success[] = "✅ Kolom 'created_at' ditambahkan ke tabel alat";
            echo "✅ Kolom 'created_at' ditambahkan\n";
        } else {
            echo "✅ Kolom 'created_at' sudah ada\n";
        }
        
        // Tambah updated_at
        if (!in_array('updated_at', $fields)) {
            $db->query("ALTER TABLE `alat` ADD COLUMN `updated_at` DATETIME NULL AFTER `created_at`");
            $success[] = "✅ Kolom 'updated_at' ditambahkan ke tabel alat";
            echo "✅ Kolom 'updated_at' ditambahkan\n";
        } else {
            echo "✅ Kolom 'updated_at' sudah ada\n";
        }
        
        // Tambah deleted_at
        if (!in_array('deleted_at', $fields)) {
            $db->query("ALTER TABLE `alat` ADD COLUMN `deleted_at` DATETIME NULL COMMENT 'Tanggal dihapus (soft delete)' AFTER `updated_at`");
            $success[] = "✅ Kolom 'deleted_at' ditambahkan ke tabel alat";
            echo "✅ Kolom 'deleted_at' ditambahkan\n";
        } else {
            echo "✅ Kolom 'deleted_at' sudah ada\n";
        }
    } else {
        echo "⚠️  Tabel 'alat' tidak ditemukan\n";
    }
} catch (\Exception $e) {
    $errors[] = "❌ Error pada tabel alat: " . $e->getMessage();
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// ============================================
// 4. FIX TABEL ACTIVITY_LOGS
// ============================================
echo "\n=== CHECKING TABLE: activity_logs ===\n";

try {
    // Cek apakah tabel activity_log (singular) ada
    if ($db->tableExists('activity_log')) {
        echo "⚠️  Tabel 'activity_log' (singular) ditemukan\n";
        echo "   Rename ke 'activity_logs' (plural)...\n";
        $db->query("RENAME TABLE `activity_log` TO `activity_logs`");
        $success[] = "✅ Tabel 'activity_log' di-rename ke 'activity_logs'";
        echo "✅ Berhasil rename tabel\n";
    }
    
    if ($db->tableExists('activity_logs')) {
        echo "✅ Tabel 'activity_logs' ditemukan\n";
        
        $fields = $db->getFieldNames('activity_logs');
        
        // Cek kolom user_id
        if (!in_array('user_id', $fields) && in_array('id_user', $fields)) {
            echo "   Rename kolom 'id_user' ke 'user_id'...\n";
            $db->query("ALTER TABLE `activity_logs` CHANGE `id_user` `user_id` int(11) UNSIGNED NULL");
            $success[] = "✅ Kolom 'id_user' di-rename ke 'user_id'";
            echo "✅ Berhasil rename kolom\n";
        } else {
            echo "✅ Kolom 'user_id' sudah ada\n";
        }
        
        // Cek kolom ip_address
        if (!in_array('ip_address', $fields) && in_array('ip_addres', $fields)) {
            echo "   Perbaiki typo 'ip_addres' ke 'ip_address'...\n";
            $db->query("ALTER TABLE `activity_logs` CHANGE `ip_addres` `ip_address` varchar(45) NULL");
            $success[] = "✅ Kolom 'ip_addres' diperbaiki ke 'ip_address'";
            echo "✅ Berhasil perbaiki typo\n";
        } else {
            echo "✅ Kolom 'ip_address' sudah ada\n";
        }
    } else {
        echo "⚠️  Tabel 'activity_logs' tidak ditemukan\n";
        echo "   Membuat tabel activity_logs...\n";
        
        $db->query("
            CREATE TABLE `activity_logs` (
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
        
        $success[] = "✅ Tabel 'activity_logs' berhasil dibuat";
        echo "✅ Tabel 'activity_logs' berhasil dibuat\n";
    }
} catch (\Exception $e) {
    $errors[] = "❌ Error pada tabel activity_logs: " . $e->getMessage();
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// ============================================
// SUMMARY
// ============================================
echo "\n=== SUMMARY ===\n";

if (count($success) > 0) {
    echo "\n✅ BERHASIL (" . count($success) . "):\n";
    foreach ($success as $msg) {
        echo "   " . $msg . "\n";
    }
}

if (count($errors) > 0) {
    echo "\n❌ ERROR (" . count($errors) . "):\n";
    foreach ($errors as $msg) {
        echo "   " . $msg . "\n";
    }
}

if (count($errors) === 0) {
    echo "\n🎉 SEMUA PERBAIKAN BERHASIL!\n";
    echo "\nLangkah selanjutnya:\n";
    echo "1. Logout dan login ulang\n";
    echo "2. Clear cache browser (Ctrl + Shift + Delete)\n";
    echo "3. Test semua fitur (Profile, Activity Log, Peminjaman, Trash)\n";
    echo "4. Hapus file ini (fix_database_auto.php) setelah selesai\n";
} else {
    echo "\n⚠️  Ada beberapa error, silakan cek pesan di atas\n";
}

echo "\n</pre>";
echo "<p><a href='/'>← Kembali ke Aplikasi</a></p>";
?>
