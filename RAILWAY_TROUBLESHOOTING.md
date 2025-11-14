# 🔧 Troubleshooting Railway Deployment - "Whoops!" Error

## ❌ Problem: "Whoops! We seem to have hit a snag"

Error ini biasanya muncul karena:
1. Database belum di-import
2. Environment variables belum ter-configure
3. Build/deployment gagal
4. Aplikasi crash saat startup

---

## ✅ Solusi Step-by-Step

### LANGKAH 1: Check Deployment Status

1. **Buka Railway Dashboard**: https://railway.app
2. **Pilih project** BookKu Anda
3. **Check status deployment**:
   - Klik pada service "bookku-app" 
   - Lihat tab "Deployments"
   - Status harus "Active" (hijau) bukan "Failed" (merah)

**Jika status "Failed":**
- Klik deployment untuk lihat logs
- Lihat error message di build logs
- Lanjut ke Langkah 2

**Jika status "Active":**
- Lanjut ke Langkah 3

---

### LANGKAH 2: Check Build Logs (Jika Deployment Failed)

1. **Railway Dashboard** → Project → Service "bookku-app"
2. **Klik tab "Deployments"**
3. **Klik deployment yang failed** (yang merah)
4. **Baca logs** untuk cari error

**Common Build Errors:**

#### Error: "composer install failed"
```bash
# Solusi: Redeploy
# Di Railway Dashboard:
# Settings → Redeploy
```

#### Error: "Dockerfile syntax error"
```bash
# Solusi: File sudah benar, coba redeploy
# Atau check Dockerfile di repository
```

---

### LANGKAH 3: Check Database Service

1. **Railway Dashboard** → Project
2. **Pastikan ada service "MySQL"** atau "bookku-database"
3. **Check status MySQL**:
   - Klik MySQL service
   - Tab "Deployments" → harus "Active"

**Jika MySQL tidak ada:**

#### Add MySQL Service:
1. **Klik "+ New"** di Railway dashboard
2. **Pilih "Database"**
3. **Pilih "Add MySQL"**
4. **Tunggu provision selesai** (1-2 menit)

---

### LANGKAH 4: Link Database ke App

1. **Railway Dashboard** → Service "bookku-app"
2. **Klik tab "Variables"**
3. **Check variables berikut ADA:**
   - `MYSQLHOST`
   - `MYSQLPORT`
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`

**Jika variables TIDAK ADA atau SALAH:**

#### Link Database ke App:
1. **Klik service "bookku-app"**
2. **Tab "Variables"**
3. **Klik "New Variable"** → **"Add Reference"**
4. **Pilih MySQL service**
5. **Add semua MySQL variables**

#### Manual Setup Variables:
Atau tambah manual dengan klik "+ New Variable":
```
MYSQLHOST = (dari MySQL service → Connect)
MYSQLPORT = 3306
MYSQLDATABASE = railway
MYSQLUSER = root
MYSQLPASSWORD = (dari MySQL service → Connect)
```

---

### LANGKAH 5: Import Database Schema

**PENTING**: Database schema HARUS di-import!

#### Method 1: Via Railway CLI (Recommended)

```bash
# Install Railway CLI (jika belum)
npm install -g @railway/cli

# Login
railway login

# Link ke project
railway link

# Connect ke MySQL
railway connect mysql

# Di MySQL prompt, import schema:
mysql> USE railway;
mysql> SOURCE db_bookku.sql;
mysql> SHOW TABLES;
mysql> exit;
```

#### Method 2: Via MySQL Client

```bash
# Get credentials dari Railway Dashboard
# MySQL service → Connect → Copy credentials

