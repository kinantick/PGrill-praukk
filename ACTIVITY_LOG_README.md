# Fitur Activity Log

## Deskripsi
Fitur Activity Log memungkinkan Admin untuk memantau semua aktivitas yang dilakukan oleh user dalam sistem peminjaman alat. Setiap aksi penting akan tercatat secara otomatis dengan informasi lengkap.

## Fitur yang Tercatat

### 1. **Autentikasi**
- Login ke sistem
- Logout dari sistem

### 2. **Manajemen Alat**
- Menambahkan alat baru
- Mengupdate data alat
- Menghapus alat

### 3. **Manajemen User**
- Menambahkan user baru
- Mengupdate role user
- Menghapus user

### 4. **Peminjaman**
- Mengajukan peminjaman alat
- Menyetujui/menolak peminjaman
- Mengajukan pengembalian alat
- Menyelesaikan peminjaman

## Informasi yang Dicatat

Setiap log mencatat:
- **User ID**: ID user yang melakukan aktivitas
- **Role User**: Role user (Admin/Petugas/Peminjam)
- **Activity**: Deskripsi aktivitas yang dilakukan
- **Reference ID**: ID referensi (misal: id_alat, id_user, id_peminjaman)
- **IP Address**: Alamat IP user
- **Created At**: Waktu aktivitas dilakukan

## Cara Menggunakan

### 1. **Instalasi Database**

Jalankan migration atau SQL manual:

**Opsi 1: Menggunakan Migration**
```bash
php spark migrate
```

**Opsi 2: Menggunakan SQL Manual**
Jalankan file `activity_log.sql` di database Anda.

### 2. **Akses Activity Log**

- Login sebagai **Admin**
- Buka Dashboard Admin
- Klik tombol **"Activity Log"**
- Atau akses langsung: `http://your-domain/activity-log`

### 3. **Filter Activity Log**

Anda dapat memfilter log berdasarkan:
- **Keyword**: Cari berdasarkan aktivitas, nama user, atau email
- **Role**: Filter berdasarkan role (Admin/Petugas/Peminjam)
- **Tanggal**: Filter berdasarkan tanggal tertentu

### 4. **Hapus Log Lama**

Untuk menjaga performa database:
1. Klik tombol **"Clear Old Logs"**
2. Pilih periode (7, 30, 60, atau 90 hari)
3. Klik **"Hapus"**

Log yang lebih lama dari periode yang dipilih akan dihapus permanen.

## Struktur File

```
app/
├── Controllers/
│   └── ActivityLogController.php    # Controller untuk activity log
├── Models/
│   └── ActivityLogModel.php         # Model untuk activity log
├── Helpers/
│   └── activity_log_helper.php      # Helper function log_activity()
├── Views/
│   └── activity_log/
│       └── index.php                # View halaman activity log
└── Database/
    └── Migrations/
        └── 2024-01-01-000000_CreateActivityLogsTable.php
```

## Cara Menambahkan Log Baru

Jika Anda ingin menambahkan logging ke fitur baru, gunakan helper function `log_activity()`:

```php
// Contoh penggunaan
log_activity('Deskripsi aktivitas', $referenceId);

// Contoh konkret
log_activity('Menambahkan kategori baru: Elektronik', $categoryId);
log_activity('Mengupdate status peminjaman ID: 123', 123);
```

**Parameter:**
- `$activity` (string, required): Deskripsi aktivitas
- `$referenceId` (int, optional): ID referensi terkait

## Keamanan

- Hanya **Admin** yang dapat mengakses halaman Activity Log
- Menggunakan filter `role:Admin` di routes
- IP Address dicatat untuk audit trail
- Data tidak dapat diubah setelah tercatat

## Tips

1. **Maintenance Rutin**: Hapus log lama secara berkala untuk menjaga performa
2. **Monitoring**: Periksa log secara rutin untuk mendeteksi aktivitas mencurigakan
3. **Backup**: Backup log penting sebelum menghapus
4. **Filter**: Gunakan filter untuk menemukan aktivitas spesifik dengan cepat

## Troubleshooting

### Tabel tidak ditemukan
Pastikan Anda sudah menjalankan migration atau SQL manual untuk membuat tabel `activity_log`.

### Log tidak tercatat
Pastikan helper `activity_log` sudah di-load di `app/Config/Autoload.php`:
```php
public $helpers = ['activity_log'];
```

### Error saat akses halaman
Pastikan Anda login sebagai Admin. Hanya Admin yang memiliki akses ke halaman Activity Log.

## Contoh Output Log

```
Waktu: 10/02/2026 14:30:25
User: John Doe (john@example.com)
Role: Admin
Aktivitas: Menambahkan alat baru: Laptop Dell
IP Address: 192.168.1.100
```

## Lisensi
Fitur ini adalah bagian dari Sistem Peminjaman Alat.
