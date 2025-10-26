# BookKu 📚

Sistem manajemen buku berbasis PHP & CodeIgniter.

## 🌐 Live Demo
**Deploy to Railway:** [![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/new/template?template=https://github.com/Ramadityaeka/BookKu)

## 🚀 Deploy ke Railway

### Quick Steps:
1. Fork/Clone repo ini
2. Daftar di [Railway.app](https://railway.app)
3. Klik "Deploy from GitHub repo"
4. Pilih `Ramadityaeka/BookKu`
5. Tambah MySQL database (+ New → Database → MySQL)
6. Connect database ke app (Variables → Add Reference)
7. Generate domain (Settings → Networking → Generate Domain)

### File yang diperlukan (sudah ada):
- ✅ `Dockerfile` - Container configuration
- ✅ `railway.json` - Railway deployment settings
- ✅ `config.railway.php` - Database config untuk production

## 💻 Install Lokal

```bash
# Clone repository
git clone https://github.com/Ramadityaeka/BookKu.git
cd BookKu

# Setup database
mysql -u root -p
CREATE DATABASE bookku;
USE bookku;
SOURCE database.sql;

# Jalankan dengan PHP built-in server
php -S localhost:8000

# Atau dengan Apache/Nginx
# Arahkan document root ke folder BookKu
```

## 📋 Requirements
- PHP 7.4+ (Rekomendasi: PHP 8.1)
- MySQL 5.7+ / MariaDB 10.3+
- Apache dengan mod_rewrite / Nginx
- Composer (opsional)

## 📂 Struktur Project
```
BookKu/
├── app/                 # CodeIgniter application
├── public/              # Public assets
├── writable/            # Cache, logs, uploads
├── Dockerfile           # Docker configuration (Railway)
├── railway.json         # Railway deployment config
└── README.md
```

## 🔧 Configuration

### Local Development
Edit file konfigurasi database di `app/Config/Database.php`

### Production (Railway)
Gunakan environment variables yang auto-inject oleh Railway:
- `MYSQLHOST`
- `MYSQLPORT`
- `MYSQLDATABASE`
- `MYSQLUSER`
- `MYSQLPASSWORD`

## 🐛 Troubleshooting

### Railway deployment issues:
1. **Build failed** → Check Dockerfile syntax
2. **Database connection error** → Verify MySQL service connected
3. **500 error** → Check logs di Railway dashboard

### Local issues:
1. **mod_rewrite not enabled** → `a2enmod rewrite && service apache2 restart`
2. **Permission denied** → `chmod -R 755 writable/`

## 📝 Features
- ✅ Manajemen buku (CRUD)
- ✅ Kategori buku
- ✅ Pencarian & filter
- ✅ User authentication
- ✅ Responsive design

## 👤 Author
[@Ramadityaeka](https://github.com/Ramadityaeka)

## 📄 License
MIT License - bebas digunakan untuk pembelajaran

---

**Need help?** Open an issue atau hubungi via GitHub
