<?php
/**
 * Script untuk mengecek dan menambahkan kolom yang diperlukan
 * Jalankan file ini di browser: http://localhost/your-project/check_and_update_database.php
 * Atau jalankan via CLI: php check_and_update_database.php
 */

// Load CodeIgniter
require __DIR__ . '/vendor/autoload.php';

// Bootstrap CodeIgniter
$app = require_once FCPATH . '../app/Config/Paths.php';
$app = new \CodeIgniter\CodeIgniter($app);
$app->initialize();

$db = \Config\Database::connect();

echo "<h2>Checking Database Structure...</h2>";
echo "<pre>";

// Fungsi untuk cek apakah kolom ada
function columnExists($db, $table, $column) {
    $query = $db->query("SHOW COLUMNS FROM `{$table}` LIKE '{$column}'");
    return $query->getNumRows() > 0;
}

// Fungsi untuk menambahkan kolom
function addColumn($db, $table, $column, $definition, $after = null) {
    try {
        $sql = "ALTER TABLE `{$table}` ADD COLUMN `{$column}` {$definition}";
        if ($after) {
            $sql .= " AFTER `{$after}`";
        }
        $db->query($sql);
        echo "✓ Kolom '{$column}' berhasil ditambahkan ke tabel '{$table}'\n";
        return true;
    } catch (\Exception $e) {
        echo "✗ Error menambahkan kolom '{$column}': " . $e->getMessage() . "\n";
        return false;
    }
}

echo "=== TABEL PEMINJAMAN ===\n\n";

// Cek dan tambahkan kolom di tabel peminjaman
$columns = [
    'durasi_pinjam' => [
        'definition' => "INT(11) NULL COMMENT 'Durasi peminjaman dalam hari'",
        'after' => 'jumlah'
    ],
    'tanggal_jatuh_tempo' => [
        'definition' => "DATE NULL COMMENT 'Tanggal jatuh tempo pengembalian'",
        'after' => 'tanggal_pinjam'
    ],
    'denda' => [
        'definition' => "DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT 'Denda keterlambatan'",
        'after' => 'tanggal_kembali'
    ],
    'keterangan_ditolak' => [
        'definition' => "TEXT NULL COMMENT 'Alasan penolakan peminjaman'",
        'after' => 'status'
    ]
];

foreach ($columns as $column => $config) {
    if (columnExists($db, 'peminjaman', $column)) {
        echo "✓ Kolom '{$column}' sudah ada\n";
    } else {
        echo "⚠ Kolom '{$column}' belum ada, menambahkan...\n";
        addColumn($db, 'peminjaman', $column, $config['definition'], $config['after']);
    }
}

echo "\n=== TABEL ALAT ===\n\n";

// Cek kolom deleted_at untuk soft delete
$alatColumns = [
    'created_at' => [
        'definition' => "DATETIME NULL",
        'after' => 'status'
    ],
    'updated_at' => [
        'definition' => "DATETIME NULL",
        'after' => 'created_at'
    ],
    'deleted_at' => [
        'definition' => "DATETIME NULL COMMENT 'Tanggal dihapus (soft delete)'",
        'after' => 'updated_at'
    ]
];

foreach ($alatColumns as $column => $config) {
    if (columnExists($db, 'alat', $column)) {
        echo "✓ Kolom '{$column}' sudah ada\n";
    } else {
        echo "⚠ Kolom '{$column}' belum ada, menambahkan...\n";
        addColumn($db, 'alat', $column, $config['definition'], $config['after']);
    }
}

echo "\n=== SELESAI ===\n";
echo "Database berhasil diupdate!\n";
echo "</pre>";

echo "<h3>Struktur Tabel Peminjaman:</h3>";
echo "<pre>";
$result = $db->query("DESCRIBE peminjaman");
foreach ($result->getResultArray() as $row) {
    echo sprintf("%-25s %-20s %-10s\n", $row['Field'], $row['Type'], $row['Null']);
}
echo "</pre>";

echo "<h3>Struktur Tabel Alat:</h3>";
echo "<pre>";
$result = $db->query("DESCRIBE alat");
foreach ($result->getResultArray() as $row) {
    echo sprintf("%-25s %-20s %-10s\n", $row['Field'], $row['Type'], $row['Null']);
}
echo "</pre>";
