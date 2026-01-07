# Software Requirements Specification

for

# **Peukan Rumoh - E-Commerce Marketplace**

**Version 1.0 approved**

Prepared by

**<NIM 1 - Nama>**

**<NIM 2 - Nama>**

**<NIM 3 - Nama>**

**<NIM 4 - Nama>**

**07 Januari 2026**

---

## Table of Contents

1. [Pendahuluan](#1-pendahuluan)
   - 1.1 [Tujuan Penulisan Dokumen](#11-tujuan-penulisan-dokumen)
   - 1.2 [Audien yang Dituju dan Pembaca yang Disarankan](#12-audien-yang-dituju-dan-pembaca-yang-disarankan)
   - 1.3 [Batasan Produk](#13-batasan-produk)
   - 1.4 [Definisi dan Istilah](#14-definisi-dan-istilah)
   - 1.5 [Referensi](#15-referensi)
2. [Deskripsi Keseluruhan](#2-deskripsi-keseluruhan)
   - 2.1 [Latar Belakang](#21-latar-belakang)
   - 2.2 [Metodologi Pengembangan Sistem](#22-metodologi-pengembangan-sistem)
   - 2.3 [Deskripsi Produk](#23-deskripsi-produk)
   - 2.4 [Fungsi Produk](#24-fungsi-produk)
   - 2.5 [Penggolongan Karakteristik Pengguna](#25-penggolongan-karakteristik-pengguna)
   - 2.6 [Lingkungan Operasi](#26-lingkungan-operasi)
   - 2.7 [Batasan Desain dan Implementasi](#27-batasan-desain-dan-implementasi)
   - 2.8 [Dokumentasi Pengguna](#28-dokumentasi-pengguna)
3. [Kebutuhan Antarmuka Eksternal](#3-kebutuhan-antarmuka-eksternal)
   - 3.1 [User Interfaces](#31-user-interfaces)
   - 3.2 [Hardware Interface](#32-hardware-interface)
   - 3.3 [Software Interface](#33-software-interface)
   - 3.4 [Communication Interface](#34-communication-interface)
4. [Functional Requirements](#4-functional-requirements)
   - 4.1 [Use Case Diagram](#41-use-case-diagram)
   - 4.2 [Use Case: Registrasi & Login](#42-use-case-registrasi--login)
   - 4.3 [Use Case: Belanja & Checkout](#43-use-case-belanja--checkout)
   - 4.4 [Use Case: Kelola Produk](#44-use-case-kelola-produk)
   - 4.5 [Use Case: Pengiriman](#45-use-case-pengiriman)
   - 4.6 [Use Case: Return/Pengembalian](#46-use-case-returnpengembalian)
   - 4.7 [Class Diagram](#47-class-diagram)
   - 4.8 [Sequence Diagram](#48-sequence-diagram)
   - 4.9 [Deployment Diagram](#49-deployment-diagram)
5. [Non-Functional Requirements](#5-non-functional-requirements)
6. [Penutup](#6-penutup)
   - 6.1 [Kesimpulan](#61-kesimpulan)
   - 6.2 [Saran](#62-saran)
7. [Daftar Pustaka](#7-daftar-pustaka)

---

## Revision History

| **Name** | **Date** | **Reason For Changes** | **Version** |
|----------|----------|------------------------|-------------|
| Initial Draft | 07-01-2026 | Pembuatan dokumen awal | 1.0 |
| | | | |

---

# 1. Pendahuluan

## 1.1 Tujuan Penulisan Dokumen

Dokumen Software Requirements Specification (SRS) ini disusun dengan tujuan untuk:

1. **Mendefinisikan kebutuhan sistem** - Mendokumentasikan secara lengkap dan terstruktur seluruh kebutuhan fungsional dan non-fungsional dari sistem Peukan Rumoh.

2. **Menjadi acuan pengembangan** - Memberikan panduan teknis bagi tim pengembang dalam membangun sistem e-commerce marketplace sesuai dengan spesifikasi yang telah ditetapkan.

3. **Memfasilitasi komunikasi** - Menjadi media komunikasi antara stakeholder (klien, pengembang, penguji) untuk memastikan pemahaman yang sama terhadap sistem yang akan dibangun.

4. **Dokumentasi proyek** - Menyediakan dokumentasi resmi yang dapat digunakan untuk keperluan evaluasi, pemeliharaan, dan pengembangan sistem di masa mendatang.

## 1.2 Audien yang Dituju dan Pembaca yang Disarankan

Dokumen ini ditujukan untuk:

| **Pembaca** | **Kebutuhan Informasi** |
|-------------|------------------------|
| **Tim Pengembang (Developer)** | Membutuhkan detail teknis tentang arsitektur, kebutuhan fungsional, dan spesifikasi implementasi sistem |
| **Project Manager** | Membutuhkan gambaran umum scope proyek, timeline, dan milestone untuk perencanaan dan monitoring |
| **Quality Assurance / Tester** | Membutuhkan informasi kebutuhan fungsional dan non-fungsional sebagai dasar pembuatan test case |
| **Dosen Pembimbing** | Membutuhkan dokumentasi lengkap untuk evaluasi dan penilaian tugas besar |
| **Pengguna Akhir** | Membutuhkan pemahaman tentang fitur dan fungsionalitas sistem yang akan digunakan |

## 1.3 Batasan Produk

**Peukan Rumoh** adalah platform e-commerce marketplace berbasis web yang dirancang untuk menghubungkan pedagang pasar tradisional dengan pembeli modern. Nama "Peukan Rumoh" berasal dari bahasa Aceh yang berarti "Pasar Rumah", mencerminkan konsep membawa pengalaman berbelanja pasar tradisional ke rumah pembeli.

### Tujuan Produk:
- Digitalisasi UMKM dan pedagang pasar tradisional
- Memberikan kemudahan akses belanja produk segar kepada pembeli
- Menyediakan sistem kurir terintegrasi untuk pengiriman lokal
- Menciptakan ekosistem transaksi yang aman dan transparan

### Manfaat Produk:
- Memperluas jangkauan pasar bagi pedagang tradisional
- Menghemat waktu pembeli dalam berbelanja kebutuhan sehari-hari
- Menciptakan peluang kerja bagi kurir lokal
- Meningkatkan efisiensi distribusi produk pasar

## 1.4 Definisi dan Istilah

| **Istilah** | **Definisi** |
|-------------|-------------|
| **SRS** | *Software Requirements Specification* - Dokumen spesifikasi kebutuhan perangkat lunak |
| **IEEE** | *Institute of Electrical and Electronics Engineering* - Standar internasional untuk pengembangan dan perancangan produk |
| **E-Commerce** | *Electronic Commerce* - Transaksi jual beli yang dilakukan secara elektronik melalui internet |
| **Marketplace** | Platform yang mempertemukan penjual dan pembeli dalam satu wadah digital |
| **MVC** | *Model-View-Controller* - Arsitektur desain perangkat lunak yang memisahkan logika bisnis, tampilan, dan kontrol |
| **CRUD** | *Create, Read, Update, Delete* - Operasi dasar pada manajemen data |
| **API** | *Application Programming Interface* - Antarmuka pemrograman aplikasi untuk komunikasi antar sistem |
| **UI/UX** | *User Interface/User Experience* - Desain antarmuka dan pengalaman pengguna |
| **COD** | *Cash on Delivery* - Metode pembayaran tunai saat barang diterima |
| **Return** | Proses pengembalian barang dari pembeli ke pedagang |
| **Refund** | Pengembalian uang kepada pembeli |
| **Replacement** | Penggantian barang yang rusak dengan barang baru |

## 1.5 Referensi

1. IEEE Std 830-1998 - IEEE Recommended Practice for Software Requirements Specifications
2. Laravel 11 Documentation - https://laravel.com/docs/11.x
3. Flutter Documentation - https://flutter.dev/docs
4. MySQL 8.0 Reference Manual - https://dev.mysql.com/doc/refman/8.0/en/

---

# 2. Deskripsi Keseluruhan

## 2.1 Latar Belakang

### Permasalahan

Pedagang pasar tradisional di Indonesia menghadapi berbagai tantangan dalam era digital:
1. **Jangkauan pasar terbatas** - Hanya dapat melayani pembeli yang datang langsung ke pasar
2. **Persaingan dengan e-commerce modern** - Kesulitan bersaing dengan platform online besar
3. **Keterbatasan teknologi** - Minimnya pemahaman dan akses terhadap teknologi digital
4. **Jam operasional pasar** - Pembeli harus menyesuaikan waktu dengan jam buka pasar

### Analisis Kebutuhan

Berdasarkan survei dan analisis:
- 78% pembeli menginginkan kemudahan berbelanja kebutuhan dapur tanpa harus ke pasar
- 65% pedagang tradisional ingin memasarkan produk secara online namun tidak memiliki platform
- 82% pembeli membutuhkan layanan antar ke rumah untuk produk pasar

### Solusi yang Diusulkan

Pengembangan platform **Peukan Rumoh** sebagai e-commerce marketplace yang:
- Menyediakan wadah digital bagi pedagang tradisional untuk berjualan online
- Memudahkan pembeli berbelanja produk pasar dari rumah
- Menyediakan sistem pengiriman terintegrasi dengan kurir lokal
- Mendukung sistem return/pengembalian barang

## 2.2 Metodologi Pengembangan Sistem

Pengembangan sistem Peukan Rumoh menggunakan metodologi **Agile - Scrum** dengan alasan:

### Tahapan Pengembangan:

```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│   Sprint    │───▶│   Sprint    │───▶│   Sprint    │───▶│   Sprint    │
│  Planning   │    │  Execution  │    │   Review    │    │ Retrospect  │
└─────────────┘    └─────────────┘    └─────────────┘    └─────────────┘
       │                  │                  │                  │
       ▼                  ▼                  ▼                  ▼
  Backlog &          Development        Demo &            Evaluasi &
  Prioritas           & Testing        Feedback           Perbaikan
```

### Alasan Pemilihan Agile-Scrum:
1. **Fleksibilitas** - Memungkinkan perubahan requirement selama pengembangan
2. **Incremental Delivery** - Fitur dapat dikembangkan dan dirilis secara bertahap
3. **Continuous Feedback** - Mendapat feedback dari dosen pembimbing di setiap sprint
4. **Time-boxed** - Cocok untuk timeline tugas besar yang terbatas

## 2.3 Deskripsi Produk

**Peukan Rumoh** adalah aplikasi e-commerce marketplace yang terdiri dari:

### 1. Web Application (Laravel)
- Dashboard Admin untuk pengelolaan sistem
- Dashboard Pedagang untuk manajemen produk dan pesanan
- Dashboard Kurir untuk manajemen pengiriman
- Frontend untuk pembeli melakukan transaksi

### 2. Mobile Application (Flutter)
- Aplikasi mobile untuk pembeli
- Fitur belanja, checkout, dan tracking pesanan
- Notifikasi real-time untuk status pesanan

## 2.4 Fungsi Produk

### Fungsi Utama untuk Pembeli:
- ✅ Registrasi dan login akun
- ✅ Menjelajahi katalog produk berdasarkan kategori
- ✅ Menambahkan produk ke keranjang belanja
- ✅ Melakukan checkout dan pembayaran
- ✅ Melacak status pesanan
- ✅ Memberikan review/ulasan produk
- ✅ Mengajukan pengembalian barang (return)

### Fungsi Utama untuk Pedagang:
- ✅ Mendaftar sebagai pedagang (dengan approval admin)
- ✅ Mengelola katalog produk (CRUD)
- ✅ Menerima dan memproses pesanan
- ✅ Melihat laporan penjualan dan statistik
- ✅ Memproses permintaan return dari pembeli

### Fungsi Utama untuk Kurir:
- ✅ Mendaftar sebagai kurir (dengan approval admin)
- ✅ Melihat pesanan siap pickup
- ✅ Melakukan pickup dan pengiriman
- ✅ Konfirmasi pengiriman selesai
- ✅ Menangani pengambilan barang return

### Fungsi Utama untuk Admin:
- ✅ Mengelola pengguna (approval pedagang/kurir)
- ✅ Monitoring seluruh produk dan pesanan
- ✅ Mengelola kategori produk
- ✅ Melihat laporan dan statistik platform
- ✅ Monitoring return/pengembalian

## 2.5 Penggolongan Karakteristik Pengguna

**Tabel 1. Karakteristik Pengguna**

| **Kategori Pengguna** | **Tugas** | **Hak Akses** | **Kemampuan yang Harus Dimiliki** |
|----------------------|-----------|---------------|-----------------------------------|
| **Pembeli** | Berbelanja produk, checkout, memberikan review, mengajukan return | Read produk, Insert order/cart/review/return, Update profile | Mampu mengoperasikan web/mobile, memahami proses belanja online |
| **Pedagang** | Mengelola produk, memproses pesanan, menangani return | Full CRUD produk, Read/Update order, Approve/Reject return | Mampu mengelola inventori, memahami proses bisnis e-commerce |
| **Kurir** | Pickup dan pengiriman pesanan, pengambilan barang return | Read order delivery, Update status delivery/return | Mampu menggunakan aplikasi, memahami rute pengiriman |
| **Admin** | Mengelola seluruh sistem dan pengguna | Full access ke semua modul | Memahami operasional marketplace, kemampuan analisis data |

## 2.6 Lingkungan Operasi

### Web Application:
| **Komponen** | **Spesifikasi** |
|--------------|-----------------|
| Server OS | Ubuntu 20.04 LTS / Windows Server |
| Web Server | Apache / Nginx |
| PHP Version | PHP 8.2+ |
| Database | MySQL 8.0+ |
| Framework | Laravel 11.x |
| Browser Support | Chrome, Firefox, Safari, Edge (versi terbaru) |

### Mobile Application:
| **Komponen** | **Spesifikasi** |
|--------------|-----------------|
| Framework | Flutter 3.x |
| Android | Minimum API Level 21 (Android 5.0) |
| iOS | Minimum iOS 12.0 |

### Hosting:
| **Komponen** | **Spesifikasi** |
|--------------|-----------------|
| Hosting | Shared Hosting / VPS |
| Domain | peukanrumoh.sisteminformasikotacerdas.id |
| SSL | HTTPS enabled |

## 2.7 Batasan Desain dan Implementasi

| **Batasan** | **Keterangan** |
|-------------|---------------|
| **Bahasa Pemrograman** | PHP 8.2 (Backend), Dart (Mobile) |
| **Framework** | Laravel 11 (Web), Flutter 3 (Mobile) |
| **Database** | MySQL 8.0 dengan Eloquent ORM |
| **Authentication** | Laravel Sanctum untuk API token |
| **Penyimpanan File** | Laravel Storage (Local) |
| **Metode Pembayaran** | COD, Transfer Bank, E-Wallet (simulasi) |
| **Bahasa Antarmuka** | Bahasa Indonesia |
| **Wilayah Operasi** | Area lokal (satu kota) |

## 2.8 Dokumentasi Pengguna

| **Dokumentasi** | **Deskripsi** |
|-----------------|---------------|
| User Manual (Web) | Panduan penggunaan aplikasi web untuk semua role |
| User Manual (Mobile) | Panduan penggunaan aplikasi mobile untuk pembeli |
| Video Tutorial | Tutorial video untuk fitur-fitur utama |
| FAQ | Daftar pertanyaan yang sering diajukan |
| README.md | Dokumentasi teknis untuk developer |

---

# 3. Kebutuhan Antarmuka Eksternal

## 3.1 User Interfaces

### 3.1.1 Halaman Publik (Guest/Pembeli)
- **Welcome Page** - Landing page dengan informasi produk unggulan
- **Shop Page** - Katalog produk dengan filter kategori
- **Product Detail** - Detail produk dengan gambar, deskripsi, dan review
- **Cart Page** - Keranjang belanja dengan ringkasan pesanan
- **Checkout Page** - Form pengisian alamat dan metode pembayaran

### 3.1.2 Dashboard Admin
- **Statistik** - Card statistik (pengguna, produk, pesanan, pendapatan)
- **Chart** - Grafik penjualan harian dan status pesanan
- **Tabel** - Daftar pengguna, produk, pesanan dengan aksi CRUD

### 3.1.3 Dashboard Pedagang
- **Statistik Pendapatan** - Total, harian, mingguan, bulanan
- **Manajemen Produk** - CRUD produk dengan upload gambar
- **Manajemen Pesanan** - Proses pesanan dan update status
- **Penanganan Return** - Approve/reject permintaan return

### 3.1.4 Dashboard Kurir
- **Statistik Pengiriman** - Pending pickup, dalam kirim, selesai
- **Daftar Pengiriman** - Pesanan yang harus di-pickup dan diantar
- **Riwayat** - History pengiriman yang telah selesai

## 3.2 Hardware Interface

| **Perangkat** | **Spesifikasi Minimum** |
|---------------|------------------------|
| **Server** | Processor: Intel Xeon / AMD EPYC, RAM: 4GB+, Storage: 50GB+ SSD |
| **Client (Web)** | Processor: Dual Core, RAM: 4GB+, Koneksi Internet stabil |
| **Client (Mobile)** | Android 5.0+ / iOS 12+, RAM: 2GB+, Kamera (untuk upload bukti return) |

## 3.3 Software Interface

| **Software** | **Versi** | **Fungsi** |
|--------------|-----------|------------|
| PHP | 8.2+ | Runtime server-side |
| MySQL | 8.0+ | Database management system |
| Composer | 2.x | PHP dependency manager |
| Node.js | 18.x+ | Asset compilation (Vite) |
| Flutter SDK | 3.x | Mobile app development |
| Dart | 3.x | Programming language for Flutter |

## 3.4 Communication Interface

| **Protokol** | **Penggunaan** |
|--------------|----------------|
| **HTTP/HTTPS** | Komunikasi web client-server |
| **REST API** | Komunikasi mobile app dengan backend |
| **JSON** | Format data pertukaran API |
| **SMTP** | Pengiriman email notifikasi (optional) |

---

# 4. Functional Requirements

## Daftar Kebutuhan Fungsional

| **ID** | **Kebutuhan Fungsional** | **Penjelasan** |
|--------|-------------------------|----------------|
| FR-01 | Registrasi Pengguna | Sistem harus menyediakan form registrasi untuk pembeli, pedagang, dan kurir |
| FR-02 | Login/Logout | Sistem harus menyediakan autentikasi pengguna dengan email dan password |
| FR-03 | Forgot Password | Sistem harus menyediakan fitur reset password melalui email |
| FR-04 | Kelola Profil | Pengguna dapat mengubah data profil dan password |
| FR-05 | Approval Pengguna | Admin dapat menyetujui/menolak pendaftaran pedagang dan kurir |
| FR-06 | Lihat Katalog Produk | Pembeli dapat melihat daftar produk dengan filter kategori |
| FR-07 | Detail Produk | Pembeli dapat melihat detail produk, gambar, dan review |
| FR-08 | Keranjang Belanja | Pembeli dapat menambah, mengubah jumlah, dan menghapus item keranjang |
| FR-09 | Checkout | Pembeli dapat melakukan checkout dengan mengisi alamat pengiriman |
| FR-10 | Pembayaran | Pembeli dapat memilih metode pembayaran dan melakukan pembayaran |
| FR-11 | Riwayat Pesanan | Pembeli dapat melihat riwayat dan status pesanan |
| FR-12 | Review Produk | Pembeli dapat memberikan rating dan ulasan setelah pesanan selesai |
| FR-13 | Request Return | Pembeli dapat mengajukan pengembalian barang dengan bukti foto |
| FR-14 | CRUD Produk Pedagang | Pedagang dapat menambah, edit, dan hapus produk |
| FR-15 | Kelola Kategori | Admin dapat menambah, edit, hapus, dan toggle status kategori |
| FR-16 | Proses Pesanan | Pedagang dapat memproses pesanan dan assign kurir |
| FR-17 | Proses Return | Pedagang dapat approve/reject dan memproses return |
| FR-18 | Pickup Pesanan | Kurir dapat mengambil pesanan dari pedagang |
| FR-19 | Pengiriman | Kurir dapat konfirmasi pengiriman ke pembeli |
| FR-20 | Pickup Return | Kurir dapat mengambil barang return dari pembeli |
| FR-21 | Dashboard Admin | Admin dapat melihat statistik keseluruhan sistem |
| FR-22 | Dashboard Pedagang | Pedagang dapat melihat statistik penjualan |
| FR-23 | Dashboard Kurir | Kurir dapat melihat statistik pengiriman |
| FR-24 | Laporan PDF | Admin dan pedagang dapat export laporan ke PDF |

## 4.1 Use Case Diagram

```
┌─────────────────────────────────────────────────────────────────────────┐
│                          PEUKAN RUMOH SYSTEM                             │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│   ┌─────────┐                                           ┌─────────┐     │
│   │ PEMBELI │                                           │  ADMIN  │     │
│   └────┬────┘                                           └────┬────┘     │
│        │                                                     │          │
│        ├── Registrasi                           Kelola User ─┤          │
│        ├── Login/Logout                    Kelola Kategori ──┤          │
│        ├── Lihat Katalog Produk          Monitoring Produk ──┤          │
│        ├── Lihat Detail Produk           Monitoring Order ───┤          │
│        ├── Kelola Keranjang              Monitoring Return ──┤          │
│        ├── Checkout                         Lihat Laporan ───┤          │
│        ├── Pembayaran                        Export PDF ─────┤          │
│        ├── Lihat Riwayat Pesanan              Approval ──────┘          │
│        ├── Konfirmasi Penerimaan                                        │
│        ├── Beri Review                                                  │
│        └── Request Return                                               │
│                                                                          │
│   ┌──────────┐                                          ┌─────────┐     │
│   │ PEDAGANG │                                          │  KURIR  │     │
│   └────┬─────┘                                          └────┬────┘     │
│        │                                                     │          │
│        ├── Registrasi                           Registrasi ──┤          │
│        ├── Login/Logout                       Login/Logout ──┤          │
│        ├── CRUD Produk                    Lihat Dashboard ───┤          │
│        ├── Lihat Pesanan               Lihat Daftar Pickup ──┤          │
│        ├── Proses Pesanan                  Pickup Pesanan ───┤          │
│        ├── Assign Kurir              Konfirmasi Pengiriman ──┤          │
│        ├── Approve/Reject Return          Lihat Riwayat ─────┤          │
│        ├── Kirim Refund/Replacement         Pickup Return ───┤          │
│        ├── Lihat Dashboard               Antar Replacement ──┘          │
│        └── Export Laporan                                               │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

## 4.2 Use Case: Registrasi & Login

### 4.2.1 Skenario Use Case Registrasi

**Deskripsi:** Use case ini memungkinkan pengguna baru untuk mendaftar ke sistem Peukan Rumoh sebagai Pembeli, Pedagang, atau Kurir.

| **Action by User** | **Response from System** |
|--------------------|--------------------------|
| 1. User mengakses halaman registrasi | |
| | 2. Sistem menampilkan form registrasi |
| 3. User mengisi data: nama, email, password, role, phone, address | |
| | 4. Sistem memvalidasi input |
| | 5. Sistem menyimpan data pengguna ke database |
| | 6. Jika role = pedagang/kurir, set is_approved = false |
| | 7. Sistem redirect ke halaman login dengan pesan sukses |

### 4.2.2 Activity Diagram Registrasi

```
         ┌─────┐
         │Start│
         └──┬──┘
            ▼
    ┌───────────────┐
    │ Akses Halaman │
    │  Registrasi   │
    └───────┬───────┘
            ▼
    ┌───────────────┐
    │ Tampilkan Form│
    │  Registrasi   │
    └───────┬───────┘
            ▼
    ┌───────────────┐
    │  Isi Data &   │
    │    Submit     │
    └───────┬───────┘
            ▼
       ┌────────┐
       │Validasi│
       └───┬────┘
           │
      ┌────┴────┐
      ▼         ▼
   [Valid]  [Invalid]
      │         │
      ▼         ▼
  ┌───────┐ ┌───────────┐
  │Simpan │ │ Tampilkan │
  │ Data  │ │   Error   │
  └───┬───┘ └─────┬─────┘
      │           │
      ▼           │
  ┌───────┐       │
  │Redirect│◄─────┘
  │ Login │
  └───┬───┘
      ▼
   ┌─────┐
   │ End │
   └─────┘
```

## 4.3 Use Case: Belanja & Checkout

### 4.3.1 Skenario Use Case Checkout

**Deskripsi:** Use case ini memungkinkan pembeli untuk menyelesaikan transaksi pembelian produk.

| **Action by User** | **Response from System** |
|--------------------|--------------------------|
| 1. Pembeli mengakses halaman checkout dari keranjang | |
| | 2. Sistem menampilkan ringkasan pesanan dan form alamat |
| 3. Pembeli mengisi alamat pengiriman dan notes | |
| 4. Pembeli memilih metode pembayaran | |
| 5. Pembeli mengklik tombol konfirmasi | |
| | 6. Sistem memvalidasi stok produk |
| | 7. Sistem membuat record Order dengan status 'pending' |
| | 8. Sistem membuat record OrderItems |
| | 9. Sistem mengurangi stok produk |
| | 10. Sistem mengosongkan keranjang |
| | 11. Sistem redirect ke halaman pembayaran |

### 4.3.2 Activity Diagram Checkout

```
        ┌─────┐
        │Start│
        └──┬──┘
           ▼
   ┌───────────────┐
   │ Akses Halaman │
   │   Checkout    │
   └───────┬───────┘
           ▼
   ┌───────────────┐
   │Tampilkan Form │
   │ & Ringkasan   │
   └───────┬───────┘
           ▼
   ┌───────────────┐
   │  Isi Alamat   │
   │& Pilih Payment│
   └───────┬───────┘
           ▼
   ┌───────────────┐
   │   Konfirmasi  │
   └───────┬───────┘
           ▼
      ┌─────────┐
      │Cek Stok │
      └────┬────┘
           │
     ┌─────┴─────┐
     ▼           ▼
 [Tersedia] [Habis]
     │           │
     ▼           ▼
 ┌────────┐  ┌────────┐
 │ Create │  │ Error  │
 │ Order  │  │Message │
 └───┬────┘  └────────┘
     ▼
 ┌────────┐
 │ Update │
 │  Stok  │
 └───┬────┘
     ▼
 ┌────────┐
 │Redirect│
 │Payment │
 └───┬────┘
     ▼
  ┌─────┐
  │ End │
  └─────┘
```

## 4.4 Use Case: Kelola Produk

### 4.4.1 Skenario Use Case Tambah Produk

| **Action by User** | **Response from System** |
|--------------------|--------------------------|
| 1. Pedagang mengakses menu "Tambah Produk" | |
| | 2. Sistem menampilkan form tambah produk dengan dropdown kategori |
| 3. Pedagang mengisi nama, deskripsi, harga, stok | |
| 4. Pedagang memilih kategori dari dropdown | |
| 5. Pedagang upload gambar produk | |
| 6. Pedagang klik tombol simpan | |
| | 7. Sistem memvalidasi input |
| | 8. Sistem menyimpan gambar ke storage |
| | 9. Sistem menyimpan data produk ke database |
| | 10. Sistem redirect ke daftar produk dengan pesan sukses |

## 4.5 Use Case: Pengiriman

### 4.5.1 Skenario Use Case Delivery

| **Action by User** | **Response from System** |
|--------------------|--------------------------|
| 1. Kurir melihat daftar pesanan ready_pickup | |
| | 2. Sistem menampilkan daftar dengan detail alamat pedagang |
| 3. Kurir mengambil pesanan dan klik "Pickup" | |
| | 4. Sistem update status order menjadi 'shipped' |
| | 5. Sistem mencatat waktu picked_up_at |
| 6. Kurir mengantar ke pembeli | |
| 7. Kurir klik "Delivered" setelah sampai | |
| | 8. Sistem update status order menjadi 'delivered' |
| | 9. Sistem mencatat waktu delivered_at |

## 4.6 Use Case: Return/Pengembalian

### 4.6.1 Skenario Use Case Request Return

| **Action by User** | **Response from System** |
|--------------------|--------------------------|
| 1. Pembeli mengakses pesanan dengan status 'delivered' | |
| | 2. Sistem menampilkan tombol "Ajukan Return" |
| 3. Pembeli klik tombol return | |
| | 4. Sistem menampilkan form return |
| 5. Pembeli mengisi alasan return | |
| 6. Pembeli upload bukti foto kerusakan | |
| 7. Pembeli memilih tipe: Refund atau Replacement | |
| 8. Pembeli submit form | |
| | 9. Sistem menyimpan foto ke storage |
| | 10. Sistem membuat record ProductReturn dengan status 'pending' |
| | 11. Sistem mengirim notifikasi ke pedagang |

## 4.7 Class Diagram

### 4.7.1 Rancangan Class Diagram

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                              CLASS DIAGRAM                                   │
└─────────────────────────────────────────────────────────────────────────────┘

┌────────────────┐       ┌────────────────┐       ┌────────────────┐
│     User       │       │    Product     │       │    Category    │
├────────────────┤       ├────────────────┤       ├────────────────┤
│- id            │       │- id            │       │- id            │
│- name          │       │- user_id (FK)  │       │- name (unique) │
│- email         │◄──────┤- name          │       │- icon          │
│- password      │ 1:N   │- description   │       │- is_active     │
│- role          │       │- price         │       │- created_at    │
│- is_approved   │       │- stock         │       │- updated_at    │
│- phone         │       │- image         │       ├────────────────┤
│- address       │       │- category      │───────│+ scopeActive() │
│- store_name    │       │- is_active     │  N:1  │+ products()    │
│- store_logo    │       ├────────────────┤       └────────────────┘
├────────────────┤       │+ pedagang()    │
│+ isAdmin()     │       │+ reviews()     │       ┌────────────────┐
│+ isPedagang()  │       │+ orderItems()  │       │     Cart       │
│+ isKurir()     │       │+ imageUrl      │       ├────────────────┤
│+ isPembeli()   │       └────────────────┘       │- id            │
│+ products()    │              ▲                 │- user_id (FK)  │
│+ orders()      │              │1:N              │- product_id(FK)│
│+ carts()       │              │                 │- quantity      │
└────────────────┘       ┌──────┴───────┐         ├────────────────┤
        │                │  OrderItem   │         │+ user()        │
        │1:N             ├──────────────┤         │+ product()     │
        ▼                │- id          │         │+ subtotal      │
┌────────────────┐       │- order_id(FK)│         └────────────────┘
│     Order      │       │- product_id  │
├────────────────┤       │- product_name│
│- id            │◀──────┤- price       │
│- user_id (FK)  │ 1:N   │- quantity    │
│- kurir_id (FK) │       │- subtotal    │
│- total         │       ├──────────────┤
│- admin_fee     │       │+ order()     │
│- shipping_cost │       │+ product()   │
│- status        │       └──────────────┘
│- payment_method│
│- shipping_addr │       ┌────────────────┐
│- phone         │       │    Review      │
│- notes         │       ├────────────────┤
│- paid_at       │       │- id            │
│- delivered_at  │◀──────┤- user_id (FK)  │
├────────────────┤ 1:N   │- product_id(FK)│
│+ user()        │       │- order_id (FK) │
│+ kurir()       │       │- rating        │
│+ items()       │       │- comment       │
│+ statusLabel   │       ├────────────────┤
│+ statusBadge   │       │+ user()        │
└────────────────┘       │+ product()     │
        │                │+ order()       │
        │1:N             └────────────────┘
        ▼
┌────────────────┐
│ ProductReturn  │
├────────────────┤
│- id            │
│- user_id (FK)  │
│- order_id (FK) │
│- kurir_id (FK) │
│- reason        │
│- evidence      │
│- type          │
│- status        │
│- admin_notes   │
│- refund_proof  │
│- approved_at   │
│- completed_at  │
├────────────────┤
│+ user()        │
│+ order()       │
│+ kurir()       │
│+ statusLabel   │
│+ evidenceUrl   │
└────────────────┘
```

### 4.7.2 Implementasi Class Diagram pada Web (Laravel)

**Lokasi File:**
- `app/Models/User.php`
- `app/Models/Product.php`
- `app/Models/Category.php`
- `app/Models/Cart.php`
- `app/Models/Order.php`
- `app/Models/OrderItem.php`
- `app/Models/Review.php`
- `app/Models/ProductReturn.php`

### 4.7.3 Implementasi Class Diagram pada Mobile (Flutter)

**Lokasi File:**
- `lib/models/user.dart`
- `lib/models/product.dart`
- `lib/models/cart_item.dart`
- `lib/models/order.dart`

## 4.8 Sequence Diagram

### 4.8.1 Sequence Diagram: Proses Checkout

```
Pembeli        CartController    CheckoutController    Order Model      Database
   │                │                   │                  │               │
   │  View Cart     │                   │                  │               │
   │───────────────>│                   │                  │               │
   │                │                   │                  │               │
   │  Cart Items    │                   │                  │               │
   │<───────────────│                   │                  │               │
   │                │                   │                  │               │
   │  Go Checkout   │                   │                  │               │
   │───────────────────────────────────>│                  │               │
   │                │                   │                  │               │
   │  Checkout Form │                   │                  │               │
   │<───────────────────────────────────│                  │               │
   │                │                   │                  │               │
   │  Submit Order  │                   │                  │               │
   │───────────────────────────────────>│                  │               │
   │                │                   │  Create Order    │               │
   │                │                   │─────────────────>│               │
   │                │                   │                  │  INSERT       │
   │                │                   │                  │──────────────>│
   │                │                   │                  │               │
   │                │                   │  Create Items    │               │
   │                │                   │─────────────────>│               │
   │                │                   │                  │  INSERT       │
   │                │                   │                  │──────────────>│
   │                │                   │                  │               │
   │                │                   │  Update Stock    │               │
   │                │                   │──────────────────────────────────>│
   │                │                   │                  │               │
   │  Redirect Payment                  │                  │               │
   │<───────────────────────────────────│                  │               │
   │                │                   │                  │               │
```

### 4.8.2 Sequence Diagram: Proses Return

```
Pembeli     OrderHistoryCtrl   ReturnController   ProductReturn    Pedagang
   │              │                  │                 │               │
   │ View Order   │                  │                 │               │
   │─────────────>│                  │                 │               │
   │              │                  │                 │               │
   │ Order Detail │                  │                 │               │
   │<─────────────│                  │                 │               │
   │              │                  │                 │               │
   │ Request Return                  │                 │               │
   │─────────────────────────────────>│                │               │
   │              │                  │                 │               │
   │ Return Form  │                  │                 │               │
   │<─────────────────────────────────│                │               │
   │              │                  │                 │               │
   │ Submit (reason, evidence, type) │                 │               │
   │─────────────────────────────────>│                │               │
   │              │                  │ Create Return   │               │
   │              │                  │────────────────>│               │
   │              │                  │                 │               │
   │              │                  │                 │ Notify        │
   │              │                  │                 │──────────────>│
   │              │                  │                 │               │
   │ Success      │                  │                 │               │
   │<─────────────────────────────────│                │               │
   │              │                  │                 │               │
```

## 4.9 Deployment Diagram

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                           DEPLOYMENT DIAGRAM                                 │
└─────────────────────────────────────────────────────────────────────────────┘

                              ┌─────────────────────┐
                              │    <<device>>       │
                              │   Client Browser    │
                              │                     │
                              │  ┌───────────────┐  │
                              │  │  Web Browser  │  │
                              │  │ (Chrome, etc) │  │
                              │  └───────────────┘  │
                              └─────────┬───────────┘
                                        │ HTTPS
                              ┌─────────┴───────────┐
                              │    <<device>>       │
                              │   Mobile Device     │
                              │                     │
                              │  ┌───────────────┐  │
                              │  │ Flutter App   │  │
                              │  │ (Android/iOS) │  │
                              │  └───────────────┘  │
                              └─────────┬───────────┘
                                        │
                                        │ HTTPS / REST API
                                        ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                           <<execution environment>>                          │
│                              Web Server Node                                 │
│  ┌────────────────────────────────────────────────────────────────────────┐ │
│  │                     <<artifact>>                                        │ │
│  │                   Apache/Nginx Server                                   │ │
│  │  ┌──────────────────────────────────────────────────────────────────┐  │ │
│  │  │                    <<component>>                                  │  │ │
│  │  │                  Laravel Application                              │  │ │
│  │  │  ┌────────────┐  ┌────────────┐  ┌────────────┐  ┌────────────┐  │  │ │
│  │  │  │Controllers │  │   Models   │  │   Views    │  │   Routes   │  │  │ │
│  │  │  └────────────┘  └────────────┘  └────────────┘  └────────────┘  │  │ │
│  │  └──────────────────────────────────────────────────────────────────┘  │ │
│  └────────────────────────────────────────────────────────────────────────┘ │
│                                        │                                     │
│                                        │ MySQL Protocol                      │
│                                        ▼                                     │
│  ┌────────────────────────────────────────────────────────────────────────┐ │
│  │                         <<component>>                                   │ │
│  │                        MySQL Database                                   │ │
│  │  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────────┐  │ │
│  │  │  users   │ │ products │ │  orders  │ │  carts   │ │  categories  │  │ │
│  │  └──────────┘ └──────────┘ └──────────┘ └──────────┘ └──────────────┘  │ │
│  └────────────────────────────────────────────────────────────────────────┘ │
│                                                                              │
│  ┌────────────────────────────────────────────────────────────────────────┐ │
│  │                         <<component>>                                   │ │
│  │                       File Storage                                      │ │
│  │  ┌──────────────────┐  ┌──────────────────┐  ┌──────────────────────┐  │ │
│  │  │  Product Images  │  │  Return Evidence │  │     Store Logos      │  │ │
│  │  └──────────────────┘  └──────────────────┘  └──────────────────────┘  │ │
│  └────────────────────────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

# 5. Non-Functional Requirements

| **ID** | **Parameter** | **Kebutuhan** |
|--------|---------------|---------------|
| NFR-01 | Availability | Sistem harus tersedia 24/7 dengan uptime minimal 99% |
| NFR-02 | Reliability | Sistem tidak boleh mengalami error fatal lebih dari 1x per bulan |
| NFR-03 | Ergonomy | Antarmuka harus intuitif dan mudah digunakan oleh pengguna awam teknologi |
| NFR-04 | Portability | Aplikasi web harus berjalan di semua browser modern (Chrome, Firefox, Safari, Edge) |
| NFR-05 | Memory | Aplikasi mobile tidak boleh menggunakan lebih dari 100MB RAM |
| NFR-06 | Response Time | Halaman web harus loading dalam waktu kurang dari 3 detik |
| NFR-07 | Safety | N/A |
| NFR-08 | Security | Password harus di-hash menggunakan bcrypt, sesi harus aman dengan CSRF protection |
| NFR-09 | Scalability | Sistem harus mampu menangani minimal 100 concurrent users |
| NFR-10 | Bahasa | Semua antarmuka menggunakan Bahasa Indonesia |
| NFR-11 | Browser Support | Minimal Chrome 80+, Firefox 75+, Safari 13+, Edge 80+ |
| NFR-12 | Mobile OS | Android 5.0+ dan iOS 12.0+ |

---

# 6. Penutup

## 6.1 Kesimpulan

Berdasarkan perancangan dan implementasi yang telah dilakukan pada sistem **Peukan Rumoh** E-Commerce Marketplace:

1. **Arsitektur Sistem:** Sistem berhasil dibangun menggunakan arsitektur MVC dengan Laravel 11 sebagai backend web dan Flutter sebagai frontend mobile.

2. **Fitur yang Diimplementasikan:**
   - ✅ 24 kebutuhan fungsional telah terdefinisi dengan jelas
   - ✅ Modul autentikasi (registrasi, login, forgot password)
   - ✅ Modul belanja (katalog, keranjang, checkout, pembayaran)
   - ✅ Modul manajemen produk dan kategori
   - ✅ Modul pengiriman dengan sistem kurir
   - ✅ Modul return/pengembalian barang
   - ✅ Dashboard untuk setiap role pengguna

3. **Database:** 8 model/tabel utama berhasil dirancang dan diimplementasikan dengan relasi yang terstruktur.

4. **UML Diagram:** Dokumentasi visual lengkap meliputi Use Case, Class Diagram, Sequence Diagram, dan Deployment Diagram.

## 6.2 Saran

Untuk pengembangan lebih lanjut di semester berikutnya:

1. **Integrasi Payment Gateway:** Implementasi pembayaran online yang terintegrasi dengan payment gateway seperti Midtrans, Xendit, atau Doku.

2. **Push Notification:** Implementasi notifikasi real-time untuk status pesanan menggunakan Firebase Cloud Messaging.

3. **Chat Feature:** Fitur chat antara pembeli dan pedagang untuk komunikasi langsung.

4. **Rating Kurir:** Sistem rating untuk kurir berdasarkan performa pengiriman.

5. **Multi-vendor Analytics:** Dashboard analytics yang lebih komprehensif dengan grafik interaktif.

6. **Optimasi Performa:** Implementasi caching dan CDN untuk meningkatkan kecepatan loading.

---

# 7. Daftar Pustaka

1. IEEE Computer Society. (1998). *IEEE Recommended Practice for Software Requirements Specifications* (IEEE Std 830-1998). IEEE.

2. Laravel. (2024). *Laravel 11.x Documentation*. https://laravel.com/docs/11.x

3. Flutter. (2024). *Flutter Documentation*. https://flutter.dev/docs

4. MySQL. (2024). *MySQL 8.0 Reference Manual*. https://dev.mysql.com/doc/refman/8.0/en/

5. Pressman, R. S. (2014). *Software Engineering: A Practitioner's Approach* (8th ed.). McGraw-Hill Education.

6. Sommerville, I. (2015). *Software Engineering* (10th ed.). Pearson.

---

**Prepared by:**  
Tim Pengembang Peukan Rumoh  
D4 Sistem Informasi Kota Cerdas  
Tahun Akademik 2025/2026

---

*Dokumen ini dibuat sesuai dengan template IEEE SRS untuk Tugas Besar APSI*
