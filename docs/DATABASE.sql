-- ============================================
-- PEUKAN RUMOH - DATABASE STRUCTURE
-- ============================================
-- Database: peukan_rumoh
-- Character Set: utf8mb4
-- Collation: utf8mb4_unicode_ci
-- 
-- Jalankan di phpMyAdmin atau MySQL CLI
-- ============================================

-- Buat Database
CREATE DATABASE IF NOT EXISTS `peukan_rumoh` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `peukan_rumoh`;

-- ============================================
-- TABEL: users
-- Menyimpan data semua pengguna
-- ============================================
CREATE TABLE `users` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `email_verified_at` timestamp NULL DEFAULT NULL,
    `password` varchar(255) NOT NULL,
    `role` enum('admin','pedagang','pembeli','kurir') NOT NULL DEFAULT 'pembeli',
    `is_approved` tinyint(1) NOT NULL DEFAULT 0,
    `phone` varchar(255) DEFAULT NULL,
    `address` text DEFAULT NULL,
    `store_name` varchar(255) DEFAULT NULL,
    `store_description` text DEFAULT NULL,
    `store_logo` varchar(255) DEFAULT NULL,
    `remember_token` varchar(100) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL: markets
-- Menyimpan data pasar tradisional
-- ============================================
CREATE TABLE `markets` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `address` text DEFAULT NULL,
    `description` text DEFAULT NULL,
    `is_active` tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL: products
-- Menyimpan data produk pedagang
-- ============================================
CREATE TABLE `products` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` bigint(20) UNSIGNED NOT NULL,
    `market_id` bigint(20) UNSIGNED DEFAULT NULL,
    `name` varchar(255) NOT NULL,
    `description` text DEFAULT NULL,
    `price` decimal(12,2) NOT NULL DEFAULT 0.00,
    `stock` int(11) NOT NULL DEFAULT 0,
    `category` varchar(255) DEFAULT NULL,
    `image` varchar(255) DEFAULT NULL,
    `is_active` tinyint(1) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `products_user_id_foreign` (`user_id`),
    KEY `products_market_id_foreign` (`market_id`),
    CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `products_market_id_foreign` FOREIGN KEY (`market_id`) REFERENCES `markets` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL: carts
-- Keranjang belanja pembeli
-- ============================================
CREATE TABLE `carts` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` bigint(20) UNSIGNED NOT NULL,
    `product_id` bigint(20) UNSIGNED NOT NULL,
    `quantity` int(11) NOT NULL DEFAULT 1,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `carts_user_id_foreign` (`user_id`),
    KEY `carts_product_id_foreign` (`product_id`),
    CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL: orders
