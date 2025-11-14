# 🚀 Panduan Deploy BookKu ke Railway

Dokumen ini berisi panduan lengkap untuk mendeploy aplikasi BookKu ke Railway.app agar dapat diakses secara publik.

## 📋 Prasyarat

1. Akun GitHub (gratis)
2. Akun Railway.app (gratis - https://railway.app)
3. Repository BookKu sudah di-fork atau clone

## 🎯 Metode 1: Deploy Cepat dengan Template Railway (Recommended)

### Langkah 1: Gunakan Template Railway
1. Klik tombol deploy di README.md, atau
2. Buka: https://railway.app/new/template?template=https://github.com/Ramadityaeka/BookKu
3. Login dengan akun GitHub Anda
4. Klik "Deploy Now"

Railway akan otomatis:
- ✅ Setup aplikasi dari repository
- ✅ Buat MySQL database
- ✅ Generate domain publik
- ✅ Konfigurasi environment variables

### Langkah 2: Tunggu Deployment Selesai
- Deploy pertama biasanya memakan waktu 3-5 menit
- Monitor progress di Railway dashboard
- Status berubah dari "Building" → "Deploying" → "Active"

### Langkah 3: Import Database
1. Di Railway dashboard, pilih service "bookku-database"
2. Klik tab "Connect"
3. Copy connection string atau credentials
4. Gunakan MySQL client untuk import:
   ```bash
   mysql -h [MYSQLHOST] -u [MYSQLUSER] -p[MYSQLPASSWORD] [MYSQLDATABASE] < db_bookku.sql
   ```

### Langkah 4: Akses Aplikasi
1. Kembali ke service "bookku-app"
2. Klik tab "Settings" → "Networking"
3. Copy domain yang di-generate (contoh: bookku-production.up.railway.app)
4. Buka domain di browser - aplikasi Anda sudah live! 🎉

---

## 🎯 Metode 2: Deploy Manual dari GitHub Repository

### Langkah 1: Login ke Railway
1. Buka https://railway.app
2. Sign up/Login dengan GitHub
3. Klik "New Project"

### Langkah 2: Deploy dari GitHub
1. Pilih "Deploy from GitHub repo"
2. Authorize Railway untuk akses GitHub
3. Pilih repository `Ramadityaeka/BookKu`
4. Klik "Deploy Now"

### Langkah 3: Tambahkan MySQL Database
1. Di project dashboard, klik "+ New"
2. Pilih "Database" → "Add MySQL"
3. Railway akan provision MySQL instance

### Langkah 4: Link Database ke App
1. Klik service "bookku-app"
2. Buka tab "Variables"
3. Pastikan variable berikut tersedia (auto-inject dari MySQL):
   - `MYSQLHOST`
   - `MYSQLPORT`
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`

### Langkah 5: Tambahkan Environment Variables
Klik "New Variable" dan tambahkan:
```
CI_ENVIRONMENT=production
```

### Langkah 6: Generate Public Domain
1. Klik service "bookku-app"
2. Tab "Settings" → "Networking"
3. Klik "Generate Domain"
4. Domain publik akan dibuat (contoh: bookku-production-abc123.up.railway.app)

### Langkah 7: Import Database Schema
1. Connect ke MySQL menggunakan credentials dari Railway
2. Import file `db_bookku.sql`:
   ```bash
   # Gunakan Railway CLI atau MySQL client
   railway run mysql -u root -p < db_bookku.sql
   ```

Atau gunakan Railway Connect:
```bash
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Link project
railway link

# Connect ke database
railway connect mysql

# Import schema
SOURCE db_bookku.sql;
```

---

## 🎯 Metode 3: Deploy dengan Railway CLI

### Langkah 1: Install Railway CLI
```bash
# Menggunakan npm
npm i -g @railway/cli

# Atau dengan Homebrew (macOS)
brew install railway
```

### Langkah 2: Login dan Initialize
```bash
# Login ke Railway
railway login

# Clone repository (jika belum)
git clone https://github.com/Ramadityaeka/BookKu.git
cd BookKu

# Initialize Railway project
railway init
```

### Langkah 3: Add MySQL Database
```bash
# Tambah MySQL ke project
railway add mysql

# Link database ke aplikasi
railway service
```

### Langkah 4: Deploy
```bash
# Deploy aplikasi
railway up

# Monitor logs
railway logs
```

### Langkah 5: Import Database
```bash
# Connect ke MySQL
railway connect mysql

# Kemudian import schema
mysql> SOURCE db_bookku.sql;
mysql> exit;
```

### Langkah 6: Open App
```bash
# Generate dan buka domain
railway domain
railway open
```

---

## 🔧 Konfigurasi Environment Variables

Railway secara otomatis inject environment variables untuk MySQL. Aplikasi BookKu sudah dikonfigurasi untuk menggunakan variable berikut:

### Variables yang Auto-Inject (dari MySQL service):
- `MYSQLHOST` - Host database
- `MYSQLPORT` - Port database (default: 3306)
- `MYSQLDATABASE` - Nama database
- `MYSQLUSER` - Username database
- `MYSQLPASSWORD` - Password database

### Variables Manual (optional):
```bash
CI_ENVIRONMENT=production
```

---

## 🐛 Troubleshooting

### Problem: Build Failed
**Solusi:**
1. Check build logs di Railway dashboard
2. Pastikan Dockerfile syntax benar
3. Verify composer dependencies dapat diinstall
4. Check PHP version compatibility

### Problem: Database Connection Error
**Solusi:**
1. Verify MySQL service sudah running (cek tab "Deployments")
2. Pastikan environment variables ter-inject dengan benar
3. Check connection di tab "Variables"
4. Restart aplikasi service

### Problem: 500 Internal Server Error
**Solusi:**
1. Check application logs:
   ```bash
   railway logs
   ```
2. Verify writable directory permissions
3. Check database schema sudah di-import
4. Verify .env configuration

### Problem: Database Not Found
**Solusi:**
1. Connect ke MySQL dan create database:
   ```bash
   railway connect mysql
   mysql> CREATE DATABASE bookku;
   mysql> USE bookku;
   mysql> SOURCE /path/to/db_bookku.sql;
   ```

### Problem: Domain Not Accessible
**Solusi:**
1. Verify deployment status "Active"
2. Check health endpoint: `https://your-domain.railway.app/healthz.php`
3. Review networking settings
4. Regenerate domain jika perlu

---

## 📊 Monitoring & Logs

### View Application Logs
```bash
# Via CLI
railway logs

# Via Dashboard
Project → Service → Deployments → View Logs
```

### Health Check Endpoint
Aplikasi menyediakan health check endpoint:
```
https://your-domain.railway.app/healthz.php
```

Response example:
```json
{
  "status": "healthy",
  "timestamp": "2025-11-14 09:00:00",
  "php_version": "8.1.0",
  "checks": {
    "database": "connected",
    "writable_dir": "writable"
  }
}
```

### Monitor Resource Usage
1. Railway Dashboard → Project
2. Tab "Metrics" untuk CPU, Memory, Network usage
3. Tab "Usage" untuk billing dan resource limits

---

## 💰 Railway Free Tier Limits

Railway menyediakan free tier dengan limits:
- **$5 USD credit per bulan** (gratis)
- Unlimited projects
- 512 MB RAM per service
- 1 GB disk per service
- Shared CPU
- No credit card required untuk trial

**Tips menghemat credits:**
- Sleep aplikasi saat tidak digunakan
- Optimize database queries
- Use proper caching
- Monitor resource usage regularly

---

## 🔄 Update Aplikasi (Continuous Deployment)

Railway otomatis deploy ulang setiap ada push ke GitHub:

1. Edit code di local
2. Commit dan push ke GitHub:
   ```bash
   git add .
   git commit -m "Update feature"
   git push origin main
   ```
3. Railway otomatis detect changes dan re-deploy
4. Monitor deployment progress di dashboard

---

## 📞 Support & Resources

### Railway Documentation
- https://docs.railway.app
- https://railway.app/help

### BookKu Repository
- https://github.com/Ramadityaeka/BookKu
- Open issue untuk bug reports atau feature requests

### Community
- Railway Discord: https://discord.gg/railway
- Railway Community: https://community.railway.app

---

## ✅ Checklist Deployment

Gunakan checklist ini untuk memastikan deployment sukses:

- [ ] Akun Railway sudah dibuat
- [ ] Repository sudah di-fork/clone
- [ ] Service aplikasi deployed
- [ ] MySQL database added dan running
- [ ] Environment variables configured
- [ ] Database schema imported (`db_bookku.sql`)
- [ ] Public domain generated
- [ ] Aplikasi dapat diakses via browser
- [ ] Health check endpoint return status healthy
- [ ] Login dan fitur CRUD berfungsi normal

---

**Selamat! Aplikasi BookKu Anda sekarang sudah live dan dapat diakses publik!** 🎉

Jika mengalami masalah, silakan buka issue di repository atau hubungi via GitHub.
