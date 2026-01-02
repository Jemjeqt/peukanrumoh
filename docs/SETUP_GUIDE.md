# 🛒 Peukan Rumoh - Panduan Setup Project

## Langkah-langkah Setup dengan VS Code dan XAMPP (MySQL)

### 📋 Prasyarat
Pastikan sudah terinstall:
- **XAMPP** (dengan Apache & MySQL)
- **VS Code** 
- **Composer** (https://getcomposer.org/)
- **Node.js** (https://nodejs.org/)
- **Git** (opsional)

---

## 🚀 Langkah 1: Persiapan XAMPP

1. **Jalankan XAMPP Control Panel**
2. **Start Apache** dan **MySQL**
3. **Buka phpMyAdmin**: http://localhost/phpmyadmin

---

## 🗄️ Langkah 2: Buat Database

1. Di **phpMyAdmin**, klik **"New"** (sidebar kiri)
2. Masukkan nama database: `peukan_rumoh`
3. Pilih collation: `utf8mb4_unicode_ci`
4. Klik **"Create"**

Atau jalankan SQL berikut:
```sql
CREATE DATABASE IF NOT EXISTS peukan_rumoh 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;
```

---

## 📂 Langkah 3: Buka Project di VS Code

1. **Buka VS Code**
2. **File → Open Folder** → Pilih folder project `Peukan Rumoh`
3. Buka **Terminal** di VS Code: `Ctrl + `` (backtick)

---

## ⚙️ Langkah 4: Konfigurasi Environment

1. **Copy file .env.example ke .env**:
   ```bash
   copy .env.example .env
   ```

2. **Edit file `.env`**, ubah bagian database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=peukan_rumoh
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   > **Note**: Password default XAMPP MySQL adalah kosong

---

## 📦 Langkah 5: Install Dependencies

Jalankan di terminal VS Code:

```bash
# Install PHP dependencies
composer install

# Generate application key
php artisan key:generate

# Create storage link
php artisan storage:link
```

---

## 🗃️ Langkah 6: Jalankan Migrasi Database

```bash
# Buat tabel-tabel database
php artisan migrate

# Isi data contoh (seeder)
php artisan db:seed
```

Atau jalankan sekaligus:
```bash
php artisan migrate:fresh --seed
```

---

## 🚀 Langkah 7: Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## 👤 Akun Demo

Setelah menjalankan seeder, gunakan akun berikut untuk login:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@peukanrumoh.com | password |
| **Pedagang** | pedagang@peukanrumoh.com | password |
| **Kurir** | kurir@peukanrumoh.com | password |
| **Pembeli** | pembeli@peukanrumoh.com | password |

---

## 📁 Struktur Folder Penting

```
Peukan Rumoh/
├── app/
│   ├── Http/Controllers/    # Controllers
│   └── Models/              # Models Eloquent
├── database/
│   ├── migrations/          # File migrasi database
│   └── seeders/            # Data contoh
├── resources/views/         # File Blade template
├── routes/web.php          # Definisi routes
├── public/                 # Assets publik
└── .env                    # Konfigurasi environment
```

---

## 🔧 Troubleshooting

### Error: "SQLSTATE[HY000] [1049] Unknown database"
- Pastikan database `peukan_rumoh` sudah dibuat di phpMyAdmin

### Error: "No application encryption key"
```bash
php artisan key:generate
```

### Error: "Vite manifest not found"
```bash
npm install
npm run build
```

### Error: Gambar tidak muncul
```bash
php artisan storage:link
```

---

## 📝 Catatan Tambahan

- Pastikan XAMPP Apache & MySQL selalu running saat development
- Untuk production, gunakan PHP 8.1+ dan MySQL 8.0+
- Backup database secara berkala

---

**Happy Coding! 🎉**
