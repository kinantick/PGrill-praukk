# Fitur Cetak Laporan Pengembalian Peminjaman

## Deskripsi
Fitur ini memungkinkan petugas untuk mencetak laporan pengembalian peminjaman alat dalam format yang rapi dan profesional.

## Fitur Utama

### 1. Laporan Print-Friendly
- Layout khusus untuk pencetakan
- Kop surat dengan informasi sistem
- Format yang rapi dan profesional

### 2. Informasi Lengkap
- Nomor peminjaman
- Data peminjam (nama, email)
- Detail alat (nama, kategori, jumlah)
- Informasi waktu (tanggal pinjam, durasi, jatuh tempo, tanggal kembali)

### 3. Perhitungan Denda Otomatis
- Menampilkan status keterlambatan
- Perhitungan hari terlambat
- Total denda (Rp 10.000 per hari)
- Badge "Tepat Waktu" jika tidak ada keterlambatan

### 4. Tanda Tangan
- Area tanda tangan peminjam
- Area tanda tangan petugas
- Timestamp pencetakan laporan

## Cara Menggunakan

### Untuk Petugas:

1. Buka halaman **Peminjaman**
2. Klik tombol **Cek Pengembalian** pada peminjaman dengan status "Dikembalikan"
3. Klik tombol **Cetak Laporan** (biru)
4. Laporan akan terbuka di tab baru
5. Klik tombol **Cetak Laporan** di halaman atau gunakan Ctrl+P
6. Pilih printer dan cetak

## File yang Dimodifikasi

### 1. Controller
- `app/Controllers/PeminjamanController.php`
  - Method baru: `cetakLaporan($id)`
  - Mengambil data peminjaman lengkap dengan join
  - Menghitung denda otomatis
  - Validasi hanya petugas yang bisa akses

### 2. View
- `app/Views/peminjaman/cetak_laporan.php` (BARU)
  - Layout print-friendly dengan CSS khusus
  - Kop surat profesional
  - Informasi lengkap peminjaman
  - Perhitungan denda
  - Area tanda tangan

- `app/Views/peminjaman/kembalikan.php`
  - Tambah tombol "Cetak Laporan"
  - Tombol membuka laporan di tab baru

### 3. Routes
- `app/Config/Routes.php`
  - Route baru: `GET /peminjaman/cetak-laporan/(:num)`
  - Hanya bisa diakses oleh petugas

## Fitur CSS Print

```css
@media print {
    .no-print {
        display: none !important;
    }
}
```

Tombol cetak dan navigasi akan otomatis hilang saat dicetak.

## Contoh Tampilan Laporan

```
========================================
    SISTEM PEMINJAMAN ALAT
    Jl. Contoh No. 123, Kota
========================================

LAPORAN PENGEMBALIAN PEMINJAMAN ALAT

No. Peminjaman    : 00001
Nama Peminjam     : John Doe
Email             : john@example.com

Detail Alat
Nama Alat         : Laptop Dell
Kategori          : Elektronik
Jumlah Dipinjam   : 1 unit

Informasi Waktu
Tanggal Peminjaman    : 01 Januari 2026
Durasi Peminjaman     : 7 hari
Tanggal Jatuh Tempo   : 08 Januari 2026
Tanggal Pengembalian  : 10 Januari 2026

⚠️ KETERLAMBATAN PENGEMBALIAN
Hari Terlambat    : 2 hari
Denda per Hari    : Rp 10.000
Total Denda       : Rp 20.000

Peminjam,                    Petugas,
[Tanda Tangan]              [Tanda Tangan]
John Doe                    ( _________ )
```

## Keamanan
- Hanya petugas yang bisa mengakses fitur cetak
- Validasi status peminjaman (harus "Dikembalikan")
- Redirect otomatis jika akses tidak valid

## Tips
- Gunakan browser Chrome/Edge untuk hasil cetak terbaik
- Pilih orientasi Portrait saat mencetak
- Nonaktifkan header/footer browser untuk hasil lebih bersih
- Simpan sebagai PDF jika ingin arsip digital

## Troubleshooting

### Tombol cetak tidak muncul
- Pastikan status peminjaman adalah "Dikembalikan"
- Pastikan login sebagai petugas

### Laporan tidak bisa dibuka
- Cek apakah route sudah ditambahkan di Routes.php
- Pastikan method cetakLaporan ada di PeminjamanController

### Denda tidak muncul
- Pastikan kolom `tanggal_kembali` dan `tanggal_jatuh_tempo` terisi
- Cek perhitungan di controller

---

Fitur ini dibuat untuk mempermudah dokumentasi pengembalian peminjaman alat dengan format yang profesional dan siap cetak.
