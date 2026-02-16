# Update Profile & Password

## Fitur yang Ditambahkan

### 1. **Dropdown Profile di Navbar**
- Navbar sekarang memiliki dropdown untuk profile dan logout
- Menampilkan email user yang sedang login
- Menu dropdown berisi:
  - Profile Saya
  - Logout

### 2. **Edit Password di Profile**
- User dapat mengubah password dari halaman edit profile
- Password lama wajib diisi untuk keamanan
- Password baru dan konfirmasi harus sama
- Password minimal 6 karakter
- **Password bersifat opsional** - kosongkan jika tidak ingin mengubah

### 3. **Komponen Navbar Reusable**
- Navbar dibuat sebagai komponen yang bisa digunakan ulang
- Otomatis menyesuaikan menu berdasarkan role user
- Active state otomatis berdasarkan halaman

---

## Cara Menggunakan

### A. Mengakses Profile

#### Cara 1: Via Dropdown Navbar
1. Klik dropdown profile di navbar (email Anda)
2. Pilih **"Profile Saya"**

#### Cara 2: Via Dashboard
1. Buka Dashboard
2. Klik tombol **"Profile Saya"** (jika ada)

### B. Edit Profile Tanpa Mengubah Password

1. Buka halaman **Profile**
2. Klik tombol **"Edit Profile"**
3. Ubah data yang ingin diubah:
   - Nama
   - No Handphone
   - Alamat
4. **Kosongkan semua field password**
5. Klik **"Simpan Perubahan"**

### C. Edit Profile + Ubah Password

1. Buka halaman **Profile**
2. Klik tombol **"Edit Profile"**
3. Ubah data profile jika perlu
4. Scroll ke bagian **"Ubah Password"**
5. Isi:
   - **Password Lama**: Password saat ini
   - **Password Baru**: Password baru (min. 6 karakter)
   - **Konfirmasi Password**: Ulangi password baru
6. Klik **"Simpan Perubahan"**

---

## Validasi Password

### Aturan Password:
- ✅ Password lama harus benar
- ✅ Password baru minimal 6 karakter
- ✅ Password baru dan konfirmasi harus sama
- ✅ Jika salah satu field password diisi, semua harus diisi

### Contoh Validasi:

**Kasus 1: Hanya Ubah Profile (Tanpa Password)**
```
Nama: John Doe ✓
No HP: 08123456789 ✓
Alamat: Jakarta ✓

Password Lama: [kosong] ✓
Password Baru: [kosong] ✓
Konfirmasi: [kosong] ✓

Result: ✅ Berhasil (password tidak berubah)
```

**Kasus 2: Ubah Profile + Password**
```
Nama: John Doe ✓
No HP: 08123456789 ✓
Alamat: Jakarta ✓

Password Lama: password123 ✓
Password Baru: newpass456 ✓
Konfirmasi: newpass456 ✓

Result: ✅ Berhasil (profile dan password berubah)
```

**Kasus 3: Error - Password Lama Salah**
```
Password Lama: wrongpass ✗
Password Baru: newpass456
Konfirmasi: newpass456

Result: ❌ Error: "Password lama tidak sesuai!"
```

**Kasus 4: Error - Konfirmasi Tidak Sama**
```
Password Lama: password123 ✓
Password Baru: newpass456
Konfirmasi: newpass789 ✗

Result: ❌ Error: "Password baru dan konfirmasi tidak sama!"
```

**Kasus 5: Error - Password Terlalu Pendek**
```
Password Lama: password123 ✓
Password Baru: 12345 ✗ (kurang dari 6 karakter)
Konfirmasi: 12345

Result: ❌ Error: "Password minimal 6 karakter!"
```

---

## Fitur Keamanan

### 1. **Show/Hide Password**
- Setiap field password memiliki tombol mata (👁️)
- Klik untuk menampilkan/menyembunyikan password
- Memudahkan user memastikan password yang diketik benar

### 2. **Validasi Client-Side**
- JavaScript validasi sebelum submit
- Mencegah submit jika ada error
- Alert langsung jika ada kesalahan

