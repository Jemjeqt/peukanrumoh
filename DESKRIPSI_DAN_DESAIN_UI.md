# 📚 DOKUMENTASI LENGKAP SISTEM PEUKAN RUMOH

---

# DESKRIPSI RANCANGAN PROJEK

## 1. Latar Belakang

**Peukan Rumoh** adalah sebuah platform e-commerce marketplace berbasis web yang dirancang untuk menghubungkan pedagang pasar tradisional dengan pembeli modern. Nama "Peukan Rumoh" berasal dari bahasa Aceh yang berarti "Pasar Rumah", mencerminkan konsep membawa pengalaman berbelanja pasar tradisional ke rumah pembeli melalui teknologi digital.

## 2. Tujuan Projek

| No | Tujuan | Deskripsi |
|---|---------|-----------|
| 1 | **Digitalisasi UMKM**      | Membantu pedagang pasar tradisional memasarkan produk secara online |
| 2 | **Kemudahan Akses**        | Memberikan akses belanja produk segar berkualitas kepada pembeli |
| 3 | **Efisiensi Pengiriman**   | Menyediakan sistem kurir terintegrasi untuk pengiriman lokal |
| 4 | **Transparansi Transaksi** | Menciptakan sistem transaksi yang aman dan transparan |
| 5 | **Manajemen Terpusat**     | Admin dapat memantau dan mengelola seluruh aktivitas marketplace |

## 3. Ruang Lingkup Sistem

### 3.1 Fitur Utama

```
┌─────────────────────────────────────────────────────────────────┐
│                     PEUKAN RUMOH SYSTEM                         │
├─────────────────────────────────────────────────────────────────┤
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐  ┌─────────┐ │
│  │  PEMBELI    │  │  PEDAGANG   │  │   KURIR     │  │  ADMIN  │ │
│  ├─────────────┤  ├─────────────┤  ├─────────────┤  ├─────────┤ │
│  │• Registrasi │  │• Kelola     │  │• Pickup     │  │• Kelola │ │
│  │• Belanja    │  │  Produk     │  │  Pesanan    │  │  User   │ │
│  │• Keranjang  │  │• Terima     │  │• Antar      │  │• Kelola │ │
│  │• Checkout   │  │  Pesanan    │  │  Pesanan    │  │  Produk │ │
│  │• Bayar      │  │• Proses     │  │• Konfirmasi │  │• Monitor│ │
│  │• Review     │  │  Return     │  │  Delivery   │  │  Order  │ │
│  │• Return     │  │• Laporan    │  │• Return     │  │• Laporan│ │
│  └─────────────┘  └─────────────┘  └─────────────┘  └─────────┘ │
└─────────────────────────────────────────────────────────────────┘
```

### 3.2 Alur Bisnis Utama

```
┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐
│ Pembeli  │───▶│ Belanja  │───▶│ Checkout │───▶│  Bayar   │───▶│ Pesanan  │
│ Register │    │ Produk   │    │ & Order  │    │          │    │ Dibuat   │
└──────────┘    └──────────┘    └──────────┘    └──────────┘    └────┬─────┘
                                                                     │
    ┌────────────────────────────────────────────────────────────────┘
    ▼
┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐
│ Pedagang │───▶│  Proses  │───▶│ Kurir    │───▶│ Antar ke │───▶│ Pesanan  │
│ Terima   │    │  Pesanan │    │ Pickup   │    │ Pembeli  │    │ Selesai  │
└──────────┘    └──────────┘    └──────────┘    └──────────┘    └──────────┘
```

### 3.3 Alur Return/Pengembalian

```
┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐
│ Pembeli  │───▶│ Pedagang │───▶│  Kurir   │───▶│ Pedagang │───▶│ Selesai  │
│ Request  │    │ Approve  │    │ Pickup   │    │ Terima   │    │ Refund/  │
│ Return   │    │          │    │ Barang   │    │ Barang   │    │ Replace  │
└──────────┘    └──────────┘    └──────────┘    └──────────┘    └──────────┘
```

## 4. Arsitektur Sistem

### 4.1 Arsitektur MVC (Model-View-Controller)

