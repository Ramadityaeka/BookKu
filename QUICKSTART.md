# 🚀 Quick Start Guide - BookKu Deployment

## Cara Tercepat untuk Deploy (1 Menit!)

### Opsi 1: Klik Deploy Button (Termudah!)

1. **Klik tombol ini:**

   [![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/new/template?template=https://github.com/Ramadityaeka/BookKu)

2. **Login dengan GitHub** (gratis, tidak perlu kartu kredit)

3. **Klik "Deploy Now"** dan tunggu 3-5 menit

4. **Selesai!** Aplikasi Anda sudah online 🎉

### Opsi 2: Gunakan Script Otomatis

```bash
# Clone repository
git clone https://github.com/Ramadityaeka/BookKu.git
cd BookKu

# Jalankan script deploy
./deploy-railway.sh
```

Script akan otomatis:
- ✅ Install Railway CLI (jika belum ada)
- ✅ Login ke Railway
- ✅ Setup project
- ✅ Deploy aplikasi
- ✅ Generate domain publik

### Opsi 3: Manual dengan Railway CLI

```bash
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Clone & masuk ke folder
git clone https://github.com/Ramadityaeka/BookKu.git
cd BookKu

# Initialize project
railway init

# Deploy
railway up

# Generate domain
railway domain
```

---

## Import Database Setelah Deploy

Setelah aplikasi deployed, import database schema:

### Via Railway CLI:
```bash
# Connect ke MySQL
railway connect mysql

# Di MySQL prompt:
mysql> SOURCE db_bookku.sql;
mysql> exit;
```

### Via MySQL Client:
```bash
# Get credentials dari Railway dashboard
# Kemudian:
mysql -h [MYSQLHOST] -u [MYSQLUSER] -p[MYSQLPASSWORD] [MYSQLDATABASE] < db_bookku.sql
```

---

## Akses Aplikasi

Setelah deploy selesai:

1. **Via Railway Dashboard:**
   - Buka Railway dashboard
   - Klik service "bookku-app"
   - Copy domain dari tab "Settings" → "Networking"
   - Buka di browser: `https://your-domain.up.railway.app`

2. **Via CLI:**
   ```bash
   railway open
   ```

3. **Check Health:**
   ```bash
   curl https://your-domain.up.railway.app/healthz.php
   ```

---

## Environment Variables

Railway otomatis inject variables berikut (tidak perlu diset manual):

| Variable | Deskripsi | Sumber |
|----------|-----------|--------|
| `MYSQLHOST` | MySQL host | Auto dari MySQL service |
| `MYSQLPORT` | MySQL port | Auto dari MySQL service |
| `MYSQLDATABASE` | Database name | Auto dari MySQL service |
| `MYSQLUSER` | MySQL user | Auto dari MySQL service |
| `MYSQLPASSWORD` | MySQL password | Auto dari MySQL service |
| `PORT` | Application port | Railway runtime |
| `RAILWAY_ENVIRONMENT` | Environment | Railway runtime |

### Set Manual (Optional):
```bash
railway variables set CI_ENVIRONMENT=production
```

---

## Monitor & Debugging

### View Logs:
```bash
# Real-time logs
railway logs

# Follow logs
railway logs -f
```

### Check Status:
```bash
railway status
```

### Health Check:
```bash
# Via browser
https://your-domain.up.railway.app/healthz.php

# Via curl
curl https://your-domain.up.railway.app/healthz.php
```

Expected response:
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

---

## Troubleshooting Common Issues

### Issue: Build Failed
**Solution:**
```bash
# Check logs
railway logs

# Redeploy
railway up --detach
```

### Issue: Database Connection Error
**Solution:**
1. Check if MySQL service is running
2. Verify environment variables:
   ```bash
   railway variables
   ```
3. Restart app service:
   ```bash
   railway restart
   ```

### Issue: 500 Error
**Solution:**
1. Check application logs
2. Verify database is imported
3. Check writable directory permissions

### Issue: Domain Not Working
**Solution:**
1. Regenerate domain:
   ```bash
   railway domain
   ```
2. Check deployment status:
   ```bash
   railway status
   ```
3. Wait 1-2 minutes for DNS propagation

---

## Update Aplikasi

Railway otomatis deploy ulang saat ada push ke GitHub:

```bash
# Edit code
vim app/Controllers/Home.php

# Commit & push
git add .
git commit -m "Update feature"
git push origin main

# Railway otomatis detect dan redeploy!
```

Atau deploy manual:
```bash
railway up
```

---

## Local Development

### Menggunakan Docker Compose:
```bash
# Start semua services (app + database)
docker-compose up -d

# Stop services
docker-compose down

# View logs
docker-compose logs -f
```

Aplikasi akan tersedia di: `http://localhost:8080`

### Menggunakan PHP Built-in Server:
```bash
# Install dependencies
composer install

# Setup database
mysql -u root -p < db_bookku.sql

# Run server
php spark serve

# Akses di http://localhost:8080
```

---

## Resource Usage & Limits

### Railway Free Tier:
- ✅ $5 USD credit/bulan (gratis)
- ✅ 512 MB RAM per service
- ✅ 1 GB disk per service
- ✅ Unlimited projects
- ✅ Tidak perlu kartu kredit untuk trial

### Tips Menghemat Credit:
1. **Sleep service** saat tidak digunakan
2. **Optimize queries** untuk reduce CPU usage
3. **Use caching** untuk reduce database calls
4. **Monitor usage** di Railway dashboard

---

## Support

### Dokumentasi:
- 📖 [Panduan Lengkap (DEPLOYMENT.md)](./DEPLOYMENT.md)
- 📖 [Railway Docs](https://docs.railway.app)
- 📖 [CodeIgniter 4 Docs](https://codeigniter.com/user_guide/)

### Community:
- 💬 [Railway Discord](https://discord.gg/railway)
- 💬 [Open Issue di GitHub](https://github.com/Ramadityaeka/BookKu/issues)

### Need Help?
Open issue di repository dengan detail:
1. Error message lengkap
2. Screenshot (jika ada)
3. Steps to reproduce

---

**Selamat! Aplikasi BookKu Anda sekarang sudah online dan dapat diakses publik!** 🎉