### 3. **Validasi Server-Side**
- Double check di controller
- Verifikasi password lama dengan database
- Hash password baru dengan bcrypt

### 4. **Activity Log**
- Setiap perubahan profile tercatat
- Perubahan password tercatat terpisah
- Dapat dilihat di Activity Log (Admin)

---

## Komponen Navbar

### Penggunaan di View:

```php
<?= view('components/navbar', ['active' => 'dashboard']) ?>
```

### Parameter `active`:
- `dashboard` - Halaman dashboard
- `alat` - Halaman alat
- `alat-tersedia` - Halaman alat tersedia (peminjam)
- `user` - Halaman user
- `activity-log` - Halaman activity log
- `peminjaman` - Halaman peminjaman
- `profile` - Halaman profile

### Menu Berdasarkan Role:

**Admin:**
- Dashboard
- Alat
- User
- Activity Log
- Peminjaman
- Profile (dropdown)

**Petugas:**
- Dashboard
- Alat
- User
- Peminjaman
- Profile (dropdown)

**Peminjam:**
- Dashboard
- Alat Tersedia
- Peminjaman
- Profile (dropdown)

---

## File yang Diubah/Ditambahkan

### Controllers:
- `app/Controllers/ProfileController.php`
  - Method `update()` ditambahkan logika edit password

### Views:
- `app/Views/components/navbar.php` ⭐ BARU
- `app/Views/profile/index.php` - Update tampilan
- `app/Views/profile/edit.php` - Tambah form password

### Features:
- Dropdown profile di navbar
- Show/hide password toggle
- Validasi password client & server side
- Activity log untuk perubahan password

---

## Troubleshooting

### Password Tidak Berubah
**Penyebab**: Field password dikosongkan
**Solusi**: Isi semua field password (lama, baru, konfirmasi)

### Error: Password Lama Tidak Sesuai
**Penyebab**: Password lama yang dimasukkan salah
**Solusi**: Pastikan password lama benar

### Dropdown Tidak Muncul
**Penyebab**: Bootstrap JS tidak load
**Solusi**: 
1. Clear cache browser
2. Pastikan koneksi internet aktif (untuk CDN)
3. Cek console browser (F12) untuk error

### Navbar Tidak Muncul
**Penyebab**: View component tidak ditemukan
**Solusi**: Pastikan file `app/Views/components/navbar.php` ada

---

## Tips & Best Practices

### Untuk User:
1. ✅ Gunakan password yang kuat (kombinasi huruf, angka, simbol)
2. ✅ Jangan gunakan password yang sama dengan akun lain
3. ✅ Ubah password secara berkala
4. ✅ Jangan bagikan password ke orang lain
5. ✅ Gunakan fitur show/hide untuk memastikan password benar

### Untuk Admin:
1. ✅ Monitor activity log untuk perubahan password
2. ✅ Edukasi user tentang keamanan password
3. ✅ Atur kebijakan password minimal 8 karakter (edit di controller)
4. ✅ Pertimbangkan menambahkan 2FA (future feature)

---

## Konfigurasi

### Mengubah Minimal Panjang Password

Edit file: `app/Controllers/ProfileController.php`

Cari baris:
```php
if (strlen($password_baru) < 6) {
    return redirect()->back()->with('error', 'Password minimal 6 karakter!')->withInput();
}
```

Ubah angka `6` sesuai kebutuhan.

### Mengubah Tampilan Dropdown

Edit file: `app/Views/components/navbar.php`

Cari bagian:
```html
<li class="nav-item dropdown">
    <!-- Customize di sini -->
</li>
```

---

## Future Enhancements (Opsional)

- [ ] Upload foto profile
- [ ] Two-Factor Authentication (2FA)
- [ ] Password strength meter
- [ ] Email notification saat password berubah
- [ ] Riwayat perubahan password
- [ ] Force password change setelah X hari
- [ ] Prevent password reuse (simpan history)

---

## Support

Jika mengalami masalah:
1. Clear browser cache
2. Cek console browser (F12)
3. Verifikasi file `app/Views/components/navbar.php` ada
4. Cek log error di `writable/logs/`

---

**Selamat! Fitur profile dan password sudah lengkap.** 🎉