```
+-----------------------------------------------------------------------+
|                          ARSITEKTUR MVC                               |
+-----------------------------------------------------------------------+
|                                                                       |
|  +-------------+         +-------------+         +-------------+      |
|  |    VIEW     |<------->| CONTROLLER  |<------->|    MODEL    |      |
|  |   (Blade)   |         |    (PHP)    |         |  (Eloquent) |      |
|  +-------------+         +-------------+         +-------------+      |
|  | - auth/     |         | - AuthCtrl  |         | - User      |      |
|  | - shop/     |         | - ShopCtrl  |         | - Product   |      |
|  | - cart/     |         | - CartCtrl  |         | - Cart      |      |
|  | - checkout/ |         | - CheckCtrl |         | - Order     |      |
|  | - pembeli/  |         | - OrderCtrl |         | - OrderItem |      |
|  | - pedagang/ |         | - ProductCt |         | - Review    |      |
|  | - kurir/    |         | - DelivCtrl |         | - Return    |      |
|  | - admin/    |         | - AdminCtrl |         |             |      |
|  +-------------+         +-------------+         +-------------+      |
|         ^                       ^                       ^             |
|         |                       |                       |             |
|         +-----------------------+-----------------------+             |
|                                 |                                     |
|                        +---------------+                              |
|                        |   DATABASE    |                              |
|                        |    MySQL      |                              |
|                        +---------------+                              |
+-----------------------------------------------------------------------+
```

### 4.2 Teknologi yang Digunakan

| Komponen | Teknologi | Versi | Keterangan |
|----------|-----------|-------|------------|
| Backend | Laravel | 11.x | PHP Framework |
| Frontend | Blade | - | Template Engine |
| Database | MySQL | 8.x | Relational Database |
| CSS | Vanilla CSS | - | Custom Styling |
| JavaScript | Vanilla JS | ES6 | Client Interactivity |
| Charts | Chart.js | 4.x | Data Visualization |
| Authentication | Laravel Auth | - | Built-in Auth |
| File Storage | Laravel Storage | - | Local Storage |

### 4.3 Struktur Folder Projek

```
peukan-rumoh/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/           # Controller untuk Admin
│   │       ├── Api/             # Controller untuk API
│   │       ├── Kurir/           # Controller untuk Kurir
│   │       ├── Pedagang/        # Controller untuk Pedagang
│   │       ├── AuthController.php
│   │       ├── CartController.php
│   │       ├── CheckoutController.php
│   │       ├── OrderController.php
│   │       ├── ProfileController.php
│   │       └── ShopController.php
│   └── Models/
│       ├── User.php
│       ├── Product.php
│       ├── Cart.php
│       ├── Order.php
│       ├── OrderItem.php
│       ├── Review.php
│       └── ProductReturn.php
├── database/
│   └── migrations/              # File migrasi database
├── resources/
│   └── views/
│       ├── admin/               # Views Admin (14 files)
│       ├── auth/                # Views Auth (2 files)
│       ├── cart/                # Views Cart (1 file)
│       ├── checkout/            # Views Checkout (3 files)
│       ├── kurir/               # Views Kurir (7 files)
│       ├── layouts/             # Layout templates (3 files)
│       ├── partials/            # Partial views (1 file)
│       ├── pedagang/            # Views Pedagang (12 files)
│       ├── pembeli/             # Views Pembeli (3 files)
│       ├── profile/             # Views Profile (2 files)
│       ├── shop/                # Views Shop (2 files)
│       └── home.blade.php
├── routes/
│   ├── web.php                  # Web routes
│   └── api.php                  # API routes
└── public/
    └── storage/                 # File uploads
```

## 5. Peran Pengguna (User Roles)

| No | Role | Deskripsi | Fitur Utama |
|----|------|-----------|-------------|
| 1 | **Admin** | Pengelola sistem | Kelola user, produk, order, laporan |
| 2 | **Pedagang** | Penjual produk | Kelola produk, terima order, proses return |
| 3 | **Kurir** | Pengantar barang | Pickup, delivery, return delivery |
| 4 | **Pembeli** | Pembeli produk | Belanja, checkout, review, request return |

## 6. Status Pesanan

```
+--------------------------------------------------------------------+
|                       STATUS FLOW PESANAN                          |
+--------------------------------------------------------------------+
|                                                                    |
|  PENDING --> PAID --> PROCESSING --> READY_PICKUP --> SHIPPED      |
|     |                                                    |         |
|     |                                                    v         |
|     |                                             DELIVERED        |
|     |                                                    |         |
|     |                                                    v         |
|     |                                             COMPLETED        |
|     |                                                              |
|     +--------------------> CANCELLED                               |
|                                                                    |
+--------------------------------------------------------------------+
```

