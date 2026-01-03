<p align="center">
  <img src="https://img.icons8.com/color/96/shopping-cart--v1.png" alt="Peukan Rumoh Logo"/>
</p>

<h1 align="center">🏪 Peukan Rumoh</h1>

<p align="center">
  <strong>Platform E-Commerce Multi-Role untuk Digitalisasi Pasar Tradisional</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"/>
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP"/>
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"/>
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License"/>
</p>

<p align="center">
  <a href="#-fitur-utama">Fitur</a> •
  <a href="#-teknologi">Teknologi</a> •
  <a href="#-instalasi">Instalasi</a> •
  <a href="#-role-pengguna">Role</a> •
  <a href="#-dokumentasi">Dokumentasi</a>
</p>

---

## 📖 Tentang Peukan Rumoh

**Peukan Rumoh** (Bahasa Aceh: "Pasar Rumah") adalah platform e-commerce yang menghubungkan pedagang pasar tradisional dengan pembeli secara online. Sistem ini mendukung 4 role pengguna dengan fitur lengkap mulai dari manajemen produk hingga pengembalian barang.

### 🎯 Tujuan
- Mempermudah pedagang pasar tradisional menjual produk secara online
- Memberikan pengalaman belanja yang nyaman bagi pembeli
- Menyediakan sistem pengiriman terintegrasi dengan kurir
- Dashboard monitoring untuk Admin

---

## ✨ Fitur Utama

### 👤 Multi-Role Authentication
| Role | Fitur |
|------|-------|
| **🔧 Admin** | Dashboard analitik, kelola users, approve pedagang/kurir, monitoring orders & returns |
| **🏪 Pedagang** | Kelola produk, terima & proses pesanan, handle returns, lihat statistik penjualan |
| **🚚 Kurir** | Pickup & deliver orders, handle return pickup, riwayat pengiriman |
| **🛒 Pembeli** | Browse produk, keranjang belanja, checkout, tracking pesanan, review & return |

### 🛒 E-Commerce
- Katalog produk dengan kategori (Sayuran, Buah, Bumbu, Daging, dll)
- Keranjang belanja real-time
- Multiple payment methods (Transfer Bank, E-Wallet, COD)
- Order tracking dengan timeline status

### 📦 Manajemen Pesanan
- Status flow: `Pending → Paid → Processing → Ready Pickup → Shipped → Completed`
- Notifikasi perubahan status
- Riwayat pesanan lengkap

### 🔄 Sistem Return
- Ajukan pengembalian dengan bukti foto
- Pilihan: Refund atau Barang Pengganti
- Tracking proses return end-to-end

### 📊 Dashboard & Laporan
- Statistik penjualan real-time
- Grafik tren pesanan
- Low stock alerts
- Export laporan

---

## 🛠️ Teknologi

| Layer | Teknologi |
|-------|-----------|
| **Backend** | Laravel 11, PHP 8.2+ |
| **Database** | MySQL 8.0+ |
| **Frontend** | Blade Templates, Vanilla CSS |
| **Authentication** | Laravel Auth + Sanctum (API) |
| **API** | RESTful API untuk Mobile App |

---

## 📦 Instalasi

### Prasyarat
- PHP 8.2+
- Composer
- MySQL 8.0+
- Git

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/username/peukan-rumoh.git
cd peukan-rumoh

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
# DB_DATABASE=peukan_rumoh
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Jalankan migrasi & seeder
php artisan migrate --seed

# 6. Link storage
php artisan storage:link

# 7. Jalankan server
php artisan serve
```

### Akun Demo

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@peukanrumoh.com | password |
| Pedagang | pedagang@peukanrumoh.com | password |
| Kurir | kurir@peukanrumoh.com | password |
| Pembeli | pembeli@peukanrumoh.com | password |

---

## 👥 Role Pengguna

### 🔧 Admin
```
Dashboard → Users → Products → Orders → Returns → Reviews
```
- Approve/reject pendaftaran pedagang & kurir
- Monitor semua transaksi
- Kelola laporan & statistik

### 🏪 Pedagang
```
Dashboard → Produk Saya → Pesanan → Returns → Ulasan
```
- CRUD produk dengan gambar (max 10MB)
- Proses pesanan masuk
- Handle permintaan return

### 🚚 Kurir
```
Dashboard → Pengiriman → Return → Riwayat
```
- Pickup pesanan dari pedagang
- Deliver ke pembeli
- Handle return pickup

### 🛒 Pembeli
```
Home → Shop → Cart → Checkout → Orders → Profile
```
- Browse & search produk
- Checkout dengan berbagai metode bayar
- Track pesanan & review produk

---

## 📚 Dokumentasi

| Dokumen | Deskripsi |
|---------|-----------|
| [UML_Diagrams.md](./UML_Diagrams.md) | Use Case, Activity, Class, Sequence Diagram |
| [DOKUMENTASI_SISTEM.md](./DOKUMENTASI_SISTEM.md) | Dokumentasi lengkap sistem |
| [DOKUMENTASI_TEKNIS.md](./DOKUMENTASI_TEKNIS.md) | Spesifikasi teknis & arsitektur |
| [DESKRIPSI_DAN_DESAIN_UI.md](./DESKRIPSI_DAN_DESAIN_UI.md) | Deskripsi UI/UX |
| [docs/](./docs/) | Database SQL, Setup Guide, dll |

---

## 📱 API Endpoints

Base URL: `/api`

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/register` | Registrasi user baru |
| POST | `/login` | Login & get token |
| GET | `/products` | List semua produk |
| GET | `/products/{id}` | Detail produk |
| GET | `/cart` | Lihat keranjang |
| POST | `/cart` | Tambah ke keranjang |
| POST | `/orders` | Buat pesanan |
| GET | `/orders` | Riwayat pesanan |

---

## 🗂️ Struktur Project

```
peukan-rumoh/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/         # Controller admin
│   │   ├── Api/           # Controller API
│   │   ├── Auth/          # Authentication
│   │   ├── Kurir/         # Controller kurir
│   │   ├── Pedagang/      # Controller pedagang
│   │   └── Pembeli/       # Controller pembeli
│   ├── Models/            # Eloquent models
│   └── Http/Middleware/   # Custom middleware
├── database/
│   ├── migrations/        # Database migrations
│   └── seeders/           # Demo data seeders
├── resources/views/
│   ├── admin/             # Views admin
│   ├── kurir/             # Views kurir
│   ├── pedagang/          # Views pedagang
│   ├── pembeli/           # Views pembeli
│   └── layouts/           # Base layouts
├── routes/
│   ├── web.php            # Web routes
│   └── api.php            # API routes
└── docs/                  # Dokumentasi tambahan
```

---

## 🔐 Security

- CSRF Protection
- Password Hashing (Bcrypt)
- Role-based Access Control
- Middleware untuk setiap role
- Sanctum untuk API Authentication

---

## 📄 License

Project ini dilisensikan di bawah [MIT License](LICENSE).

---

<p align="center">
  <strong>Peukan Rumoh</strong> - Digitalisasi Pasar Tradisional 🏪
  <br>
  <sub>Dibuat dengan ❤️ menggunakan Laravel</sub>
</p>
