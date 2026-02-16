# Troubleshooting Guide

## Error: Unknown column 'keterangan_ditolak' in 'field list'

### Penyebab
Kolom `keterangan_ditolak` belum ditambahkan ke tabel `peminjaman` di database.

### Solusi

#### Cara 1: Menggunakan phpMyAdmin (RECOMMENDED)

1. Buka **phpMyAdmin**
2. Pilih database Anda
3. Klik tab **SQL**
4. Copy dan paste query berikut:

```sql
ALTER TABLE `peminjaman` 
ADD COLUMN `keterangan_ditolak` TEXT NULL COMMENT 'Alasan penolakan peminjaman' AFTER `status`;
```

5. Klik **Go** atau **Jalankan**
6. Refresh halaman aplikasi Anda

#### Cara 2: Jalankan Semua Update Sekaligus

Jika Anda ingin menambahkan semua kolom yang diperlukan sekaligus, jalankan file `FIX_DATABASE.sql`:

1. Buka file `FIX_DATABASE.sql`
2. Copy semua isinya
3. Paste di phpMyAdmin > SQL tab
4. Klik **Go**

#### Cara 3: Menggunakan Migration (Advanced)

```bash
php spark migrate
```

### Verifikasi

Setelah menjalankan query, verifikasi dengan:

```sql
DESCRIBE `peminjaman`;
```

Pastikan kolom berikut ada:
- ✅ `durasi_pinjam` (INT)
- ✅ `tanggal_jatuh_tempo` (DATE)
- ✅ `denda` (DECIMAL)
- ✅ `keterangan_ditolak` (TEXT)

---

## Error: Form Refresh Saat Submit

### Penyebab
1. Kolom database belum ditambahkan
2. JavaScript validation error
3. Form action URL salah

### Solusi

1. **Cek Console Browser**
   - Tekan F12
   - Lihat tab Console
   - Cek apakah ada error JavaScript

2. **Cek Network Tab**
   - Tekan F12
   - Klik tab Network
   - Submit form
   - Lihat response dari server

3. **Pastikan Database Sudah Update**
   - Jalankan `FIX_DATABASE.sql`
   - Verifikasi dengan `DESCRIBE peminjaman`

4. **Clear Cache Browser**
   - Tekan Ctrl + Shift + Delete
   - Clear cache dan cookies
   - Refresh halaman

---

## Error: Soft Delete Tidak Berfungsi

### Penyebab
Kolom `deleted_at` belum ada di tabel `alat`.

### Solusi

```sql
ALTER TABLE `alat` 
ADD COLUMN `deleted_at` DATETIME NULL COMMENT 'Tanggal dihapus (soft delete)' AFTER `updated_at`;
```

Jika kolom `created_at` dan `updated_at` juga belum ada:

```sql
ALTER TABLE `alat` 
ADD COLUMN `created_at` DATETIME NULL AFTER `status`,
ADD COLUMN `updated_at` DATETIME NULL AFTER `created_at`,
ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;
```

---

## Checklist Database

Gunakan checklist ini untuk memastikan semua kolom sudah ada:

### Tabel: peminjaman

```sql
DESCRIBE `peminjaman`;
```

Kolom yang harus ada:
- [ ] id_peminjaman
- [ ] id_user
- [ ] id_alat
- [ ] jumlah
- [ ] durasi_pinjam ⭐ BARU
- [ ] tanggal_pinjam
- [ ] tanggal_jatuh_tempo ⭐ BARU
- [ ] tanggal_kembali
- [ ] denda ⭐ BARU
- [ ] status
- [ ] keterangan_ditolak ⭐ BARU

### Tabel: alat

```sql
DESCRIBE `alat`;
```

Kolom yang harus ada:
- [ ] id_alat
- [ ] nama_alat
- [ ] id_category
- [ ] harga_alat
- [ ] kondisi
- [ ] stok
- [ ] status
- [ ] created_at
- [ ] updated_at
- [ ] deleted_at ⭐ BARU (untuk trash)

### Tabel: activity_logs

```sql
DESCRIBE `activity_logs`;
```

Kolom yang harus ada:
- [ ] id_log
- [ ] user_id
- [ ] role_user
- [ ] activity
- [ ] reference_id
- [ ] ip_address
- [ ] created_at

---

## Quick Fix - Copy Paste Ini!

Jika Anda ingin cepat, copy paste semua query ini di phpMyAdmin:

```sql
-- Fix Peminjaman
ALTER TABLE `peminjaman` ADD COLUMN `durasi_pinjam` INT(11) NULL AFTER `jumlah`;
ALTER TABLE `peminjaman` ADD COLUMN `tanggal_jatuh_tempo` DATE NULL AFTER `tanggal_pinjam`;
ALTER TABLE `peminjaman` ADD COLUMN `denda` DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER `tanggal_kembali`;
ALTER TABLE `peminjaman` ADD COLUMN `keterangan_ditolak` TEXT NULL AFTER `status`;

-- Fix Alat (Soft Delete)
ALTER TABLE `alat` ADD COLUMN `deleted_at` DATETIME NULL AFTER `updated_at`;

-- Verifikasi
DESCRIBE `peminjaman`;
DESCRIBE `alat`;
```

**Note**: Jika ada error "Duplicate column name", abaikan saja (berarti kolom sudah ada).

---

## Masih Error?

Jika masih ada error setelah mengikuti panduan di atas:

1. **Screenshot Error**
   - Ambil screenshot error lengkap
   - Termasuk URL dan error message

2. **Cek Log**
   - Buka `writable/logs/log-[tanggal].log`
   - Lihat error terakhir

3. **Cek Database Connection**
   - Pastikan koneksi database aktif
   - Cek `app/Config/Database.php`

4. **Restart Server**
   - Restart Apache/Nginx
   - Restart MySQL
   - Clear cache aplikasi

---

## Kontak Support

Jika masih mengalami masalah, hubungi developer dengan informasi:
- Error message lengkap
- Screenshot
- Versi PHP dan MySQL
- Hasil dari `DESCRIBE peminjaman`