-- Data pesanan/transaksi
-- ============================================
CREATE TABLE `orders` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` bigint(20) UNSIGNED NOT NULL,
    `kurir_id` bigint(20) UNSIGNED DEFAULT NULL,
    `status` enum('pending','paid','processing','ready_pickup','shipped','completed','cancelled') NOT NULL DEFAULT 'pending',
    `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
    `shipping_fee` decimal(12,2) NOT NULL DEFAULT 0.00,
    `admin_fee` decimal(12,2) NOT NULL DEFAULT 0.00,
    `total` decimal(12,2) NOT NULL DEFAULT 0.00,
    `shipping_address` text DEFAULT NULL,
    `phone` varchar(255) DEFAULT NULL,
    `notes` text DEFAULT NULL,
    `payment_proof` varchar(255) DEFAULT NULL,
    `paid_at` timestamp NULL DEFAULT NULL,
    `processed_at` timestamp NULL DEFAULT NULL,
    `picked_up_at` timestamp NULL DEFAULT NULL,
    `delivered_at` timestamp NULL DEFAULT NULL,
    `cancelled_at` timestamp NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `orders_user_id_foreign` (`user_id`),
    KEY `orders_kurir_id_foreign` (`kurir_id`),
    CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `orders_kurir_id_foreign` FOREIGN KEY (`kurir_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL: order_items
-- Detail item dalam pesanan
-- ============================================
CREATE TABLE `order_items` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id` bigint(20) UNSIGNED NOT NULL,
    `product_id` bigint(20) UNSIGNED NOT NULL,
    `quantity` int(11) NOT NULL,
    `price` decimal(12,2) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `order_items_order_id_foreign` (`order_id`),
    KEY `order_items_product_id_foreign` (`product_id`),
    CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
    CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL: reviews
-- Ulasan produk dari pembeli
-- ============================================
CREATE TABLE `reviews` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` bigint(20) UNSIGNED NOT NULL,
    `product_id` bigint(20) UNSIGNED NOT NULL,
    `order_id` bigint(20) UNSIGNED NOT NULL,
    `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
    `comment` text DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `reviews_user_id_foreign` (`user_id`),
    KEY `reviews_product_id_foreign` (`product_id`),
    KEY `reviews_order_id_foreign` (`order_id`),
    CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
    CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL: product_returns
-- Data pengembalian/return produk
-- ============================================
CREATE TABLE `product_returns` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id` bigint(20) UNSIGNED NOT NULL,
    `user_id` bigint(20) UNSIGNED NOT NULL,
    `kurir_id` bigint(20) UNSIGNED DEFAULT NULL,
    `replacement_kurir_id` bigint(20) UNSIGNED DEFAULT NULL,
    `type` enum('refund','replacement') NOT NULL DEFAULT 'replacement',
    `status` enum('pending','approved','rejected','pickup','delivering','received','replacement_preparing','replacement_shipping','completed','cancelled') NOT NULL DEFAULT 'pending',
    `reason` text NOT NULL,
    `evidence` varchar(255) DEFAULT NULL,
    `admin_notes` text DEFAULT NULL,
    `refund_proof` varchar(255) DEFAULT NULL,
    `refunded_at` timestamp NULL DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `product_returns_order_id_foreign` (`order_id`),
    KEY `product_returns_user_id_foreign` (`user_id`),
    KEY `product_returns_kurir_id_foreign` (`kurir_id`),
    KEY `product_returns_replacement_kurir_id_foreign` (`replacement_kurir_id`),
    CONSTRAINT `product_returns_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
    CONSTRAINT `product_returns_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `product_returns_kurir_id_foreign` FOREIGN KEY (`kurir_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
    CONSTRAINT `product_returns_replacement_kurir_id_foreign` FOREIGN KEY (`replacement_kurir_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL: cache (Laravel default)
-- ============================================
CREATE TABLE `cache` (
    `key` varchar(255) NOT NULL,
    `value` mediumtext NOT NULL,
    `expiration` int(11) NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
    `key` varchar(255) NOT NULL,
    `owner` varchar(255) NOT NULL,
    `expiration` int(11) NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL: sessions (Laravel default)
-- ============================================
CREATE TABLE `sessions` (
    `id` varchar(255) NOT NULL,
    `user_id` bigint(20) UNSIGNED DEFAULT NULL,
    `ip_address` varchar(45) DEFAULT NULL,
    `user_agent` text DEFAULT NULL,
    `payload` longtext NOT NULL,
    `last_activity` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABEL: password_reset_tokens (Laravel default)
-- ============================================
CREATE TABLE `password_reset_tokens` (
    `email` varchar(255) NOT NULL,
    `token` varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DATA SAMPLE: users
-- ============================================
INSERT INTO `users` (`name`, `email`, `password`, `role`, `is_approved`, `phone`, `address`, `store_name`, `store_description`, `created_at`, `updated_at`) VALUES
('Admin Peukan', 'admin@peukanrumoh.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, '081234567890', 'Kantor Admin', NULL, NULL, NOW(), NOW()),
('Pedagang Demo', 'pedagang@peukanrumoh.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pedagang', 1, '081234567891', 'Pasar Baru, Kios No. 15', 'Toko Sayur Segar', 'Menjual berbagai sayuran segar langsung dari petani', NOW(), NOW()),
('Kurir Demo', 'kurir@peukanrumoh.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kurir', 1, '081234567892', 'Jl. Kurir No. 1', NULL, NULL, NOW(), NOW()),
('Pembeli Demo', 'pembeli@peukanrumoh.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pembeli', 1, '081234567893', 'Jl. Pembeli No. 10', NULL, NULL, NOW(), NOW());

-- ============================================
-- DATA SAMPLE: markets
-- ============================================
INSERT INTO `markets` (`name`, `address`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
('Pasar Baru', 'Jl. Pasar Baru No. 1', 'Pasar tradisional terbesar di kota', 1, NOW(), NOW()),
('Pasar Kota', 'Jl. Kota No. 5', 'Pasar pusat kota', 1, NOW(), NOW());

-- ============================================
-- Selesai!
-- Password default untuk semua akun: password
-- ============================================
