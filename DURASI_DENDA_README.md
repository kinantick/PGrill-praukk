# Fitur Durasi Peminjaman & Sistem Denda

## Deskripsi
Fitur ini menambahkan sistem durasi peminjaman dan denda otomatis untuk keterlambatan pengembalian alat. Sistem akan menghitung denda secara otomatis berdasarkan jumlah hari keterlambatan.

## Fitur Utama

### 1. **Durasi Peminjaman**
Peminjam dapat memilih durasi peminjaman saat mengajukan peminjaman:
- 1 Hari
- 3 Hari
- 7 Hari (1 Minggu)
- 14 Hari (2 Minggu)
- 30 Hari (1 Bulan)

### 2. **Tanggal Jatuh Tempo**
- Dihitung otomatis berdasarkan tanggal pinjam + durasi
- Ditampilkan secara real-time di form peminjaman
- Menjadi acuan untuk perhitungan denda

### 3. **Sistem Denda Otomatis**
- **Tarif Denda**: Rp 10.000 per hari
- Denda dihitung otomatis saat petugas memvalidasi pengembalian
- Hanya dikenakan jika tanggal kembali > tanggal jatuh tempo

## Instalasi Database

### Opsi 1: Menggunakan Migration
```bash
php spark migrate
```

### Opsi 2: Menggunakan SQL Manual
Jalankan file `peminjaman_durasi_denda.sql` di database Anda:

```sql
ALTER TABLE `peminjaman` 
ADD COLUMN `durasi_pinjam` INT(11) NULL COMMENT 'Durasi peminjaman dalam hari' AFTER `jumlah`,
ADD COLUMN `tanggal_jatuh_tempo` DATE NULL COMMENT 'Tanggal jatuh tempo pengembalian' AFTER `tanggal_pinjam`,
ADD COLUMN `denda` DECIMAL(10,2) NOT NULL DEFAULT 0 COMMENT 'Denda keterlambatan' AFTER `tanggal_kembali`;
```

## Cara Menggunakan

### A. Untuk Peminjam

#### 1. Mengajukan Peminjaman
1. Login sebagai Peminjam
2. Klik **"Ajukan Peminjaman"**
3. Isi form:
   - Pilih alat yang ingin dipinjam
   - Masukkan jumlah
   - **Pilih durasi peminjaman** (wajib)
   - Pilih tanggal pinjam
4. Sistem akan menampilkan tanggal jatuh tempo secara otomatis
5. Klik **"Ajukan Peminjaman"**

#### 2. Mengembalikan Alat
1. Buka halaman **"Peminjaman Saya"**
2. Cari peminjaman dengan status **"Disetujui"**
3. Klik tombol **"Kembalikan"**
4. Sistem akan mencatat tanggal pengembalian

**Perhatian**: Pastikan mengembalikan sebelum tanggal jatuh tempo untuk menghindari denda!

### B. Untuk Petugas

#### 1. Menyetujui Peminjaman
1. Login sebagai Petugas
2. Buka halaman **"Peminjaman"**
3. Klik **"Proses"** pada peminjaman dengan status **"Menunggu"**
4. Ubah status menjadi **"Disetujui"** atau **"Ditolak"**

#### 2. Validasi Pengembalian
1. Buka halaman **"Peminjaman"**
2. Cari peminjaman dengan status **"Dikembalikan"**
3. Klik tombol **"Cek"**
4. Sistem akan menampilkan:
   - Informasi peminjaman lengkap
   - Tanggal pinjam, jatuh tempo, dan kembali
   - **Perhitungan denda otomatis** (jika terlambat)
5. Klik **"Validasi & Selesaikan"**
6. Denda akan tersimpan otomatis

## Perhitungan Denda

### Formula:
```
Denda = Hari Terlambat × Rp 10.000
```

### Contoh Perhitungan:

**Kasus 1: Tepat Waktu**
- Tanggal Pinjam: 1 Februari 2026
- Durasi: 7 hari
- Jatuh Tempo: 8 Februari 2026
- Tanggal Kembali: 7 Februari 2026
- **Denda: Rp 0** ✅

**Kasus 2: Terlambat 3 Hari**
- Tanggal Pinjam: 1 Februari 2026
- Durasi: 7 hari
- Jatuh Tempo: 8 Februari 2026
- Tanggal Kembali: 11 Februari 2026
- Hari Terlambat: 3 hari
- **Denda: 3 × Rp 10.000 = Rp 30.000** ⚠️

