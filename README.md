# Sistem Manajemen Data Kontak Mahasiswa


### 1. **Sistem Autentikasi**
   - Login dengan username dan password
   - Session management untuk keamanan
   - Logout functionality
   - Error handling untuk login yang gagal

### 2. **Manajemen Data Mahasiswa**
   - ✅ **Tambah Data** - Menambahkan data mahasiswa baru
   - ✅ **Lihat Data** - Menampilkan semua data mahasiswa dalam tabel
   - ✅ **Edit Data** - Mengubah informasi mahasiswa yang ada
   - ✅ **Hapus Data** - Menghapus data mahasiswa dengan konfirmasi

### 3. **Validasi Data Komprehensif**
   - Validasi format nama (hanya huruf dan spasi)
   - Validasi NPM (hanya angka)
   - Validasi program studi (dropdown selection)
   - Validasi nomor telepon (hanya angka)
   - Validasi email (format valid)
   - Pesan error yang jelas untuk pengguna



## 🛠️ Teknologi yang Digunakan

| Teknologi | Versi | Keterangan |
|-----------|-------|-----------|
| PHP | 7.4+ | Server-side scripting |
| HTML5 | - | Markup struktur halaman |
| CSS | Tailwind CSS | Framework styling |
| Sessions | Built-in PHP | State management |

## 📁 Struktur File

```
Tugas-Akhir-Judul-4---Praktikum-Pemrograman-Web/
├── index.php           # Halaman login
├── dashboard.php       # Halaman utama (form & tabel data)
├── edit.php            # Halaman edit data mahasiswa
├── aksi.php            # Logika backend (CRUD & autentikasi)
├── kontak_data.php     # Fungsi manajemen data session
├── README.md           # Dokumentasi proyek
└── Tampilan/           # Folder screenshot tampilan
```