| Status | Deskripsi | Actor |
|--------|-----------|-------|
| `pending` | Pesanan dibuat, menunggu pembayaran | Pembeli |
| `paid` | Pembayaran dikonfirmasi | Pembeli |
| `processing` | Sedang diproses oleh pedagang | Pedagang |
| `ready_pickup` | Siap diambil kurir | Pedagang |
| `shipped` | Dalam pengiriman | Kurir |
| `delivered` | Sampai di tujuan | Kurir |
| `completed` | Pesanan selesai | Pembeli |
| `cancelled` | Pesanan dibatalkan | Pembeli/Admin |

---

## 7. Fitur Detail Pengguna

### a. Fitur Pembeli (Customer)

**1. Registrasi dan Login**  
Pengguna baru dapat mendaftar sebagai pembeli dengan mengisi formulir registrasi yang mencakup nama, email, dan password. Sistem akan memvalidasi data dan membuat akun baru. Setelah terdaftar, pembeli dapat login menggunakan email dan password untuk mengakses fitur belanja. Tersedia juga opsi "Ingat Saya" untuk kemudahan login selanjutnya.

**2. Berbelanja Produk (Shopping)**  
Pembeli dapat menjelajahi katalog produk yang tersedia dengan berbagai pilihan kategori seperti Sayuran, Buah, Daging, Ikan, dan lainnya. Sistem menampilkan produk dalam bentuk kartu yang memuat gambar, nama produk, harga, dan nama toko pedagang. Pembeli dapat melihat detail produk termasuk deskripsi lengkap, stok tersedia, dan ulasan dari pembeli lain sebelum memutuskan untuk membeli.

**3. Keranjang Belanja (Cart)**  
Pembeli dapat menambahkan produk ke keranjang belanja dengan memilih jumlah yang diinginkan. Sistem akan menghitung subtotal setiap item, biaya admin sebesar Rp 10.000, dan ongkos kirim Rp 5.000. Pembeli dapat mengubah jumlah produk atau menghapus item dari keranjang sebelum melanjutkan ke proses checkout.

**4. Checkout dan Pembayaran**  
Proses checkout memungkinkan pembeli untuk memasukkan alamat pengiriman lengkap, nomor telepon, dan catatan khusus untuk kurir. Pembeli dapat memilih metode pembayaran yang tersedia yaitu Bayar di Tempat (COD), Transfer Bank, atau E-Wallet. Setelah konfirmasi, sistem akan membuat pesanan dan mengirimkan notifikasi ke pedagang terkait.

**5. Riwayat Pesanan dan Tracking**  
Pembeli dapat melihat seluruh riwayat pesanan yang pernah dilakukan, termasuk status terkini setiap pesanan. Sistem menampilkan progress pesanan mulai dari pending, dibayar, diproses, siap pickup, dalam pengiriman, hingga sampai tujuan. Pembeli dapat melihat detail pesanan termasuk daftar item, total pembayaran, dan informasi pengiriman.

**6. Ulasan Produk (Review)**  
Setelah pesanan selesai dengan status "completed", pembeli dapat memberikan ulasan dan rating bintang 1-5 untuk produk yang telah dibeli. Ulasan ini akan membantu pembeli lain dalam memutuskan pembelian dan memberikan feedback kepada pedagang tentang kualitas produk mereka.

**7. Pengembalian Barang (Return)**  
Jika terdapat masalah dengan produk yang diterima (rusak, tidak sesuai, dll), pembeli dapat mengajukan permintaan pengembalian barang. Pembeli perlu mengisi alasan pengembalian dan mengunggah bukti foto sebagai evidence. Tersedia dua opsi pengembalian yaitu refund (uang kembali) atau replacement (tukar barang baru).

---

### b. Fitur Pedagang (Seller/Merchant)

**1. Registrasi dan Approval**  
Pengguna dapat mendaftar sebagai pedagang dengan mengisi data toko termasuk nama toko, deskripsi, dan logo. Akun pedagang baru akan berstatus "pending approval" dan harus menunggu persetujuan dari admin sebelum dapat mulai berjualan. Setelah disetujui, pedagang dapat mengakses dashboard penjualan.

**2. Manajemen Produk (Product CRUD)**  
Pedagang dapat mengelola katalog produk toko secara lengkap. Fitur ini mencakup menambah produk baru dengan mengisi nama, deskripsi, harga, stok, kategori, dan mengunggah gambar produk. Pedagang juga dapat mengedit informasi produk yang sudah ada, mengaktifkan/menonaktifkan produk, serta menghapus produk yang tidak lagi dijual.

