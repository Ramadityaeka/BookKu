# BookKu - Aplikasi Katalog dan Booking Buku


**BookKu** adalah aplikasi web yang berfungsi sebagai sistem manajemen katalog dan pemesanan (booking) buku. Aplikasi ini dirancang untuk memudahkan pengguna dalam menjelajahi koleksi buku yang tersedia dan melakukan pemesanan untuk dipinjam. Di sisi lain, admin memiliki dasbor khusus untuk mengelola seluruh data buku dan memvalidasi setiap pemesanan yang masuk.

## Daftar Isi

- [Fitur](#fitur)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Panduan Instalasi](#panduan-instalasi)
  - [Prasyarat](#prasyarat)
  - [Langkah-langkah Instalasi](#langkah-langkah-instalasi)
- [Cara Penggunaan](#cara-penggunaan)
  - [Akses Admin](#akses-admin)
- [Struktur Proyek](#struktur-proyek)
- [Catatan Keamanan](#catatan-keamanan)
- [Roadmap](#roadmap)
- [Kontak](#kontak)

## Fitur

Aplikasi ini memiliki dua peran utama: Pengguna Publik dan Admin.

#### Fitur Publik
- **Katalog Buku**: Menampilkan daftar buku terbaru di halaman utama.
- **Pencarian Buku**: Memungkinkan pengguna mencari buku berdasarkan kata kunci.
- **Halaman Detail**: Menyajikan informasi lengkap setiap buku, termasuk sinopsis, genre, dan status ketersediaan.
- **Formulir Booking**: Pengguna dapat memesan buku dengan mengisi nama dan nomor telepon.
- **Informasi Booking**: Halaman untuk melihat semua status pemesanan (pending, approved, denied) beserta batas waktu pengambilan.
- **Halaman Kontak**: Menampilkan informasi kontak dan lokasi.

#### Fitur Admin
- **Login Aman**: Halaman login yang dilindungi dengan mekanisme hashing password.
- **Dasbor Manajemen**: Antarmuka terpusat untuk mengelola data.
- **CRUD Buku**: Admin dapat menambah, mengubah, dan menghapus data buku dalam katalog.
- **Upload Gambar Sampul**: Fitur untuk mengunggah gambar sampul buku dengan validasi ukuran dan tipe file.
- **Manajemen Booking**: Admin dapat melihat semua pesanan yang masuk, mengubah statusnya (menyetujui atau menolak), dan menghapus pesanan.

## Teknologi yang Digunakan

Proyek ini dibangun menggunakan teknologi modern berikut:
- **Framework**: [CodeIgniter 4.5.2](https://codeigniter.com/)
- **Bahasa Pemrograman**: PHP 8.0+
- **Database**: MySQL 
- **Frontend**: [TailwindCSS](https://tailwindcss.com/) & [Font Awesome](https://fontawesome.com/)
- **Manajemen Dependensi**: [Composer](https://getcomposer.org/)

### Detail Konfigurasi Sistem

#### 1. Konfigurasi Database
- Driver: MySQLi
- Host: localhost
- Port: 3306
- Database: emadding_db
- Charset: utf8
- DBCollat: utf8_general_ci

#### 2. Konfigurasi Aplikasi
- Base URL: http://localhost:8080/
- Charset: UTF-8
- Default Locale: en
- Timezone: UTC
- Index Page: index.php

#### 3. Sistem Keamanan
- Login Filter System
- Admin Filter System
- Session Management
- Password Hashing
- CSRF Protection
- XSS Filtering
- SQL Injection Prevention
- Input Validation
- Output Escaping

#### 4. Arsitektur Sistem
##### Models:
- BookingModel (Manajemen pemesanan)
- EventModel (Manajemen event)
- KatalogModel (Manajemen katalog buku)
- UserModel (Manajemen pengguna)

##### Controllers:
- AuthController (Autentikasi)
- BookingController (Pemesanan)
- EventController (Event)
- Admin Controllers:
  - BookingsController
  - DashboardController
  - EventController

##### Views:
- Template sistem
- Halaman admin
- Halaman publik
- Komponen terpisah (header, footer)

#### 5. Fitur Development
- Debug Toolbar
- Migration System
- Seeder System
- Environment-based Configuration
- Error Handling (CLI & HTML)
- Custom Libraries Support
- Third-party Integration Support

#### 6. File Management
- Upload System untuk gambar
- Validasi file
- Direktori terstruktur
- Public assets management

#### 7. Additional Features
- Multi-language Support
- Cache Management
- Session Handling
- Form Validation
- URL Routing
- RESTful API Ready
- Template inheritance system

## Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda.

### Prasyarat

Pastikan perangkat Anda telah terinstal:
- PHP >= 8.0
- Composer
- Server Database (misalnya XAMPP,MySQL)


