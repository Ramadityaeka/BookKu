# BookKu 📚

[![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/new/template?template=https://github.com/Ramadityaeka/BookKu)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue)](https://www.php.net/)
[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.x-orange)](https://codeigniter.com/)

Sistem manajemen buku berbasis PHP & CodeIgniter 4 - Modern, cepat, dan mudah di-deploy!

## 🌐 Deploy ke Public (Railway)

**DEPLOY SEKARANG - Gratis & Mudah!**

[![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/new/template?template=https://github.com/Ramadityaeka/BookKu)

**Hanya 3 klik:**
1. Klik tombol "Deploy on Railway" di atas
2. Login dengan GitHub
3. Klik "Deploy" - Selesai! 🚀

**Aplikasi Anda akan live dalam 5 menit dengan:**
- ✅ Domain publik otomatis (https://your-app.up.railway.app)
- ✅ MySQL database configured
- ✅ SSL/HTTPS enabled
- ✅ Gratis $5/bulan credit

📖 **[Panduan Lengkap Deployment →](./DEPLOYMENT.md)** | 🚀 **[Quick Start Guide →](./QUICKSTART.md)** | 🔧 **[Troubleshooting Railway →](./RAILWAY_TROUBLESHOOTING.md)**

⚠️ **Error "Whoops!" di Railway?** → [Lihat solusinya di sini](./RAILWAY_TROUBLESHOOTING.md)

---

## 🚀 Alternative Deployment Options

### Deploy dengan Railway CLI
```bash
# Install Railway CLI
npm i -g @railway/cli

# Clone repository
git clone https://github.com/Ramadityaeka/BookKu.git
cd BookKu

# Login dan deploy
railway login
railway init
railway up
```

### Deploy dengan Docker
```bash
# Build image
docker build -t bookku .

# Run dengan docker-compose
docker-compose up -d
```

### Deploy ke Platform Lain
BookKu juga bisa di-deploy ke:
- **Heroku** - Gunakan Dockerfile
- **DigitalOcean App Platform** - Auto-detect Dockerfile
- **Google Cloud Run** - Container deployment
- **AWS Elastic Beanstalk** - Docker deployment

---

## 💻 Install Lokal (Development)

```bash
# Clone repository
git clone https://github.com/Ramadityaeka/BookKu.git
cd BookKu

# Setup database
mysql -u root -p
CREATE DATABASE bookku;
USE bookku;
SOURCE db_bookku.sql;

# Jalankan dengan PHP built-in server
php spark serve

# Atau dengan Apache/Nginx
# Arahkan document root ke folder BookKu/public
```

## 📋 Requirements
- PHP 7.4+ (Rekomendasi: PHP 8.1)
- MySQL 5.7+ / MariaDB 10.3+
- Apache dengan mod_rewrite / Nginx
- Composer (opsional)

## 📂 Struktur Project
```
BookKu/
├── app/                    # CodeIgniter application
│   ├── Config/            # Configuration files
│   ├── Controllers/       # Controllers
│   ├── Models/            # Models
│   └── Views/             # Views
├── public/                 # Public assets (document root)
├── writable/               # Cache, logs, uploads
├── docker-compose.yml      # Docker Compose for local dev
├── Dockerfile              # Docker configuration
├── railway.json            # Railway deployment config
├── railway.toml            # Railway build config
├── railway-template.json   # One-click deploy template
├── deploy-railway.sh       # Automated deployment script
├── validate-config.sh      # Configuration validator
├── DEPLOYMENT.md           # Comprehensive deployment guide
├── QUICKSTART.md           # Quick start guide
└── README.md
```

## 🛠️ Development Tools

### Validate Your Configuration
Sebelum deploy, pastikan semua konfigurasi sudah benar:
```bash
./validate-config.sh
```

Script ini akan check:
- ✅ Required files exists
- ✅ JSON configurations valid
- ✅ Dockerfile correct
- ✅ Database schema available
- ✅ App configuration proper

### Automated Deployment
Gunakan script otomatis untuk deploy:
```bash
./deploy-railway.sh
```

Script akan handle:
- Railway CLI installation
- Project initialization
- Database setup
- Deployment process
- Domain generation

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