**3. Dashboard Statistik Penjualan**  
Pedagang dapat memantau performa toko melalui dashboard yang menampilkan statistik komprehensif. Dashboard menampilkan total pendapatan, pendapatan hari ini, minggu ini, dan bulan ini. Tersedia juga grafik tren penjualan 7 hari terakhir dan 6 bulan terakhir, serta daftar 5 produk terlaris untuk membantu strategi penjualan.

**4. Pengelolaan Pesanan (Order Management)**  
Pedagang menerima notifikasi setiap ada pesanan baru dari pembeli. Pedagang dapat melihat detail pesanan termasuk daftar item, alamat pengiriman, dan informasi pembeli. Setelah menyiapkan barang, pedagang mengubah status pesanan menjadi "processing" lalu "ready_pickup" sebagai tanda bahwa pesanan siap diambil kurir.

**5. Proses Pengembalian (Return Handling)**  
Ketika pembeli mengajukan pengembalian, pedagang akan menerima permintaan tersebut dengan bukti foto. Pedagang dapat mereview alasan dan evidence yang diberikan, kemudian memutuskan untuk menyetujui (approve) atau menolak (reject) permintaan. Jika disetujui, kurir akan mengambil barang dari pembeli dan mengantarkan kembali ke pedagang.

**6. Monitoring Review Produk**  
Pedagang dapat melihat seluruh ulasan yang diberikan pembeli untuk produk-produk toko mereka. Fitur ini menampilkan rating rata-rata toko, distribusi rating (bintang 1-5), dan komentar detail dari pembeli. Informasi ini membantu pedagang untuk meningkatkan kualitas produk dan layanan.

**7. Laporan Penjualan**  
Pedagang dapat mengakses laporan penjualan lengkap dalam berbagai periode waktu. Laporan mencakup total penjualan, jumlah transaksi, produk terlaris, dan tren penjualan. Pedagang juga dapat mengekspor laporan dalam format PDF untuk keperluan dokumentasi dan analisis bisnis.

---

### c. Fitur Kurir (Courier/Delivery)

**1. Registrasi dan Approval**  
Pengguna dapat mendaftar sebagai kurir dengan mengisi data diri termasuk nama, email, nomor telepon, dan alamat. Sama seperti pedagang, akun kurir baru memerlukan persetujuan admin sebelum dapat mulai bekerja. Setelah disetujui, kurir dapat mengakses dashboard pengiriman.

**2. Dashboard Kurir**  
Dashboard kurir menampilkan ringkasan aktivitas harian termasuk jumlah pesanan siap pickup, pesanan dalam pengiriman, pesanan selesai hari ini, dan total pengiriman. Tersedia juga informasi pendapatan hari ini dan total pendapatan keseluruhan dari ongkos kirim.

**3. Pickup Pesanan**  
Kurir dapat melihat daftar pesanan yang berstatus "ready_pickup" dari berbagai pedagang. Kurir mengambil pesanan dari lokasi pedagang dan mengubah status menjadi "shipped" sebagai tanda bahwa barang sudah dalam perjalanan menuju pembeli. Sistem mencatat waktu pickup untuk tracking.

**4. Pengiriman ke Pembeli (Delivery)**  
Kurir mengantar pesanan ke alamat pembeli sesuai dengan informasi yang tercantum dalam detail pesanan. Setelah barang diterima pembeli, kurir mengubah status menjadi "delivered" dan sistem mencatat waktu pengiriman. Kurir mendapatkan informasi alamat lengkap dan nomor telepon pembeli untuk kemudahan pengiriman.

**5. Riwayat Pengiriman**  
Kurir dapat melihat seluruh riwayat pengiriman yang pernah dilakukan, diurutkan berdasarkan tanggal terbaru. Setiap entri menampilkan detail pesanan, nama pembeli, alamat tujuan, waktu pickup, waktu delivered, dan status pengiriman.

**6. Penanganan Return (Return Pickup)**  
Ketika ada permintaan pengembalian yang disetujui pedagang, kurir bertugas mengambil barang dari rumah pembeli. Kurir melihat daftar return yang siap pickup, mengambil barang dari pembeli, lalu mengantarkan kembali ke pedagang yang bersangkutan. Status return diupdate sesuai progress pengambilan.

**7. Pengiriman Barang Pengganti**  
Untuk kasus return dengan opsi replacement, setelah pedagang menyiapkan barang pengganti, kurir bertugas mengambil barang baru dari pedagang dan mengantarkannya ke pembeli. Sistem tracking mencatat seluruh proses dari pengambilan hingga pengiriman barang pengganti.

