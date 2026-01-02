# 📊 Dokumentasi Database Peukan Rumoh

## 📌 Overview Tabel

Database `peukan_rumoh` memiliki **2 jenis tabel**:

### 🟢 Tabel Aplikasi (Yang Kita Buat)
Tabel yang dibuat khusus untuk aplikasi e-commerce ini.

### 🔵 Tabel Laravel System (Default Laravel)
Tabel bawaan Laravel untuk keperluan sistem (bisa diabaikan).

---

## 🟢 TABEL APLIKASI (Yang Penting)

### 1️⃣ **users** - Data Pengguna
Menyimpan semua pengguna (Admin, Pedagang, Kurir, Pembeli).

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary Key |
| name | varchar | Nama lengkap |
| email | varchar | Email (unique) |
| password | varchar | Password terenkripsi |
| role | enum | 'admin', 'pedagang', 'pembeli', 'kurir' |
| is_approved | boolean | Status approval (untuk pedagang/kurir) |
| phone | varchar | Nomor telepon |
| address | text | Alamat |
| store_name | varchar | Nama toko (khusus pedagang) |
| store_description | text | Deskripsi toko |
| store_logo | varchar | Path logo toko |

---

### 2️⃣ **markets** - Data Pasar
Menyimpan daftar pasar tradisional.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary Key |
| name | varchar | Nama pasar |
| address | text | Alamat pasar |
| description | text | Deskripsi |
| is_active | boolean | Status aktif |

---

### 3️⃣ **products** - Data Produk
Menyimpan produk yang dijual pedagang.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary Key |
| **user_id** | bigint | 🔗 FK ke `users` (pedagang pemilik) |
| **market_id** | bigint | 🔗 FK ke `markets` (pasar tempat jualan) |
| name | varchar | Nama produk |
| description | text | Deskripsi produk |
| price | decimal | Harga |
| stock | int | Stok tersedia |
| image | varchar | Path gambar |
| category | varchar | Kategori produk |
| is_active | boolean | Status aktif |

**Relasi:**
- `products.user_id` → `users.id` (Satu pedagang punya banyak produk)
- `products.market_id` → `markets.id` (Satu pasar punya banyak produk)

---

### 4️⃣ **carts** - Keranjang Belanja
Menyimpan item di keranjang pembeli.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary Key |
| **user_id** | bigint | 🔗 FK ke `users` (pembeli) |
| **product_id** | bigint | 🔗 FK ke `products` |
| quantity | int | Jumlah item |

**Relasi:**
- `carts.user_id` → `users.id` (Satu pembeli punya banyak item keranjang)
- `carts.product_id` → `products.id` (Produk yang dimasukkan keranjang)

---

### 5️⃣ **orders** - Data Pesanan
Menyimpan transaksi/pesanan.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary Key |
| **user_id** | bigint | 🔗 FK ke `users` (pembeli) |
| **kurir_id** | bigint | 🔗 FK ke `users` (kurir pengantar) |
| status | enum | Status pesanan |
| subtotal | decimal | Total harga produk |
| shipping_fee | decimal | Ongkos kirim |
| admin_fee | decimal | Biaya admin |
| total | decimal | Total keseluruhan |
| shipping_address | text | Alamat pengiriman |
| phone | varchar | Nomor telepon |
| payment_proof | varchar | Bukti pembayaran |
| paid_at | timestamp | Waktu pembayaran |
| delivered_at | timestamp | Waktu diterima |

**Relasi:**
- `orders.user_id` → `users.id` (Pembeli yang memesan)
- `orders.kurir_id` → `users.id` (Kurir yang mengantarkan)

---

### 6️⃣ **order_items** - Detail Item Pesanan
Menyimpan produk dalam satu pesanan.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary Key |
| **order_id** | bigint | 🔗 FK ke `orders` |
| **product_id** | bigint | 🔗 FK ke `products` |
| quantity | int | Jumlah item |
| price | decimal | Harga saat checkout |

**Relasi:**
- `order_items.order_id` → `orders.id` (Satu order punya banyak item)
- `order_items.product_id` → `products.id` (Produk yang dipesan)

---

