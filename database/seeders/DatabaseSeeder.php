<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductReturn;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================
        // USERS - Tidak diubah sesuai permintaan
        // ============================================
        
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin Peukan Rumoh',
            'email' => 'admin@peukanrumoh.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_approved' => true,
            'phone' => '081234567890',
            'address' => 'Kantor Dinas Perdagangan Kabupaten Bandung',
        ]);

        // Create Pedagang Users (3 total)
        $pedagang1 = User::create([
            'name' => 'Pedagang Demo',
            'email' => 'pedagang@peukanrumoh.com',
            'password' => Hash::make('password'),
            'role' => 'pedagang',
            'is_approved' => true,
            'phone' => '081234567891',
            'address' => 'Pasar Baru, Kios No. 15',
        ]);

        $pedagang2 = User::create([
            'name' => 'Toko Segar Jaya',
            'email' => 'pedagang2@peukanrumoh.com',
            'password' => Hash::make('password'),
            'role' => 'pedagang',
            'is_approved' => true,
            'phone' => '081234567894',
            'address' => 'Pasar Kosambi, Blok A No. 22',
        ]);

        $pedagang3 = User::create([
            'name' => 'Warung Bu Ani',
            'email' => 'pedagang3@peukanrumoh.com',
            'password' => Hash::make('password'),
            'role' => 'pedagang',
            'is_approved' => true,
            'phone' => '081234567895',
            'address' => 'Pasar Cihapit, Kios No. 8',
        ]);

        // Create Kurir Users (3 total)
        $kurir1 = User::create([
            'name' => 'Kurir Demo',
            'email' => 'kurir@peukanrumoh.com',
            'password' => Hash::make('password'),
            'role' => 'kurir',
            'is_approved' => true,
            'phone' => '081234567892',
            'address' => 'Bandung',
        ]);

        $kurir2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'kurir2@peukanrumoh.com',
            'password' => Hash::make('password'),
            'role' => 'kurir',
            'is_approved' => true,
            'phone' => '081234567896',
            'address' => 'Cimahi',
        ]);

        $kurir3 = User::create([
            'name' => 'Dedi Kurniawan',
            'email' => 'kurir3@peukanrumoh.com',
            'password' => Hash::make('password'),
            'role' => 'kurir',
            'is_approved' => true,
            'phone' => '081234567897',
            'address' => 'Bandung Timur',
        ]);

        // Create Pembeli Users (3 total)
        $pembeli1 = User::create([
            'name' => 'Pembeli Demo',
            'email' => 'pembeli@peukanrumoh.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
            'is_approved' => true,
            'phone' => '081234567893',
            'address' => 'Jl. Merdeka No. 10, Bandung',
        ]);

        $pembeli2 = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'pembeli2@peukanrumoh.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
            'is_approved' => true,
            'phone' => '081234567898',
            'address' => 'Jl. Asia Afrika No. 45, Bandung',
        ]);

        $pembeli3 = User::create([
            'name' => 'Ahmad Hidayat',
            'email' => 'pembeli3@peukanrumoh.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
            'is_approved' => true,
            'phone' => '081234567899',
            'address' => 'Jl. Dago No. 123, Bandung',
        ]);

        // ============================================
        // PRODUCTS - Produk dari 3 Pedagang
        // ============================================
        
        // Products for Pedagang 1 - Pedagang Demo (Sayuran & Bumbu specialist)
        $pedagang1Products = [
            ['name' => 'Bayam Segar', 'description' => 'Bayam organik segar dari petani lokal, kaya zat besi dan vitamin.', 'price' => 8000, 'stock' => 50, 'category' => 'Sayuran', 'image' => 'https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=400'],
            ['name' => 'Cabai Merah (250g)', 'description' => 'Cabai merah segar, pedas dan beraroma.', 'price' => 25000, 'stock' => 100, 'category' => 'Sayuran', 'image' => 'https://images.unsplash.com/photo-1583119022894-919a68a3d0e3?w=400'],
            ['name' => 'Tomat Segar (1kg)', 'description' => 'Tomat merah matang, manis dan segar.', 'price' => 18000, 'stock' => 75, 'category' => 'Sayuran', 'image' => 'https://images.unsplash.com/photo-1546470427-e26264be0b0c?w=400'],
            ['name' => 'Kacang Panjang (500g)', 'description' => 'Kacang panjang segar dan renyah.', 'price' => 10000, 'stock' => 60, 'category' => 'Sayuran', 'image' => 'https://images.unsplash.com/photo-1567375698348-5d9d5ae474c3?w=400'],
            ['name' => 'Kangkung Segar', 'description' => 'Kangkung segar, cocok untuk tumis atau plecing.', 'price' => 6000, 'stock' => 80, 'category' => 'Sayuran', 'image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=400'],
            ['name' => 'Wortel (500g)', 'description' => 'Wortel segar kaya vitamin A untuk kesehatan mata.', 'price' => 12000, 'stock' => 65, 'category' => 'Sayuran', 'image' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=400'],
            ['name' => 'Brokoli Segar', 'description' => 'Brokoli hijau segar, kaya antioksidan.', 'price' => 22000, 'stock' => 40, 'category' => 'Sayuran', 'image' => 'https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?w=400'],
            ['name' => 'Bawang Merah (500g)', 'description' => 'Bawang merah segar untuk bumbu dasar.', 'price' => 35000, 'stock' => 90, 'category' => 'Bumbu', 'image' => 'https://images.unsplash.com/photo-1540148426945-6cf22a6b2f85?w=400'],
            ['name' => 'Bawang Putih (250g)', 'description' => 'Bawang putih segar, wangi dan berkualitas.', 'price' => 20000, 'stock' => 85, 'category' => 'Bumbu', 'image' => 'https://images.unsplash.com/photo-1540148426945-6cf22a6b2f85?w=400'],
            ['name' => 'Jahe Merah (200g)', 'description' => 'Jahe merah untuk jamu dan masakan tradisional.', 'price' => 15000, 'stock' => 60, 'category' => 'Bumbu', 'image' => 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=400'],
        ];

        // Products for Pedagang 2 - Toko Segar Jaya (Buah & Protein specialist)
        $pedagang2Products = [
            ['name' => 'Mangga Harum Manis (3pcs)', 'description' => 'Mangga harum manis super manis dan beraroma.', 'price' => 45000, 'stock' => 40, 'category' => 'Buah', 'image' => 'https://images.unsplash.com/photo-1553279768-865429fa0078?w=400'],
            ['name' => 'Pepaya Segar', 'description' => 'Pepaya matang orange, manis dan kaya vitamin.', 'price' => 15000, 'stock' => 35, 'category' => 'Buah', 'image' => 'https://images.unsplash.com/photo-1517282009859-f000ec3b26fe?w=400'],
            ['name' => 'Pisang Raja (1 sisir)', 'description' => 'Pisang raja berkualitas, manis dan lembut.', 'price' => 25000, 'stock' => 45, 'category' => 'Buah', 'image' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=400'],
            ['name' => 'Apel Fuji (1kg)', 'description' => 'Apel Fuji manis dan renyah dari pegunungan.', 'price' => 55000, 'stock' => 30, 'category' => 'Buah', 'image' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=400'],
            ['name' => 'Jeruk Medan (1kg)', 'description' => 'Jeruk Medan manis dan segar.', 'price' => 35000, 'stock' => 50, 'category' => 'Buah', 'image' => 'https://images.unsplash.com/photo-1547514701-42fee4f2e8be?w=400'],
            ['name' => 'Tempe Segar (2 papan)', 'description' => 'Tempe tradisional buatan tangan, kaya protein nabati.', 'price' => 8000, 'stock' => 100, 'category' => 'Protein', 'image' => 'https://images.unsplash.com/photo-1615485291234-9d694218aeb3?w=400'],
            ['name' => 'Tahu Putih (500g)', 'description' => 'Tahu putih segar, tekstur padat.', 'price' => 10000, 'stock' => 85, 'category' => 'Protein', 'image' => 'https://images.unsplash.com/photo-1624544184628-7d3caebe7a06?w=400'],
            ['name' => 'Telur Ayam Kampung (10pcs)', 'description' => 'Telur ayam kampung asli, bergizi tinggi.', 'price' => 35000, 'stock' => 60, 'category' => 'Protein', 'image' => 'https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?w=400'],
            ['name' => 'Telur Ayam Negeri (1 kg)', 'description' => 'Telur ayam negeri segar pilihan.', 'price' => 28000, 'stock' => 80, 'category' => 'Protein', 'image' => 'https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?w=400'],
            ['name' => 'Alpukat Mentega (3pcs)', 'description' => 'Alpukat mentega lembut dan creamy.', 'price' => 40000, 'stock' => 30, 'category' => 'Buah', 'image' => 'https://images.unsplash.com/photo-1523049673857-eb18f1d7b578?w=400'],
        ];

        // Products for Pedagang 3 - Warung Bu Ani (Sembako, Daging & Ikan specialist)
        $pedagang3Products = [
            ['name' => 'Beras Premium (5kg)', 'description' => 'Beras putih premium, pulen dan wangi.', 'price' => 75000, 'stock' => 50, 'category' => 'Sembako', 'image' => 'https://images.unsplash.com/photo-1536304993881-ff6e9eefa2a6?w=400'],
            ['name' => 'Gula Pasir (1kg)', 'description' => 'Gula pasir premium untuk kebutuhan sehari-hari.', 'price' => 18000, 'stock' => 100, 'category' => 'Sembako', 'image' => 'https://images.unsplash.com/photo-1536304993881-ff6e9eefa2a6?w=400'],
            ['name' => 'Minyak Goreng (2L)', 'description' => 'Minyak goreng sawit berkualitas.', 'price' => 35000, 'stock' => 80, 'category' => 'Sembako', 'image' => 'https://images.unsplash.com/photo-1536304993881-ff6e9eefa2a6?w=400'],
            ['name' => 'Daging Sapi Segar (500g)', 'description' => 'Daging sapi segar berkualitas.', 'price' => 65000, 'stock' => 30, 'category' => 'Daging', 'image' => 'https://images.unsplash.com/photo-1603048297172-c92544798d5a?w=400'],
            ['name' => 'Ayam Kampung Potong', 'description' => 'Ayam kampung segar, sudah dipotong.', 'price' => 85000, 'stock' => 25, 'category' => 'Daging', 'image' => 'https://images.unsplash.com/photo-1587593810167-a84920ea0781?w=400'],
            ['name' => 'Daging Ayam Fillet (500g)', 'description' => 'Fillet dada ayam tanpa tulang.', 'price' => 45000, 'stock' => 40, 'category' => 'Daging', 'image' => 'https://images.unsplash.com/photo-1587593810167-a84920ea0781?w=400'],
            ['name' => 'Ikan Mas Segar (1kg)', 'description' => 'Ikan mas segar dari kolam.', 'price' => 45000, 'stock' => 35, 'category' => 'Ikan', 'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400'],
            ['name' => 'Udang Segar (500g)', 'description' => 'Udang segar pilihan untuk seafood.', 'price' => 55000, 'stock' => 30, 'category' => 'Ikan', 'image' => 'https://images.unsplash.com/photo-1565680018434-b513d5e5fd47?w=400'],
            ['name' => 'Ikan Lele (1kg)', 'description' => 'Ikan lele segar untuk digoreng/pecel.', 'price' => 35000, 'stock' => 40, 'category' => 'Ikan', 'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400'],
            ['name' => 'Cumi-Cumi (500g)', 'description' => 'Cumi-cumi segar untuk tumis atau goreng.', 'price' => 50000, 'stock' => 25, 'category' => 'Ikan', 'image' => 'https://images.unsplash.com/photo-1565680018434-b513d5e5fd47?w=400'],
        ];

        // Create products for each pedagang
        foreach ($pedagang1Products as $product) {
            Product::create(array_merge($product, ['user_id' => $pedagang1->id, 'is_active' => true]));
        }

        foreach ($pedagang2Products as $product) {
            Product::create(array_merge($product, ['user_id' => $pedagang2->id, 'is_active' => true]));
        }

        foreach ($pedagang3Products as $product) {
            Product::create(array_merge($product, ['user_id' => $pedagang3->id, 'is_active' => true]));
        }

        // Get all products
        $allProducts = Product::all();
        $pedagang1ProductIds = Product::where('user_id', $pedagang1->id)->pluck('id')->toArray();
        $pedagang2ProductIds = Product::where('user_id', $pedagang2->id)->pluck('id')->toArray();
        $pedagang3ProductIds = Product::where('user_id', $pedagang3->id)->pluck('id')->toArray();

        // ============================================
        // ORDERS - Komprehensif untuk semua status
        // ============================================
        
        $adminFee = 10000;
        $shippingCost = 5000;

        // Helper function untuk membuat order
        $createOrder = function($buyer, $kurir, $status, $daysAgo, $productIds, $quantities, $notes = null) use ($adminFee, $shippingCost, $allProducts) {
            $orderTotal = 0;
            $orderItems = [];

            foreach ($productIds as $index => $productId) {
                $product = $allProducts->find($productId);
                if ($product) {
                    $quantity = $quantities[$index] ?? 1;
                    $subtotal = $product->price * $quantity;
                    $orderTotal += $subtotal;

                    $orderItems[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal,
                    ];
                }
            }

            $total = $orderTotal + $adminFee + $shippingCost;
            $createdAt = now()->subDays($daysAgo)->subHours(rand(1, 12));
            
            // Set timestamps berdasarkan status
            $paidAt = null;
            $pickedUpAt = null;
            $deliveredAt = null;

            if (in_array($status, ['paid', 'processing', 'ready_pickup', 'shipped', 'delivered', 'completed'])) {
                $paidAt = $createdAt->copy()->addMinutes(rand(10, 60));
            }
            if (in_array($status, ['shipped', 'delivered', 'completed'])) {
                $pickedUpAt = $paidAt ? $paidAt->copy()->addHours(rand(1, 4)) : null;
            }
            if (in_array($status, ['delivered', 'completed'])) {
                $deliveredAt = $pickedUpAt ? $pickedUpAt->copy()->addHours(rand(1, 3)) : null;
            }

            $order = Order::create([
                'user_id' => $buyer->id,
                'kurir_id' => $kurir ? $kurir->id : null,
                'total' => $total,
                'shipping_cost' => $shippingCost,
                'admin_fee' => $adminFee,
                'status' => $status,
                'payment_method' => 'Transfer Bank',
                'shipping_address' => $buyer->address,
                'phone' => $buyer->phone,
                'notes' => $notes ?? 'Pesanan test untuk skenario ' . $status,
                'paid_at' => $paidAt,
                'picked_up_at' => $pickedUpAt,
                'delivered_at' => $deliveredAt,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            return $order;
        };

        // ============================================
        // SKENARIO 1: PENDING - Menunggu Pembayaran
        // ============================================
        $order_pending_1 = $createOrder($pembeli1, null, 'pending', 0, 
            [$pedagang1ProductIds[0], $pedagang1ProductIds[1]], [2, 1],
            'Pesanan baru, pembeli belum bayar'
        );
        
        $order_pending_2 = $createOrder($pembeli2, null, 'pending', 0, 
            [$pedagang2ProductIds[0], $pedagang2ProductIds[1]], [1, 2],
            'Pesanan menunggu pembayaran dari pembeli'
        );
        
        $order_pending_3 = $createOrder($pembeli3, null, 'pending', 1, 
            [$pedagang3ProductIds[0]], [1],
            'Pesanan lama belum dibayar'
        );

        // ============================================
        // SKENARIO 2: PAID - Sudah Dibayar (Menunggu Pedagang Proses)
        // ============================================
        $order_paid_1 = $createOrder($pembeli1, null, 'paid', 0, 
            [$pedagang1ProductIds[2], $pedagang1ProductIds[3]], [1, 3],
            'Pembeli sudah bayar, menunggu pedagang proses'
        );
        
        $order_paid_2 = $createOrder($pembeli2, null, 'paid', 0, 
            [$pedagang2ProductIds[2], $pedagang2ProductIds[3]], [2, 1],
            'Pembayaran berhasil, perlu diproses pedagang'
        );

        // ============================================
        // SKENARIO 3: PROCESSING - Diproses Pedagang
        // ============================================
        $order_processing_1 = $createOrder($pembeli1, null, 'processing', 0, 
            [$pedagang1ProductIds[4], $pedagang1ProductIds[5]], [2, 2],
            'Pedagang sedang menyiapkan pesanan'
        );
        
        $order_processing_2 = $createOrder($pembeli3, null, 'processing', 0, 
            [$pedagang3ProductIds[1], $pedagang3ProductIds[2]], [1, 1],
            'Pesanan sedang dikemas'
        );

        // ============================================
        // SKENARIO 4: READY_PICKUP - Siap Diambil Kurir
        // ============================================
        $order_ready_1 = $createOrder($pembeli1, null, 'ready_pickup', 0, 
            [$pedagang1ProductIds[6], $pedagang1ProductIds[7]], [1, 1],
            'Pesanan siap, menunggu kurir mengambil'
        );
        
        $order_ready_2 = $createOrder($pembeli2, null, 'ready_pickup', 0, 
            [$pedagang2ProductIds[4], $pedagang2ProductIds[5]], [1, 2],
            'Barang sudah siap di toko'
        );
        
        $order_ready_3 = $createOrder($pembeli3, null, 'ready_pickup', 0, 
            [$pedagang3ProductIds[3], $pedagang3ProductIds[4]], [1, 1],
            'Menunggu pickup kurir'
        );

        // ============================================
        // SKENARIO 5: SHIPPED - Dalam Pengiriman
        // ============================================
        $order_shipped_1 = $createOrder($pembeli1, $kurir1, 'shipped', 0, 
            [$pedagang1ProductIds[8], $pedagang1ProductIds[9]], [1, 1],
            'Kurir sedang mengantar pesanan'
        );
        
        $order_shipped_2 = $createOrder($pembeli2, $kurir2, 'shipped', 0, 
            [$pedagang2ProductIds[6], $pedagang2ProductIds[7]], [1, 1],
            'Dalam perjalanan ke alamat pembeli'
        );
        
        $order_shipped_3 = $createOrder($pembeli3, $kurir3, 'shipped', 0, 
            [$pedagang3ProductIds[5], $pedagang3ProductIds[6]], [1, 1],
            'Pengiriman sedang berlangsung'
        );

        // ============================================
        // SKENARIO 6: DELIVERED - Menunggu Konfirmasi Pembeli
        // ============================================
        $order_delivered_1 = $createOrder($pembeli1, $kurir1, 'delivered', 0, 
            [$pedagang1ProductIds[0], $pedagang1ProductIds[2], $pedagang1ProductIds[4]], [1, 1, 1],
            'Barang sudah sampai, menunggu pembeli konfirmasi'
        );
        
        $order_delivered_2 = $createOrder($pembeli2, $kurir2, 'delivered', 0, 
            [$pedagang2ProductIds[0], $pedagang2ProductIds[2]], [1, 1],
            'Sudah diterima pembeli, belum dikonfirmasi'
        );
        
        $order_delivered_3 = $createOrder($pembeli3, $kurir3, 'delivered', 1, 
            [$pedagang3ProductIds[0], $pedagang3ProductIds[1]], [1, 2],
            'Pembeli belum konfirmasi penerimaan'
        );

        // ============================================
        // SKENARIO 7: COMPLETED - Pesanan Selesai
        // ============================================
        // Pesanan selesai dalam 7 hari terakhir untuk statistik
        $order_completed_1 = $createOrder($pembeli1, $kurir1, 'completed', 1, 
            [$pedagang1ProductIds[0], $pedagang1ProductIds[1]], [2, 1],
            'Pesanan selesai - pembeli puas'
        );
        
        $order_completed_2 = $createOrder($pembeli1, $kurir2, 'completed', 2, 
            [$pedagang2ProductIds[0], $pedagang2ProductIds[1], $pedagang2ProductIds[2]], [1, 1, 1],
            'Pesanan selesai - kualitas bagus'
        );
        
        $order_completed_3 = $createOrder($pembeli2, $kurir1, 'completed', 2, 
            [$pedagang1ProductIds[2], $pedagang1ProductIds[3]], [1, 2],
            'Transaksi sukses'
        );
        
        $order_completed_4 = $createOrder($pembeli2, $kurir3, 'completed', 3, 
            [$pedagang3ProductIds[0], $pedagang3ProductIds[1], $pedagang3ProductIds[2]], [1, 2, 1],
            'Pesanan selesai dengan baik'
        );
        
        $order_completed_5 = $createOrder($pembeli3, $kurir2, 'completed', 3, 
            [$pedagang2ProductIds[3], $pedagang2ProductIds[4]], [1, 1],
            'Pengiriman cepat, barang bagus'
        );
        
        $order_completed_6 = $createOrder($pembeli3, $kurir1, 'completed', 4, 
            [$pedagang1ProductIds[4], $pedagang1ProductIds[5], $pedagang1ProductIds[6]], [1, 1, 1],
            'Sayuran segar berkualitas'
        );
        
        $order_completed_7 = $createOrder($pembeli1, $kurir3, 'completed', 5, 
            [$pedagang3ProductIds[3], $pedagang3ProductIds[4]], [1, 1],
            'Daging segar dan berkualitas'
        );
        
        $order_completed_8 = $createOrder($pembeli2, $kurir2, 'completed', 5, 
            [$pedagang2ProductIds[5], $pedagang2ProductIds[6]], [2, 1],
            'Protein nabati segar'
        );
        
        $order_completed_9 = $createOrder($pembeli3, $kurir1, 'completed', 6, 
            [$pedagang1ProductIds[7], $pedagang1ProductIds[8], $pedagang1ProductIds[9]], [1, 1, 1],
            'Bumbu lengkap untuk masakan'
        );
        
        $order_completed_10 = $createOrder($pembeli1, $kurir2, 'completed', 6, 
            [$pedagang3ProductIds[5], $pedagang3ProductIds[6], $pedagang3ProductIds[7]], [1, 1, 1],
            'Seafood segar berkualitas'
        );

        // ============================================
        // SKENARIO 8: CANCELLED - Pesanan Dibatalkan
        // ============================================
        $order_cancelled_1 = $createOrder($pembeli1, null, 'cancelled', 2, 
            [$pedagang1ProductIds[0]], [1],
            'Dibatalkan karena pembeli berubah pikiran'
        );
        
        $order_cancelled_2 = $createOrder($pembeli2, null, 'cancelled', 3, 
            [$pedagang2ProductIds[0], $pedagang2ProductIds[1]], [1, 1],
            'Dibatalkan karena stok habis'
        );
        
        $order_cancelled_3 = $createOrder($pembeli3, $kurir1, 'cancelled', 4, 
            [$pedagang3ProductIds[0]], [1],
            'Dibatalkan setelah pembayaran - refund diproses'
        );

        // ============================================
        // RETURNS - Skenario Return Lengkap
        // ============================================
        
        // Return 1: PENDING - Menunggu Konfirmasi Admin
        ProductReturn::create([
            'user_id' => $pembeli1->id,
            'order_id' => $order_completed_1->id,
            'kurir_id' => null,
            'reason' => 'Barang tidak sesuai dengan deskripsi produk',
            'type' => 'refund',
            'status' => 'pending',
            'admin_notes' => null,
            'created_at' => now()->subHours(5),
            'updated_at' => now()->subHours(5),
        ]);

        // Return 2: APPROVED - Disetujui, menunggu kurir pickup
        ProductReturn::create([
            'user_id' => $pembeli2->id,
            'order_id' => $order_completed_2->id,
            'kurir_id' => null,
            'reason' => 'Sayuran layu saat diterima',
            'type' => 'replacement',
            'status' => 'approved',
            'admin_notes' => 'Return disetujui, harap disiapkan untuk pickup',
            'approved_at' => now()->subHours(3),
            'created_at' => now()->subHours(10),
            'updated_at' => now()->subHours(3),
        ]);

        // Return 3: REJECTED - Ditolak
        ProductReturn::create([
            'user_id' => $pembeli3->id,
            'order_id' => $order_completed_3->id,
            'kurir_id' => null,
            'reason' => 'Saya tidak suka warnanya',
            'type' => 'refund',
            'status' => 'rejected',
            'admin_notes' => 'Alasan tidak valid - preferensi pribadi bukan cacat produk',
            'approved_at' => now()->subDays(1),
            'created_at' => now()->subDays(1)->subHours(5),
            'updated_at' => now()->subDays(1),
        ]);

        // Return 4: PICKUP - Siap diambil kurir
        ProductReturn::create([
            'user_id' => $pembeli1->id,
            'order_id' => $order_completed_4->id,
            'kurir_id' => null,
            'reason' => 'Telur pecah saat pengiriman',
            'type' => 'replacement',
            'status' => 'pickup',
            'admin_notes' => 'Disetujui untuk penggantian barang',
            'approved_at' => now()->subDays(1)->subHours(2),
            'created_at' => now()->subDays(1)->subHours(8),
            'updated_at' => now()->subDays(1)->subHours(2),
        ]);

        // Return 5: DELIVERING - Kurir sedang antar ke pedagang
        ProductReturn::create([
            'user_id' => $pembeli2->id,
            'order_id' => $order_completed_5->id,
            'kurir_id' => $kurir1->id,
            'reason' => 'Ikan tidak segar, berbau tidak sedap',
            'type' => 'refund',
            'status' => 'delivering',
            'admin_notes' => 'Kurir sudah menjemput barang',
            'approved_at' => now()->subDays(1)->subHours(6),
            'picked_up_at' => now()->subDays(1)->subHours(4),
            'created_at' => now()->subDays(1)->subHours(12),
            'updated_at' => now()->subDays(1)->subHours(4),
        ]);

        // Return 6: RECEIVED - Diterima pedagang, menunggu proses
        ProductReturn::create([
            'user_id' => $pembeli3->id,
            'order_id' => $order_completed_6->id,
            'kurir_id' => $kurir2->id,
            'reason' => 'Daging sudah busuk saat diterima',
            'type' => 'replacement',
            'status' => 'received',
            'admin_notes' => 'Barang sudah diterima pedagang, menunggu penggantian',
            'approved_at' => now()->subDays(2)->subHours(10),
            'picked_up_at' => now()->subDays(2)->subHours(8),
            'received_at' => now()->subDays(2)->subHours(5),
            'created_at' => now()->subDays(2)->subHours(16),
            'updated_at' => now()->subDays(2)->subHours(5),
        ]);

        // Return 7: REPLACEMENT_SHIPPING - Barang pengganti dikirim
        ProductReturn::create([
            'user_id' => $pembeli1->id,
            'order_id' => $order_completed_7->id,
            'kurir_id' => $kurir2->id,
            'replacement_kurir_id' => $kurir3->id,
            'reason' => 'Buah masih mentah, tidak matang',
            'type' => 'replacement',
            'status' => 'replacement_shipping',
            'admin_notes' => 'Barang pengganti sudah dikirim',
            'approved_at' => now()->subDays(2)->subHours(20),
            'picked_up_at' => now()->subDays(2)->subHours(18),
            'received_at' => now()->subDays(2)->subHours(14),
            'replacement_shipped_at' => now()->subDays(2)->subHours(6),
            'created_at' => now()->subDays(3),
            'updated_at' => now()->subDays(2)->subHours(6),
        ]);

        // Return 8: REPLACEMENT_DELIVERED - Menunggu konfirmasi pembeli
        ProductReturn::create([
            'user_id' => $pembeli2->id,
            'order_id' => $order_completed_8->id,
            'kurir_id' => $kurir1->id,
            'replacement_kurir_id' => $kurir2->id,
            'reason' => 'Produk kadaluarsa',
            'type' => 'replacement',
            'status' => 'replacement_delivered',
            'admin_notes' => 'Barang pengganti sudah sampai ke pembeli',
            'approved_at' => now()->subDays(3)->subHours(20),
            'picked_up_at' => now()->subDays(3)->subHours(18),
            'received_at' => now()->subDays(3)->subHours(14),
            'replacement_shipped_at' => now()->subDays(3)->subHours(8),
            'replacement_delivered_at' => now()->subDays(3)->subHours(4),
            'created_at' => now()->subDays(4),
            'updated_at' => now()->subDays(3)->subHours(4),
        ]);

        // Return 9: REFUND_SENT - Uang sudah dikirim ke pembeli
        ProductReturn::create([
            'user_id' => $pembeli3->id,
            'order_id' => $order_completed_9->id,
            'kurir_id' => $kurir3->id,
            'reason' => 'Kemasan rusak parah, barang tidak bisa digunakan',
            'type' => 'refund',
            'status' => 'refund_sent',
            'admin_notes' => 'Refund sudah dikirim ke rekening pembeli',
            'approved_at' => now()->subDays(3)->subHours(22),
            'picked_up_at' => now()->subDays(3)->subHours(20),
            'received_at' => now()->subDays(3)->subHours(16),
            'refund_sent_at' => now()->subDays(3)->subHours(8),
            'created_at' => now()->subDays(4)->subHours(6),
            'updated_at' => now()->subDays(3)->subHours(8),
        ]);

        // Return 10: REFUND_CONFIRMED - Menunggu konfirmasi pembeli terima uang
        ProductReturn::create([
            'user_id' => $pembeli1->id,
            'order_id' => $order_completed_10->id,
            'kurir_id' => $kurir2->id,
            'reason' => 'Jumlah barang kurang dari pesanan',
            'type' => 'refund',
            'status' => 'refund_confirmed',
            'admin_notes' => 'Refund terkirim, menunggu konfirmasi penerimaan',
            'approved_at' => now()->subDays(4)->subHours(18),
            'picked_up_at' => now()->subDays(4)->subHours(16),
            'received_at' => now()->subDays(4)->subHours(12),
            'refund_sent_at' => now()->subDays(4)->subHours(4),
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(4)->subHours(4),
        ]);

        // Return 11-14: COMPLETED - Beberapa return yang sudah selesai
        ProductReturn::create([
            'user_id' => $pembeli1->id,
            'order_id' => $order_completed_1->id,
            'kurir_id' => $kurir1->id,
            'replacement_kurir_id' => $kurir1->id,
            'reason' => 'Barang rusak saat pengiriman',
            'type' => 'replacement',
            'status' => 'completed',
            'admin_notes' => 'Return selesai - barang diganti',
            'approved_at' => now()->subDays(5)->subHours(20),
            'picked_up_at' => now()->subDays(5)->subHours(18),
            'received_at' => now()->subDays(5)->subHours(14),
            'replacement_shipped_at' => now()->subDays(5)->subHours(8),
            'replacement_delivered_at' => now()->subDays(5)->subHours(4),
            'completed_at' => now()->subDays(5)->subHours(2),
            'created_at' => now()->subDays(6),
            'updated_at' => now()->subDays(5)->subHours(2),
        ]);

        ProductReturn::create([
            'user_id' => $pembeli2->id,
            'order_id' => $order_completed_3->id,
            'kurir_id' => $kurir2->id,
            'reason' => 'Produk tidak sesuai gambar',
            'type' => 'refund',
            'status' => 'completed',
            'admin_notes' => 'Refund berhasil dikonfirmasi pembeli',
            'approved_at' => now()->subDays(5)->subHours(20),
            'picked_up_at' => now()->subDays(5)->subHours(18),
            'received_at' => now()->subDays(5)->subHours(14),
            'refund_sent_at' => now()->subDays(5)->subHours(6),
            'completed_at' => now()->subDays(5)->subHours(2),
            'created_at' => now()->subDays(6)->subHours(6),
            'updated_at' => now()->subDays(5)->subHours(2),
        ]);

        ProductReturn::create([
            'user_id' => $pembeli3->id,
            'order_id' => $order_completed_5->id,
            'kurir_id' => $kurir3->id,
            'replacement_kurir_id' => $kurir2->id,
            'reason' => 'Sayuran sudah layu',
            'type' => 'replacement',
            'status' => 'completed',
            'admin_notes' => 'Penggantian sukses - pembeli puas',
            'approved_at' => now()->subDays(6)->subHours(18),
            'picked_up_at' => now()->subDays(6)->subHours(16),
            'received_at' => now()->subDays(6)->subHours(12),
            'replacement_shipped_at' => now()->subDays(6)->subHours(6),
            'replacement_delivered_at' => now()->subDays(6)->subHours(3),
            'completed_at' => now()->subDays(6)->subHours(1),
            'created_at' => now()->subDays(7),
            'updated_at' => now()->subDays(6)->subHours(1),
        ]);

        ProductReturn::create([
            'user_id' => $pembeli1->id,
            'order_id' => $order_completed_6->id,
            'kurir_id' => $kurir1->id,
            'reason' => 'Bumbu sudah kadaluarsa',
            'type' => 'refund',
            'status' => 'completed',
            'admin_notes' => 'Full refund - pembeli konfirmasi terima uang',
            'approved_at' => now()->subDays(6)->subHours(16),
            'picked_up_at' => now()->subDays(6)->subHours(14),
            'received_at' => now()->subDays(6)->subHours(10),
            'refund_sent_at' => now()->subDays(6)->subHours(4),
            'completed_at' => now()->subDays(6)->subHours(1),
            'created_at' => now()->subDays(7)->subHours(4),
            'updated_at' => now()->subDays(6)->subHours(1),
        ]);

        // ============================================
        // REVIEWS - Review untuk pesanan yang selesai
        // ============================================
        
        $reviewComments = [
            5 => [
                'Produk sangat segar dan berkualitas! Pasti beli lagi.',
                'Pengiriman cepat, barang sesuai deskripsi. Mantap!',
                'Kualitas terbaik, harga terjangkau. Recommended!',
                'Sayuran masih segar seperti baru dipetik. Top!',
                'Pelayanan ramah, produk memuaskan. Terima kasih!',
            ],
            4 => [
                'Produk bagus, cuma packaging bisa lebih rapi lagi.',
                'Kualitas oke, pengiriman agak lama tapi masih wajar.',
                'Barang sesuai pesanan, next time semoga lebih cepat.',
                'Segar dan enak, hanya ukurannya agak kecil.',
            ],
            3 => [
                'Lumayan, sesuai harga. Bisa ditingkatkan lagi.',
                'Standar saja, tidak ada yang istimewa.',
            ],
            2 => [
                'Kurang segar, semoga kedepannya lebih baik.',
            ],
            1 => [
                'Kecewa, barang tidak sesuai harapan.',
            ],
        ];

        // Review untuk pesanan completed
        $completedOrders = Order::where('status', 'completed')->with('items')->get();
        
        foreach ($completedOrders as $index => $order) {
            if ($order->items->count() > 0 && $index < 8) { // Limit reviews
                $item = $order->items->first();
                
                // Random rating with weighted distribution (more 4-5 stars)
                $ratingWeights = [5, 5, 5, 5, 4, 4, 4, 3, 2, 1];
                $rating = $ratingWeights[array_rand($ratingWeights)];
                
                $comments = $reviewComments[$rating];
                $comment = $comments[array_rand($comments)];

                Review::create([
                    'user_id' => $order->user_id,
                    'product_id' => $item->product_id,
                    'order_id' => $order->id,
                    'rating' => $rating,
                    'comment' => $comment,
                    'created_at' => $order->updated_at->addHours(rand(1, 24)),
                    'updated_at' => $order->updated_at->addHours(rand(1, 24)),
                ]);
            }
        }

        // ============================================
        // CART - Sample items di cart pembeli
        // ============================================
        
        // Pembeli 1 punya item di cart
        Cart::create([
            'user_id' => $pembeli1->id,
            'product_id' => $pedagang1ProductIds[0],
            'quantity' => 2,
        ]);
        Cart::create([
            'user_id' => $pembeli1->id,
            'product_id' => $pedagang2ProductIds[0],
            'quantity' => 1,
        ]);

        // Pembeli 2 punya item di cart
        Cart::create([
            'user_id' => $pembeli2->id,
            'product_id' => $pedagang3ProductIds[0],
            'quantity' => 1,
        ]);

        // Pembeli 3 cart kosong (untuk testing checkout baru)

        echo "✅ Database seeding completed successfully!\n";
        echo "====================================\n";
        echo "📊 DATA SUMMARY:\n";
        echo "- Users: 10 (1 Admin, 3 Pedagang, 3 Kurir, 3 Pembeli)\n";
        echo "- Products: 30\n";
        echo "- Orders: Multiple dengan semua status\n";
        echo "  • PENDING: 3 pesanan\n";
        echo "  • PAID: 2 pesanan\n";
        echo "  • PROCESSING: 2 pesanan\n";
        echo "  • READY_PICKUP: 3 pesanan\n";
        echo "  • SHIPPED: 3 pesanan\n";
        echo "  • DELIVERED: 3 pesanan\n";
        echo "  • COMPLETED: 10 pesanan\n";
        echo "  • CANCELLED: 3 pesanan\n";
        echo "- Returns: 14 dengan berbagai status\n";
        echo "- Reviews: 8\n";
        echo "- Cart Items: 3\n";
        echo "====================================\n";
        echo "🔐 LOGIN CREDENTIALS (password: 'password'):\n";
        echo "- Admin: admin@peukanrumoh.com\n";
        echo "- Pedagang: pedagang@peukanrumoh.com\n";
        echo "- Kurir: kurir@peukanrumoh.com\n";
        echo "- Pembeli: pembeli@peukanrumoh.com\n";
    }
}