---

### d. Fitur Admin (Administrator)

**1. Dashboard Monitoring**  
Admin memiliki akses ke dashboard komprehensif yang menampilkan statistik keseluruhan sistem. Dashboard menampilkan jumlah pembeli, pedagang, kurir, total produk, total pesanan, dan pendapatan platform. Tersedia juga grafik penjualan harian, distribusi pesanan per status, dan notifikasi untuk user yang menunggu approval.

**2. Manajemen Pengguna (User Management)**  
Admin dapat melihat, menambah, mengedit, dan menghapus seluruh akun pengguna dalam sistem. Fitur utama meliputi approval akun pedagang dan kurir baru, mengubah role pengguna, dan menonaktifkan akun bermasalah. Admin juga dapat melihat detail aktivitas setiap pengguna.

**3. Monitoring Produk**  
Admin dapat memantau seluruh produk yang dijual di platform, termasuk melihat detail produk, pedagang pemilik, status aktif/nonaktif, dan stok tersedia. Admin dapat menonaktifkan produk yang melanggar ketentuan atau tidak sesuai standar marketplace.

**4. Monitoring Pesanan**  
Admin memiliki akses untuk melihat seluruh pesanan yang ada di sistem dengan berbagai filter status. Admin dapat melihat detail setiap pesanan termasuk item, pembeli, pedagang, kurir, dan timeline status. Untuk kasus tertentu, admin dapat mengubah status pesanan secara manual.

**5. Pengelolaan Return**  
Admin dapat memonitor seluruh permintaan pengembalian barang di platform. Admin melihat detail return termasuk alasan, bukti, dan status approval dari pedagang. Untuk kasus dispute, admin dapat mengintervensi dan membuat keputusan final terkait permintaan return.

**6. Monitoring Review**  
Admin dapat melihat seluruh ulasan yang diberikan pembeli di platform. Fitur ini menampilkan statistik rating keseluruhan, distribusi rating, dan daftar review terbaru. Admin dapat menghapus review yang tidak pantas atau melanggar ketentuan komunitas.

**7. Laporan Bulanan**  
Admin dapat mengakses laporan bulanan lengkap yang mencakup statistik penjualan, pendapatan admin fee, jumlah transaksi, user baru terdaftar, dan performa keseluruhan platform. Laporan dapat diekspor dalam format PDF untuk dokumentasi dan pelaporan manajemen.

---

# DESAIN UI RANCANGAN PROJEK

## 1. Konsep Desain

### 1.1 Design Philosophy