**Kasus 3: Terlambat 10 Hari**
- Tanggal Pinjam: 1 Februari 2026
- Durasi: 14 hari
- Jatuh Tempo: 15 Februari 2026
- Tanggal Kembali: 25 Februari 2026
- Hari Terlambat: 10 hari
- **Denda: 10 × Rp 10.000 = Rp 100.000** ❌

## Tampilan Fitur

### 1. Form Peminjaman
- Dropdown durasi peminjaman
- Auto-calculate tanggal jatuh tempo
- Info denda yang jelas

### 2. Tabel Peminjaman
Kolom tambahan:
- **Durasi**: Menampilkan durasi peminjaman (hari)
- **Jatuh Tempo**: Tanggal maksimal pengembalian
- **Denda**: Total denda (jika ada)
- Badge **"Lewat!"** untuk peminjaman yang melewati jatuh tempo

### 3. Halaman Validasi Pengembalian
- Informasi lengkap peminjaman
- Perhitungan denda otomatis
- Alert merah jika ada keterlambatan
- Alert hijau jika tepat waktu

## Perubahan File

### Controllers
- `app/Controllers/PeminjamanController.php`
  - Method `store()`: Menyimpan durasi dan menghitung jatuh tempo
  - Method `selesai()`: Menghitung dan menyimpan denda

### Models
- `app/Models/PeminjamanModel.php`
  - Menambahkan field: `durasi_pinjam`, `tanggal_jatuh_tempo`, `denda`

### Views
- `app/Views/peminjaman/create.php`: Form dengan durasi dan auto-calculate
- `app/Views/peminjaman/index.php`: Tabel dengan kolom durasi, jatuh tempo, denda
- `app/Views/peminjaman/kembalikan.php`: Halaman validasi dengan perhitungan denda

### Database
- Migration: `2024-01-02-000000_AddDurasiAndDendaToPeminjaman.php`
- SQL Manual: `peminjaman_durasi_denda.sql`

## Tips & Best Practices

### Untuk Peminjam:
1. ✅ Pilih durasi yang sesuai dengan kebutuhan
2. ✅ Catat tanggal jatuh tempo
3. ✅ Kembalikan alat sebelum jatuh tempo
4. ✅ Hubungi petugas jika ada kendala

### Untuk Petugas:
1. ✅ Verifikasi kondisi alat saat pengembalian
2. ✅ Cek perhitungan denda sebelum validasi
3. ✅ Informasikan denda kepada peminjam
4. ✅ Pastikan pembayaran denda (jika ada)

### Untuk Admin:
1. ✅ Monitor peminjaman yang lewat jatuh tempo
2. ✅ Review laporan denda secara berkala
3. ✅ Sesuaikan tarif denda jika diperlukan

## Konfigurasi Tarif Denda

Untuk mengubah tarif denda, edit file:
`app/Controllers/PeminjamanController.php`

Cari baris:
```php
$denda = $hari_terlambat * 10000; // Rp 10.000 per hari
```

Ubah nilai `10000` sesuai kebutuhan.

## Activity Log

Semua aktivitas terkait durasi dan denda tercatat di Activity Log:
- Pengajuan peminjaman dengan durasi
- Pengembalian alat
- Validasi dengan informasi denda

## Troubleshooting

### Tanggal jatuh tempo tidak muncul
- Pastikan JavaScript aktif di browser
- Pilih durasi peminjaman terlebih dahulu
- Refresh halaman jika perlu

### Denda tidak terhitung
- Pastikan kolom database sudah ditambahkan
- Cek tanggal jatuh tempo sudah tersimpan
- Verifikasi tanggal kembali sudah diisi

### Error saat submit form
- Pastikan semua field wajib terisi
- Cek durasi peminjaman sudah dipilih
- Verifikasi tanggal pinjam valid

## Fitur Mendatang (Opsional)

- [ ] Notifikasi email sebelum jatuh tempo
- [ ] Dashboard statistik denda
- [ ] Laporan denda per periode
- [ ] Sistem pembayaran denda online
- [ ] Reminder otomatis untuk peminjam
- [ ] Tarif denda progresif (meningkat per minggu)

## Lisensi
Fitur ini adalah bagian dari Sistem Peminjaman Alat.