### 7️⃣ **reviews** - Ulasan Produk
Menyimpan ulasan/rating dari pembeli.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary Key |
| **user_id** | bigint | 🔗 FK ke `users` (pembeli) |
| **product_id** | bigint | 🔗 FK ke `products` |
| **order_id** | bigint | 🔗 FK ke `orders` |
| rating | tinyint | Rating 1-5 |
| comment | text | Komentar ulasan |

**Relasi:**
- `reviews.user_id` → `users.id` (Pembeli yang mengulas)
- `reviews.product_id` → `products.id` (Produk yang diulas)
- `reviews.order_id` → `orders.id` (Order terkait)

---

### 8️⃣ **product_returns** - Pengembalian Produk
Menyimpan data return/pengembalian.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint | Primary Key |
| **order_id** | bigint | 🔗 FK ke `orders` |
| **user_id** | bigint | 🔗 FK ke `users` (pembeli) |
| **kurir_id** | bigint | 🔗 FK ke `users` (kurir ambil return) |
| type | enum | 'refund' atau 'replacement' |
| status | enum | Status return |
| reason | text | Alasan return |
| evidence | varchar | Bukti foto |

---

## 🔵 TABEL SISTEM LARAVEL (Bawaan, Bisa Diabaikan)

Tabel berikut adalah **tabel default Laravel** yang dibuat otomatis. **Tidak perlu dipahami mendalam** karena dikelola otomatis oleh framework:

| Tabel | Fungsi |
|-------|--------|
| **cache** | Menyimpan data cache sementara |
| **cache_locks** | Lock untuk cache (mencegah race condition) |
| **sessions** | Menyimpan session login user |
| **password_reset_tokens** | Token untuk reset password |
| **migrations** | Tracking migrasi database yang sudah dijalankan |
| **jobs** | Antrian pekerjaan background (email, notifikasi) |
| **job_batches** | Batch/grup dari jobs |
| **failed_jobs** | Log job yang gagal |

> ⚠️ **Catatan:** Tabel `jobs`, `job_batches`, dan `failed_jobs` adalah untuk **Queue System** Laravel. Digunakan jika ada pekerjaan yang perlu dijalankan di background (misal: kirim email, generate laporan besar). Untuk project ini, tabel tersebut **tidak digunakan aktif**.

---

## 📈 Diagram Relasi Sederhana

```
                    ┌─────────────┐
                    │   markets   │
                    └──────┬──────┘
                           │ 1:N
                           ▼
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│    users    │◄────│  products   │────►│   reviews   │
│  (pedagang) │ 1:N └──────┬──────┘ 1:N └─────────────┘
└──────┬──────┘            │                   ▲
       │                   │                   │
       │ 1:N               │ N:M               │
       ▼                   ▼                   │
┌─────────────┐     ┌─────────────┐     ┌──────┴──────┐
│    users    │────►│   orders    │◄────│    users    │
│  (pembeli)  │ 1:N └──────┬──────┘ 1:N │  (pembeli)  │
└─────────────┘            │            └─────────────┘
                           │ 1:N
                           ▼
                    ┌─────────────┐
                    │ order_items │
                    └─────────────┘
```

---

## 🗂️ Lokasi File Migration

Semua struktur tabel didefinisikan di folder:
```
database/migrations/
├── 0001_01_01_000000_create_users_table.php
├── 2024_01_01_000000_create_markets_table.php
├── 2024_01_01_000001_create_products_table.php
├── 2024_01_01_000002_create_carts_table.php
├── 2024_01_01_000003_create_orders_table.php
├── 2024_01_01_000005_create_reviews_table.php
└── 2024_01_01_000006_create_returns_table.php
```

---

## 🔑 Ringkasan Foreign Key

| Tabel | Foreign Key | Reference |
|-------|-------------|-----------|
| products | user_id | users.id |
| products | market_id | markets.id |
| carts | user_id | users.id |
| carts | product_id | products.id |
| orders | user_id | users.id |
| orders | kurir_id | users.id |
| order_items | order_id | orders.id |
| order_items | product_id | products.id |
| reviews | user_id | users.id |
| reviews | product_id | products.id |
| reviews | order_id | orders.id |
| product_returns | order_id | orders.id |
| product_returns | user_id | users.id |
| product_returns | kurir_id | users.id |
