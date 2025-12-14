# 🚀 Panduan Deployment SisaKu

## Deployment Checklist

Sebelum deploy ke hosting, pastikan langkah-langkah berikut dijalankan:

### 1. **Local Development (Sebelum Push)**
```bash
# Pastikan semua dependencies terinstall
npm install

# Build assets untuk production
npm run build

# Verifikasi build berhasil
ls public/build/manifest.json  # File ini harus ada

# Commit changes (jangan commit public/build)
git status  # Verifikasi hanya kode yang diubah
git add .
git commit -m "Fix: smooth transitions & optimization"
git push origin main
```

### 2. **Server Deployment (Di Hosting)**

#### Option A: Manual (Recommended)
```bash
# SSH ke server
ssh user@hosting

# Navigate ke project
cd /home/xxxsuzqm/repositories/IkhsanSisaKu

# Pull latest code
git pull origin main

# Install Node dependencies
npm install

# Build Vite assets
npm run build

# Verify manifest file exists
ls -la public/build/manifest.json

# Clear Laravel cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Option B: Automated (Post-Deploy Hook)
Minta hosting untuk menjalankan script ini setelah setiap deployment:

```bash
#!/bin/bash
cd /home/xxxsuzqm/repositories/IkhsanSisaKu
npm install
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. **Verification Steps**

✅ Pastikan file ini ada setelah deployment:
- `/public/build/manifest.json`
- `/public/build/assets/app-*.js`
- `/public/build/assets/app-*.css`

✅ Test di browser:
- Buka halaman admin/dashboard
- Tidak ada error "Vite manifest not found"
- Transitions smooth saat navigasi menu
- Floating chatbot muncul smooth tanpa flicker

### 4. **Common Issues**

| Error | Solusi |
|-------|--------|
| Vite manifest not found | Jalankan `npm run build` di server |
| node_modules not found | Jalankan `npm install` di server |
| Assets CSS/JS tidak muncul | Clear browser cache (Ctrl+Shift+Delete) |
| Build gagal di server | Pastikan Node.js versi >= 18 |

### 5. **.gitignore Configuration**

File `.gitignore` sudah benar (line 16):
```gitignore
/public/build    # Artifacts tidak di-version control
```

Ini normal karena build files dihasilkan otomatis dari source code.

### 6. **Environment Check**

Server harus memiliki:
- **Node.js** >= 18.x
- **npm** >= 10.x
- **PHP** >= 8.2
- **Composer** untuk dependencies

Cek versi di server:
```bash
node --version
npm --version
php --version
```

---

**Last Updated:** 14 Dec 2025