| Aspek | Implementasi |
|-------|--------------|
| **Color Scheme** | Green Gradient (#11998e → #38ef7d) sebagai warna utama, melambangkan kesegaran produk |
| **Typography** | Modern sans-serif fonts untuk readability |
| **Layout** | Responsive grid system, mobile-first approach |
| **Components** | Card-based design dengan shadow dan rounded corners |
| **Interaction** | Smooth transitions dan hover effects |

### 1.2 Color Palette

```
+-----------------------------------------------------------+
|                      COLOR PALETTE                        |
+-----------------------------------------------------------+
|                                                           |
|  PRIMARY GRADIENT                                         |
|  +---------------------------------------------+          |
|  |  #11998e  ------------------>  #38ef7d  |          |
|  |  (Teal)                        (Green)      |          |
|  +---------------------------------------------+          |
|                                                           |
|  SECONDARY COLORS                                         |
|  +---------+  +---------+  +---------+  +---------+       |
|  |#1a1a2e  |  |#f5f5f5  |  |#888888  |  |#ef4444  |       |
|  |  Dark   |  |  Light  |  |  Gray   |  |  Error  |       |
|  +---------+  +---------+  +---------+  +---------+       |
|                                                           |
|  STATUS COLORS                                            |
|  +---------+  +---------+  +---------+  +---------+       |
|  |#10b981  |  |#f59e0b  |  |#3b82f6  |  |#8b5cf6  |       |
|  | Success |  | Warning |  |  Info   |  | Purple  |       |
|  +---------+  +---------+  +---------+  +---------+       |
|                                                           |
+-----------------------------------------------------------+
```

## 2. Wireframe Layout Utama

### 2.1 Layout Halaman Publik (Guest/Pembeli)

```
+-------------------------------------------------------------------+
|                            NAVBAR                                 |
|  +------+  +-------------------------------+  +---+ +---+ +---+   |
|  | LOGO |  |       Navigation Links        |  |[?]| |[+]| |[@]|   |
|  +------+  +-------------------------------+  +---+ +---+ +---+   |
+-------------------------------------------------------------------+
|                                                                   |
|                          MAIN CONTENT                             |
|  +---------------------------------------------------------+      |
|  |                                                         |      |
|  |                                                         |      |
|  |                   (Dynamic Content Area)                |      |
|  |                                                         |      |
|  |                                                         |      |
|  +---------------------------------------------------------+      |
|                                                                   |
+-------------------------------------------------------------------+
|                            FOOTER                                 |
|  +------------+  +------------+  +------------+  +------------+   |
|  |   About    |  |   Links    |  |  Contact   |  |   Social   |   |
|  +------------+  +------------+  +------------+  +------------+   |
+-------------------------------------------------------------------+
```

### 2.2 Layout Dashboard (Admin/Pedagang/Kurir)

```
+-------------------------------------------------------------------+
|                      TOP NAVIGATION BAR                           |
|  +------+                                       +-------------+   |
|  | LOGO |  Dashboard Title                      | User Menu v |   |
|  +------+                                       +-------------+   |
+--------------+----------------------------------------------------+
|              |                                                    |
|   SIDEBAR    |              MAIN CONTENT AREA                     |
|              |                                                    |
|  +--------+  |  +--------------------------------------------+    |
|  | Dash   |  |  |                                            |    |
|  +--------+  |  |          Statistics Cards Row              |    |
|  | Produk |  |  |                                            |    |
|  +--------+  |  +--------------------------------------------+    |
|  | Order  |  |                                                    |
|  +--------+  |  +--------------------+ +--------------------+     |
|  | Report |  |  |                    | |                    |     |
|  +--------+  |  |   Chart/Table 1    | |   Chart/Table 2    |     |
|  | Return |  |  |                    | |                    |     |
|  +--------+  |  +--------------------+ +--------------------+     |
|  | Review |  |                                                    |
|  +--------+  |  +--------------------------------------------+    |
|  | Profil |  |  |                                            |    |
|  +--------+  |  |              Data Table                    |    |
|              |  |                                            |    |
|              |  +--------------------------------------------+    |
|              |                                                    |
+--------------+----------------------------------------------------+
```

## 3. Mockup Halaman Utama

### 3.1 Halaman Login

```
+---------------------------------------------------------------------+
|                                                                     |
|  +-------------------------+  +-------------------------------+     |
|  |                         |  |                               |     |
|  |    [+] PEUKAN RUMOH     |  |     Selamat Datang!           |     |
|  |                         |  |                               |     |
|  |    Belanja Kebutuhan    |  |  +-------------------------+  |     |
|  |    Dapur Jadi Mudah     |  |  | Email                   |  |     |
|  |                         |  |  +-------------------------+  |     |
|  |    [v] Produk Segar     |  |                               |     |
|  |    [v] Harga Terjangkau |  |  +-------------------------+  |     |
|  |    [v] Antar ke Rumah   |  |  | Password                |  |     |
|  |                         |  |  +-------------------------+  |     |
|  |                         |  |                               |     |
|  |                         |  |  [ ] Ingat saya               |     |
|  |                         |  |                               |     |
|  |                         |  |  +-------------------------+  |     |
|  |                         |  |  |     [*] MASUK           |  |     |
|  |                         |  |  +-------------------------+  |     |
|  |                         |  |                               |     |
|  |                         |  |  Belum punya akun? Daftar     |     |
|  |                         |  |                               |     |
|  +-------------------------+  +-------------------------------+     |
|                                                                     |
+---------------------------------------------------------------------+
```

### 3.2 Halaman Shop (Daftar Produk)

```
+---------------------------------------------------------------------+
|                           NAVBAR                                    |
+---------------------------------------------------------------------+
|                                                                     |
|     [*] Belanja Produk Segar                                        |
|     Pilih produk berkualitas dari pedagang terpercaya               |
|                                                                     |
|  +---------------------------------------------------------------+  |
|  | Semua | Sayuran | Buah | Daging | Ikan | Bumbu | Minuman |... |  |
|  +---------------------------------------------------------------+  |
|                                                                     |
|  +------------+  +------------+  +------------+  +------------+     |
|  |   [IMG]    |  |   [IMG]    |  |   [IMG]    |  |   [IMG]    |     |
|  |            |  |            |  |            |  |            |     |
|  | Produk 1   |  | Produk 2   |  | Produk 3   |  | Produk 4   |     |
|  | Rp 25.000  |  | Rp 30.000  |  | Rp 15.000  |  | Rp 40.000  |     |
|  | Toko ABC   |  | Toko XYZ   |  | Toko ABC   |  | Toko DEF   |     |
|  | [+] Beli   |  | [+] Beli   |  | [+] Beli   |  | [+] Beli   |     |
|  +------------+  +------------+  +------------+  +------------+     |
|                                                                     |
|  +------------+  +------------+  +------------+  +------------+     |
|  |   [IMG]    |  |   [IMG]    |  |   [IMG]    |  |   [IMG]    |     |
|  | ...        |  | ...        |  | ...        |  | ...        |     |
|  +------------+  +------------+  +------------+  +------------+     |
|                                                                     |
|              < 1  2  3  4  5 >  (Pagination)                        |
|                                                                     |
+---------------------------------------------------------------------+
```

### 3.3 Halaman Keranjang

```
+---------------------------------------------------------------------+
|                           NAVBAR                                    |
+---------------------------------------------------------------------+
|                                                                     |
|     [+] Keranjang Belanja                                           |
|                                                                     |
|  Progress: [1 Keranjang]----[2 Checkout]----[3 Bayar]----[4 Selesai]|
|                                                                     |
|  +--------------------------------------+  +--------------------+   |
|  |  DAFTAR PRODUK                       |  |  RINGKASAN BELANJA |   |
|  |                                      |  |                    |   |
|  |  +------+-------------------------+  |  |  Subtotal: Rp XXX  |   |
|  |  |[IMG] | Produk 1                |  |  |  Admin   : Rp 10K  |   |
|  |  |      | Rp 25.000 x [2] = 50K   |  |  |  Ongkir  : Rp 5K   |   |
|  |  |      | [Update] [x] Hapus      |  |  |  ------------------|   |
|  |  +------+-------------------------+  |  |  TOTAL   : Rp XXX  |   |
|  |                                      |  |                    |   |
|  |  +------+-------------------------+  |  |  +--------------+  |   |
|  |  |[IMG] | Produk 2                |  |  |  |[*] Checkout  |  |   |
|  |  |      | Rp 30.000 x [1] = 30K   |  |  |  +--------------+  |   |
|  |  |      | [Update] [x] Hapus      |  |  |                    |   |
|  |  +------+-------------------------+  |  |  [<- Lanjut Belanja]   |
|  |                                      |  |                    |   |
|  +--------------------------------------+  +--------------------+   |
|                                                                     |
+---------------------------------------------------------------------+
```

### 3.4 Halaman Dashboard Pedagang

```
+-----------------------------------------------------------------------+
|  PEUKAN RUMOH | Dashboard Pedagang                   | [*] User v     |
+---------------+-------------------------------------------------------+
|               |                                                       |
|  [+] Dash     |   [*] Statistik Pendapatan                            |
|  -----------  |   +---------+ +---------+ +---------+ +---------+     |
|  [#] Produk   |   |Total    | |Hari Ini | |Minggu   | |Bulan    |     |
|  [=] Pesanan  |   |Rp 5.5M  | |Rp 250K  | |Rp 1.2M  | |Rp 3.5M  |     |
|  [~] Return   |   +---------+ +---------+ +---------+ +---------+     |
|  [*] Review   |                                                       |
|  [+] Laporan  |   +---------------------+ +---------------------+     |
|  -----------  |   |                     | |                     |     |
|  [@] Profil   |   |   [LINE CHART]      | |   [BAR CHART]       |     |
|  [>] Logout   |   |   Pendapatan 7 Hari | |   Produk Terlaris   |     |
|               |   |                     | |                     |     |
|               |   +---------------------+ +---------------------+     |
|               |                                                       |
|               |   [=] Pesanan Terbaru                                 |
|               |   +-----------------------------------------------+   |
|               |   | #001 | Budi   | 3 item | Rp 85K  | [Proses]  |  |
|               |   | #002 | Ani    | 2 item | Rp 45K  | [Proses]  |  |
|               |   | #003 | Cici   | 5 item | Rp 120K | [Proses]  |  |
|               |   +-----------------------------------------------+   |
|               |                                                       |
+---------------+-------------------------------------------------------+
```

## 4. Komponen UI Standar

### 4.1 Button Styles

```
+-----------------------------------------------------------------------+
|                        BUTTON COMPONENTS                              |
+-----------------------------------------------------------------------+
|                                                                       |
|  PRIMARY BUTTON                     SECONDARY BUTTON                  |
|  +----------------------+          +----------------------+           |
|  |  [+] Tambah Keranjang|          |    <- Kembali        |           |
|  |   (Green Gradient)   |          |    (Outline Style)   |           |
|  +----------------------+          +----------------------+           |
|                                                                       |
|  DANGER BUTTON                      SUCCESS BUTTON                    |
|  +----------------------+          +----------------------+           |
|  |   [x] Hapus          |          |    [v] Konfirmasi    |           |
|  |   (Red Background)   |          |    (Green Background)|           |
|  +----------------------+          +----------------------+           |
|                                                                       |
+-----------------------------------------------------------------------+
```

### 4.2 Card Components

```
+-----------------------------------------------------------------------+
|                         CARD COMPONENTS                               |
+-----------------------------------------------------------------------+
|                                                                       |
|  PRODUCT CARD              STAT CARD               ORDER CARD         |
|  +-------------+          +-------------+         +-------------+     |
|  |   [IMAGE]   |          |    [#]      |         | Order #001|     |
|  |             |          |    125      |         | ----------- |     |
|  | Product Name|          |  Products   |         | 3 items     |     |
|  | Rp 25.000   |          |             |         | Rp 85.000   |     |
|  | Store Name  |          |  +12% ^     |         | [PENDING]   |     |
|  | [+] Beli    |          +-------------+         | [Detail]    |     |
|  +-------------+                                  +-------------+     |
|                                                                       |
+-----------------------------------------------------------------------+
```

### 4.3 Form Components

```
+---------------------------------------------------------------------+
|                          FORM COMPONENTS                            |
+---------------------------------------------------------------------+
|                                                                     |
|  TEXT INPUT                         TEXTAREA                        |
|  +-------------------------+       +-------------------------+      |
|  | Label                   |       | Label                   |      |
|  | +---------------------+ |       | +---------------------+ |      |
|  | | Placeholder...      | |       | | Multiple lines...   | |      |
|  | +---------------------+ |       | |                     | |      |
|  +-------------------------+       | +---------------------+ |      |
|                                    +-------------------------+      |
|                                                                     |
|  SELECT DROPDOWN                    RADIO BUTTONS                   |
|  +-------------------------+       +-------------------------+      |
|  | Pilih Kategori       v  |       | ( ) Option A            |      |
|  +-------------------------+       | (*) Option B (selected) |      |
|                                    | ( ) Option C            |      |
|                                    +-------------------------+      |
|                                                                     |
+---------------------------------------------------------------------+
```

### 4.4 Status Badges

```
+---------------------------------------------------------------------+
|                          STATUS BADGES                              |
+---------------------------------------------------------------------+
|                                                                     |
|  +---------+ +---------+ +-----------+ +------------+ +---------+   |
|  | PENDING | |  PAID   | |PROCESSING | |READY PICKUP| | SHIPPED |   |
|  | (Gray)  | | (Blue)  | | (Yellow)  | |  (Orange)  | |(Purple) |   |
|  +---------+ +---------+ +-----------+ +------------+ +---------+  |
|                                                                     |
|  +-----------+ +-----------+ +-----------+                          |
|  | DELIVERED | | COMPLETED | | CANCELLED |                          |
|  |  (Cyan)   | |  (Green)  | |   (Red)   |                          |
|  +-----------+ +-----------+ +-----------+                          |
|                                                                     |
+---------------------------------------------------------------------+
```

## 5. Responsive Design

### 5.1 Breakpoints

| Breakpoint | Width | Target Device |
|------------|-------|---------------|
| Mobile | < 576px | Smartphone Portrait |
| Tablet | 576px - 992px | Tablet / Smartphone Landscape |
| Desktop | > 992px | Laptop / Desktop |

### 5.2 Mobile Layout Adjustments

```
DESKTOP (4 columns)           TABLET (2 columns)        MOBILE (1 column)
┌────┬────┬────┬────┐         ┌────┬────┐               ┌────┐
│    │    │    │    │         │    │    │               │    │
│    │    │    │    │         │    │    │               │    │
└────┴────┴────┴────┘         ├────┼────┤               ├────┤
                              │    │    │               │    │
                              │    │    │               │    │
                              └────┴────┘               ├────┤
                                                        │    │
                                                        └────┘
```

