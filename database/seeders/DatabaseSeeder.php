<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================
        // USERS - 1 per role (4 total)
        // ============================================
        
        // Admin
        $admin = User::create([
            'name' => 'Admin Peukan Rumoh',
            'email' => 'admin@peukanrumoh.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_approved' => true,
            'phone' => '081234567890',
            'address' => 'Kantor Dinas Perdagangan',
        ]);

        // Pedagang
        $pedagang = User::create([
            'name' => 'Pedagang Demo',
            'email' => 'pedagang@peukanrumoh.com',
            'password' => Hash::make('password'),
            'role' => 'pedagang',
            'is_approved' => true,
            'phone' => '081234567891',
            'address' => 'Pasar Baru, Kios No. 15',
        ]);

        // Kurir
        $kurir = User::create([
            'name' => 'Kurir Demo',
            'email' => 'kurir@peukanrumoh.com',
            'password' => Hash::make('password'),
            'role' => 'kurir',
            'is_approved' => true,
            'phone' => '081234567892',
            'address' => 'Bandung',
        ]);

        // Pembeli
        $pembeli = User::create([
            'name' => 'Pembeli Demo',
            'email' => 'pembeli@peukanrumoh.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
            'is_approved' => true,
            'phone' => '081234567893',
            'address' => 'Jl. Merdeka No. 10, Bandung',
        ]);

        // ============================================
        // PRODUCTS - 5 produk dengan foto
        // ============================================
        
        $products = [
            [
                'name' => 'Bayam Segar',
                'description' => 'Bayam organik segar dari petani lokal, kaya zat besi dan vitamin.',
                'price' => 8000,
                'stock' => 50,
                'category' => 'Sayuran',
                'image' => 'https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=400',
            ],
            [
                'name' => 'Cabai Merah (250g)',
                'description' => 'Cabai merah segar, pedas dan beraroma.',
                'price' => 25000,
                'stock' => 100,
                'category' => 'Sayuran',
                'image' => 'https://images.unsplash.com/photo-1583119022894-919a68a3d0e3?w=400',
            ],
            [
                'name' => 'Mangga Harum Manis (3pcs)',
                'description' => 'Mangga harum manis super manis dan beraroma.',
                'price' => 45000,
                'stock' => 40,
                'category' => 'Buah',
                'image' => 'https://images.unsplash.com/photo-1553279768-865429fa0078?w=400',
            ],
            [
                'name' => 'Telur Ayam Kampung (10pcs)',
                'description' => 'Telur ayam kampung asli, bergizi tinggi.',
                'price' => 35000,
                'stock' => 60,
                'category' => 'Protein',
                'image' => 'https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?w=400',
            ],
            [
                'name' => 'Beras Premium (5kg)',
                'description' => 'Beras putih premium, pulen dan wangi.',
                'price' => 75000,
                'stock' => 50,
                'category' => 'Sembako',
                'image' => 'https://images.unsplash.com/photo-1536304993881-ff6e9eefa2a6?w=400',
            ],
        ];

        foreach ($products as $product) {
            Product::create(array_merge($product, [
                'user_id' => $pedagang->id,
                'is_active' => true,
            ]));
        }

        echo "✅ Database seeding completed!\n";
        echo "====================================\n";
        echo "📊 DATA SUMMARY:\n";
        echo "- Users: 4 (1 Admin, 1 Pedagang, 1 Kurir, 1 Pembeli)\n";
        echo "- Products: 5\n";
        echo "====================================\n";
        echo "🔐 LOGIN CREDENTIALS (password: 'password'):\n";
        echo "- Admin: admin@peukanrumoh.com\n";
        echo "- Pedagang: pedagang@peukanrumoh.com\n";
        echo "- Kurir: kurir@peukanrumoh.com\n";
        echo "- Pembeli: pembeli@peukanrumoh.com\n";
    }
}
