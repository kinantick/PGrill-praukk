# Instalasi Fitur Baru

## Fitur yang Ditambahkan

1. ✅ **Durasi Peminjaman & Sistem Denda**
2. ✅ **Keterangan Penolakan Peminjaman**
3. ✅ **Trash/Recycle Bin untuk Alat**
4. ✅ **Activity Log**

---

## Langkah Instalasi

### Step 1: Update Database

**PENTING**: Jalankan SQL ini di phpMyAdmin atau database client Anda.

#### Opsi A: Quick Install (Recommended)

Buka phpMyAdmin, pilih database Anda, lalu jalankan:

```sql
-- Update Tabel Peminjaman
ALTER TABLE `peminjaman` ADD COLUMN `durasi_pinjam` INT(11) NULL COMMENT 'Durasi peminjaman dalam hari' AFTER `jumlah`;
ALTER TABLE `peminjaman` ADD COLUMN `tanggal_jatuh_tempo` DATE NULL COMMENT 'Tanggal jatuh tempo pengembalian' AFTER `tanggal_pinjam`;
ALTER TABLE `peminjaman` ADD COLUMN `denda` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT 'Denda keterlambatan' AFTER `tanggal_kembali`;
ALTER TABLE `peminjaman` ADD COLUMN `keterangan_ditolak` TEXT NULL COMMENT 'Alasan penolakan peminjaman' AFTER `status`;

-- Update Tabel Alat (Soft Delete)
ALTER TABLE `alat` ADD COLUMN `deleted_at` DATETIME NULL COMMENT 'Tanggal dihapus (soft delete)' AFTER `updated_at`;

-- Buat Tabel Activity Logs (jika belum ada)
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
```

#### Opsi B: Menggunakan File SQL

Jalankan file-file SQL berikut secara berurutan:

1. `activity_logs.sql` - Untuk activity log
2. `peminjaman_update_complete.sql` - Untuk durasi & denda
3. `alat_soft_delete.sql` - Untuk trash

---

### Step 2: Verifikasi Database

Jalankan query berikut untuk memastikan semua kolom sudah ada:

```sql
-- Cek Tabel Peminjaman
DESCRIBE `peminjaman`;

-- Cek Tabel Alat
DESCRIBE `alat`;

-- Cek Tabel Activity Logs
DESCRIBE `activity_logs`;
```

**Hasil yang diharapkan:**

**Tabel peminjaman** harus memiliki kolom:
- durasi_pinjam
- tanggal_jatuh_tempo
- denda
- keterangan_ditolak

**Tabel alat** harus memiliki kolom:
- deleted_at

**Tabel activity_logs** harus ada dengan semua kolomnya.

---

### Step 3: Clear Cache (Opsional)

Jika menggunakan cache, clear cache aplikasi:

```bash
# Hapus cache CodeIgniter
rm -rf writable/cache/*

# Atau via browser
# Tekan Ctrl + Shift + Delete
# Clear cache dan cookies
```

---

### Step 4: Test Fitur

#### Test 1: Durasi Peminjaman & Denda

1. Login sebagai **Peminjam**
2. Klik **"Ajukan Peminjaman"**
3. Pilih alat, jumlah, dan **durasi** (misal: 7 hari)
4. Lihat tanggal jatuh tempo muncul otomatis
5. Submit form
6. Login sebagai **Petugas**
7. Setujui peminjaman
8. Login kembali sebagai **Peminjam**
9. Kembalikan alat (bisa lewat jatuh tempo untuk test denda)
10. Login sebagai **Petugas**
11. Cek pengembalian - lihat perhitungan denda

#### Test 2: Keterangan Penolakan

1. Login sebagai **Peminjam**
2. Ajukan peminjaman
3. Login sebagai **Petugas**
4. Buka peminjaman yang menunggu
5. Ubah status menjadi **"Ditolak"**
6. Form keterangan akan muncul
7. Isi keterangan penolakan
8. Submit

#### Test 3: Trash Alat

1. Login sebagai **Admin**
2. Buka halaman **Alat**
3. Klik tombol **"Trash"** di header
4. Hapus sebuah alat (akan masuk trash)
5. Buka **Trash**
6. Test **Restore** (kembalikan alat)
7. Test **Hapus Permanen**
8. Test **Kosongkan Trash**

#### Test 4: Activity Log

1. Login sebagai **Admin**
2. Klik menu **"Activity Log"**
3. Lihat semua aktivitas tercatat
4. Test filter berdasarkan:
   - Keyword
   - Role
   - Tanggal

---

## Troubleshooting

### Error: Unknown column 'keterangan_ditolak'

**Solusi**: Jalankan SQL berikut:

```sql
ALTER TABLE `peminjaman` 
ADD COLUMN `keterangan_ditolak` TEXT NULL AFTER `status`;
```

### Error: Unknown column 'deleted_at'

**Solusi**: Jalankan SQL berikut:

```sql
ALTER TABLE `alat` 
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;
```

### Error: Table 'activity_logs' doesn't exist

**Solusi**: Jalankan file `activity_logs.sql`

### Form Tidak Submit / Refresh

**Solusi**:
1. Clear browser cache (Ctrl + Shift + Delete)
2. Pastikan semua kolom database sudah ditambahkan
3. Cek console browser (F12) untuk error JavaScript

---

## File SQL yang Tersedia

1. **FIX_DATABASE.sql** - Fix semua masalah database sekaligus ⭐ RECOMMENDED
2. **peminjaman_update_complete.sql** - Update tabel peminjaman
3. **peminjaman_keterangan_ditolak.sql** - Tambah kolom keterangan
4. **peminjaman_durasi_denda.sql** - Tambah kolom durasi & denda
5. **alat_soft_delete.sql** - Tambah soft delete untuk alat
6. **activity_logs.sql** - Buat tabel activity logs

---

## Dokumentasi Lengkap

- **TROUBLESHOOTING.md** - Panduan mengatasi error
- **ACTIVITY_LOG_README.md** - Dokumentasi activity log
- **DURASI_DENDA_README.md** - Dokumentasi durasi & denda

---

## Fitur Tambahan

### Konfigurasi Denda

Untuk mengubah tarif denda, edit file:
`app/Controllers/PeminjamanController.php`

Cari baris:
```php
$denda = $hari_terlambat * 10000; // Rp 10.000 per hari
```

Ubah nilai `10000` sesuai kebutuhan.

### Konfigurasi Durasi

Untuk menambah/mengubah pilihan durasi, edit file:
`app/Views/peminjaman/create.php`

Cari bagian:
```html
<select name="durasi_pinjam" id="durasi_pinjam" class="form-select" required>
    <option value="1">1 Hari</option>
    <option value="3">3 Hari</option>
    <!-- Tambahkan opsi baru di sini -->
</select>
```

---

## Checklist Instalasi

- [ ] Database sudah diupdate (jalankan FIX_DATABASE.sql)
- [ ] Verifikasi struktur tabel (DESCRIBE peminjaman, alat, activity_logs)
- [ ] Clear cache browser
- [ ] Test durasi peminjaman
- [ ] Test keterangan penolakan
- [ ] Test trash alat
- [ ] Test activity log
- [ ] Semua fitur berfungsi normal

---

## Support

Jika mengalami masalah:
1. Baca **TROUBLESHOOTING.md**
2. Cek log error di `writable/logs/`
3. Verifikasi database dengan `DESCRIBE` command
4. Screenshot error dan hubungi developer

---

**Selamat! Semua fitur baru sudah terinstal.** 🎉
