# BookKu - Aplikasi Katalog dan Booking Buku

<p align="center">
  <img src="https://img.shields.io/badge/CodeIgniter-4.5.2-orange.svg" alt="Codeigniter Version">
  <img src="https://img.shields.io/badge/PHP-8.0%2B-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
</p>

**BookKu** adalah aplikasi web yang berfungsi sebagai sistem manajemen katalog dan pemesanan (booking) buku. Aplikasi ini dirancang untuk memudahkan pengguna dalam menjelajahi koleksi buku yang tersedia dan melakukan pemesanan untuk dipinjam. Di sisi lain, admin memiliki dasbor khusus untuk mengelola seluruh data buku dan memvalidasi setiap pemesanan yang masuk.

<br>

<br>

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
- **Database**: MySQL / MariaDB
- **Frontend**: [TailwindCSS](https://tailwindcss.com/) & [Font Awesome](https://fontawesome.com/)
- **Manajemen Dependensi**: [Composer](https://getcomposer.org/)

## Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda.

### Prasyarat

Pastikan perangkat Anda telah terinstal:
- PHP >= 8.0
- Composer
- Server Database (misalnya XAMPP, Laragon, atau WAMP untuk MySQL/MariaDB)

### Langkah-langkah Instalasi

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/ramadityaeka/BookKu.git](https://github.com/ramadityaeka/BookKu.git)
    cd BookKu
    ```

2.  **Install Dependensi PHP**
    Jalankan perintah berikut untuk mengunduh semua dependensi yang dibutuhkan oleh CodeIgniter.
    ```bash
    composer install
    ```

3.  **Konfigurasi Environment**
    Salin file `env` menjadi `.env`. File `.env` akan digunakan untuk menyimpan konfigurasi spesifik lingkungan Anda.
    ```bash
    copy env .env
    ```
    Buka file `.env` dan sesuaikan konfigurasi berikut:
    ```dotenv
    # Atur base URL aplikasi
    app.baseURL = 'http://localhost:8080'

    # Konfigurasi database
    database.default.hostname = localhost
    database.default.database = bukuku_db
    database.default.username = root
    database.default.password = 
    database.default.DBDriver = MySQLi
    ```
    *Catatan: Ganti `bukuku_db`, `root`, dan password sesuai dengan konfigurasi database Anda.*

4.  **Setup Database**
    - Buat sebuah database baru di server database Anda dengan nama yang sesuai dengan yang Anda atur di file `.env` (contoh: `bukuku_db`).
    - Impor skema dan data awal dari file `bukuku_db.sql` ke dalam database yang baru Anda buat.
      ```sql
      -- Anda bisa menggunakan tool seperti phpMyAdmin atau command line
      mysql -u username -p bukuku_db < bukuku_db.sql
      ```

5.  **Jalankan Aplikasi**
    Gunakan perintah `spark` dari CodeIgniter untuk menjalankan server pengembangan lokal.
    ```bash
    php spark serve
    ```
    Aplikasi sekarang dapat diakses melalui URL yang Anda atur di `.env` (misal: `http://localhost:8080`).

## Cara Penggunaan

Setelah instalasi berhasil, Anda bisa langsung mengakses aplikasi melalui browser. Halaman utama akan menampilkan katalog buku. Anda dapat menekan gambar sampul atau judul untuk melihat detail dan melakukan booking.

### Akses Admin
- Untuk masuk ke dasbor admin, kunjungi rute `/login`.
- Gunakan kredensial default yang telah dibuat oleh Seeder:
  - **Username:** `admin`
  - **Password:** `password123`
- Setelah login, Anda akan diarahkan ke dasbor admin untuk mengelola buku dan pesanan.

## Struktur Proyek

Proyek ini mengikuti struktur direktori standar CodeIgniter 4 untuk memastikan pemisahan tugas yang jelas.
```
/app
|-- /Controllers   # Logika bisnis dan alur aplikasi
|   |-- /Admin     # Controller khusus admin
|-- /Models        # Interaksi dengan database
|-- /Views         # File presentasi (HTML)
|   |-- /admin     # Tampilan khusus dasbor admin
|   |-- /template  # Layout template
|-- /Database      # Migrations dan Seeder
|-- /Filters       # Filter middleware (contoh: AuthFilter)
/public            # Document root, aset publik (CSS, JS)
/writable          # Direktori untuk file cache, log, dan upload
```

## Catatan Keamanan
- **Password Hashing**: Aplikasi ini menggunakan `password_hash()` dan `password_verify()` untuk mengamankan kredensial pengguna, yang merupakan praktik standar industri.
- **Proteksi Rute Admin**: Semua rute di bawah `/admin` dilindungi oleh `AuthFilter` untuk memastikan hanya pengguna yang sudah login yang dapat mengaksesnya.
- **Proteksi CSRF**: Fitur proteksi CSRF **belum diaktifkan** secara global. Untuk meningkatkan keamanan, disarankan untuk mengaktifkannya di file `app/Config/Filters.php` dengan menghapus komentar pada baris `'csrf'` di dalam array `$globals`.

