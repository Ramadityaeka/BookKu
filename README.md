# MadingKu - Digital Bulletin Board Application

MadingKu adalah aplikasi papan pengumuman digital yang dibangun menggunakan CodeIgniter 4. Aplikasi ini memungkinkan pengguna untuk mengelola dan berbagi artikel dengan tampilan yang modern dan responsif.

## Fitur

- 🔐 Sistem Autentikasi User
- 📝 Manajemen Artikel (CRUD)
- 🖼️ Upload dan Preview Gambar
- 🔍 Pencarian Artikel
- 📱 Tampilan Responsif
- ⚡ Performa Optimal

## Teknologi yang Digunakan

- PHP 8.0+
- CodeIgniter 4
- MySQL Database
- TailwindCSS
- Font Awesome Icons

## Instalasi

1. Clone repositori ini:
```bash
git clone https://github.com/yourusername/madingku.git
cd madingku
```

2. Install dependensi menggunakan Composer:
```bash
composer install
```

3. Salin file `env` menjadi `.env`:
```bash
copy env .env
```

4. Konfigurasi database di file `.env`:
```env
database.default.hostname = localhost
database.default.database = emadding_db
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

5. Import database:
```bash
mysql -u root -p emadding_db < emadding_db.sql
```

6. Jalankan migrasi database (opsional jika sudah import SQL):
```bash
php spark migrate
```

7. Jalankan seeder untuk membuat akun admin:
```bash
php spark db:seed AdminSeeder
```

## Menjalankan Aplikasi

1. Pastikan XAMPP (Apache dan MySQL) sudah berjalan

2. Buka browser dan akses:
```
http://localhost/emading/public
```

## Akun Default

- Admin:
  - Username: admin
  - Password: admin123
- User Demo:
  - Username: rama
  - Password: rama123

## Struktur Folder

```
app/
├── Controllers/         # Controller aplikasi
│   ├── BaseController.php
│   └── Home.php        # Controller utama
├── Models/
│   └── Jwp_model.php   # Model untuk manajemen artikel
├── Views/              # Template dan layout
│   ├── admin/         # Views untuk admin dashboard
│   ├── template/      # Layout template
│   ├── article.php    # Tampilan detail artikel
│   ├── index.php      # Halaman utama
│   ├── login.php      # Halaman login
│   └── search_results.php  # Hasil pencarian
└── Database/
    └── Seeds/         # Database seeders
        └── AdminSeeder.php # Seeder untuk akun admin

public/                 # Folder publik
writable/
├── uploads/           # Folder untuk upload gambar
└── logs/             # Log aplikasi
```

## Panduan Penggunaan

1. Login ke Dashboard Admin:
   - Akses `http://localhost/emading/public/login`
   - Masukkan kredensial admin

2. Mengelola Artikel:
   - Klik "Add New Article" untuk membuat artikel baru
   - Upload gambar (format: JPG, JPEG, PNG, max: 2MB)
   - Isi judul dan konten artikel
   - Klik Save untuk menyimpan

3. Pencarian Artikel:
   - Gunakan kotak pencarian di halaman utama
   - Masukkan kata kunci yang relevan
   - Hasil akan ditampilkan dengan highlight

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Persyaratan Sistem

1. Software yang Diperlukan:
   - XAMPP 8.0 atau lebih tinggi
   - Composer
   - Git (opsional)

2. PHP Extension yang Harus Aktif:
   - intl
   - mbstring
   - json
   - mysqlnd
   - curl

3. Konfigurasi PHP:
   - upload_max_filesize = 2M
   - post_max_size = 8M
   - memory_limit = 256M

## Keamanan

1. File Sensitif:
   - Semua file konfigurasi berada di luar folder public
   - Gambar upload disimpan di folder writable
   - Validasi tipe file dan ukuran saat upload

2. Autentikasi:
   - Menggunakan password hashing
   - Session management
   - Proteksi CSRF

## Menambah User/Password Baru

Ada 2 cara untuk menambah user baru:

### 1. Melalui Database Seeder

1. Buka file `app/Database/Seeds/AdminSeeder.php`
2. Tambahkan data user baru di array `$data`:
```php
$data = [
    [
        'username' => 'user_baru',
        'email'    => 'user@example.com',
        'password' => password_hash('password123', PASSWORD_DEFAULT),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ]
];
```
3. Jalankan seeder:
```bash
php spark db:seed AdminSeeder
```

### 2. Melalui Database Langsung

1. Generate password hash di CLI PHP:
```bash
php -r "echo password_hash('password_baru', PASSWORD_DEFAULT);"
```
2. Copy hash yang dihasilkan
3. Masukkan ke database melalui SQL:
```sql
INSERT INTO users (username, email, password, created_at, updated_at) 
VALUES (
    'username_baru',
    'email@example.com',
    'hash_yang_dihasilkan',
    NOW(),
    NOW()
);
```

> ⚠️ **Penting**: 
> - Selalu gunakan `password_hash()` untuk mengamankan password
> - Jangan simpan password dalam bentuk plain text
> - Minimal panjang password 8 karakter
> - Gunakan kombinasi huruf, angka, dan karakter khusus

## Struktur Navigasi

```
├── Halaman Publik
│   ├── Beranda (/)
│   │   ├── Daftar Artikel Terbaru
│   │   └── Kotak Pencarian
│   ├── Detail Artikel (/article/{id})
│   │   ├── Gambar Artikel
│   │   ├── Judul
│   │   └── Konten Lengkap
│   ├── Hasil Pencarian (/search)
│   │   ├── Daftar Hasil
│   │   └── Pesan Jika Tidak Ditemukan
│   └── Login (/login)
│       ├── Form Username
│       └── Form Password
│
└── Dashboard Admin (/dashboard)
    ├── Manajemen Artikel
    │   ├── Daftar Artikel
    │   │   ├── Preview Gambar
    │   │   ├── Judul
    │   │   └── Aksi (Edit/Hapus)
    │   └── Tambah Artikel Baru
    │       ├── Form Judul
    │       ├── Form Konten
    │       └── Upload Gambar
    └── Menu Navigasi
        ├── Dashboard
        ├── Lihat Situs
        └── Logout
```

## Kontak

Untuk pertanyaan dan dukungan, silakan hubungi:
- Email: rama@gmail.com
- GitHub: @ramaditya