# Kemudian:
mysql -h [MYSQLHOST] -u root -p[MYSQLPASSWORD] -P [MYSQLPORT] railway < db_bookku.sql
```

#### Method 3: Via Web Interface (TablePlus, DBeaver, etc)

1. **Download MySQL client** (TablePlus, DBeaver, phpMyAdmin)
2. **Get connection details** dari Railway → MySQL service → Connect
3. **Connect ke database**
4. **Import file** `db_bookku.sql`

---

### LANGKAH 6: Restart Application

Setelah database di-import:

1. **Railway Dashboard** → Service "bookku-app"
2. **Tab "Settings"**
3. **Klik "Restart"**
4. **Tunggu 1-2 menit**
5. **Try akses domain lagi**

---

### LANGKAH 7: Check Logs

```bash
# Via CLI:
railway logs

# Atau via Dashboard:
# Service → Deployments → View Logs
```

**Look for errors like:**
- `Connection refused` → Database not connected
- `Table doesn't exist` → Database not imported
- `500 Internal Server Error` → Application error

---

### LANGKAH 8: Test Health Endpoint

```bash
# Replace dengan domain Railway Anda
curl https://your-bookku-domain.up.railway.app/healthz.php
```

**Expected response:**
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

**If unhealthy:**
```json
{
  "status": "degraded",
  "checks": {
    "database": "unhealthy"  ← Database problem
  }
}
```
→ Database belum di-import atau tidak ter-connect

---

## 🎯 Checklist Lengkap

Pastikan semua ini sudah dilakukan:

- [ ] ✅ Railway project created
- [ ] ✅ MySQL service added & running
- [ ] ✅ App service deployed & running (status "Active")
- [ ] ✅ Environment variables configured (MYSQL*)
- [ ] ✅ Database schema imported (`db_bookku.sql`)
- [ ] ✅ Domain generated
- [ ] ✅ Application restarted after database import
- [ ] ✅ Health check returns "healthy"

---

## 📋 Quick Commands Reference

```bash
# Check project status
railway status

# View logs
railway logs

# Connect to database
railway connect mysql

# Restart service
railway restart

# Open in browser
railway open

# List variables
railway variables
```

---

## 🆘 Still Not Working?

### Langkah Debugging Lanjutan:

#### 1. Check Apache/PHP Errors
```bash
railway logs | grep -i error
```

#### 2. Verify Dockerfile Build
```bash
# Check if build completed successfully
railway logs | grep -i "successfully built"
```

#### 3. Test Database Connection Manually
```bash
railway connect mysql
mysql> SHOW DATABASES;
mysql> USE railway;
mysql> SHOW TABLES;
# Pastikan tables ada (booking, buku, users, dll)
```

#### 4. Check Writable Permissions
```bash
railway logs | grep -i "permission denied"
```

#### 5. Verify Environment
```bash
railway variables | grep MYSQL
# Semua 5 variables harus ada
```

---

## 📞 Need More Help?

### Get Detailed Logs:
```bash
# Get ALL logs
railway logs -f

# Filter by error
railway logs | grep "error\|Error\|ERROR"

# Get last 100 lines
railway logs --lines 100
```

### Share Information:
Jika masih error, share ini:
1. Screenshot deployment status
2. Build logs (railway logs)
3. Environment variables (censored passwords)
4. Health check response
5. Error message lengkap

---

## ✅ Common Solutions Summary

| Error | Solusi |
|-------|--------|
| "Whoops!" page | Import database & restart |
| Status "Failed" | Check build logs & redeploy |
| Database unhealthy | Link MySQL & import schema |
| 500 Error | Check logs & verify config |
| Connection refused | Add MySQL service |
| Table not found | Import db_bookku.sql |
| Variables missing | Add MySQL references |

---

## 🎉 Success Indicators

Jika berhasil, Anda akan lihat:
- ✅ Deployment status: **Active** (hijau)
- ✅ Health check: `{"status": "healthy"}`
- ✅ Domain accessible di browser
- ✅ Homepage muncul tanpa error
- ✅ Bisa login dan akses features

---

**Gunakan checklist di atas untuk memastikan semua langkah sudah dilakukan!**

Jika ada error spesifik, check section troubleshooting yang sesuai.
