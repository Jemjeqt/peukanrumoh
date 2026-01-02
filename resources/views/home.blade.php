@extends('layouts.app')

@section('title', 'Beranda')

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border-radius: 24px;
        padding: 3rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 280px;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -150px;
        left: 30%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    
    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 55%;
    }
    
    .hero-badge {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }
    
    .hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }
    
    .hero-buttons {
        display: flex;
        gap: 1rem;
    }
    
    .hero-buttons .btn-hero {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .btn-hero-primary {
        background: white;
        color: #11998e;
    }
    
    .btn-hero-primary:hover {
        background: #f0f0f0;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .btn-hero-outline {
        background: transparent;
        color: white;
        border: 2px solid rgba(255,255,255,0.5);
    }
    
    .btn-hero-outline:hover {
        background: rgba(255,255,255,0.1);
        border-color: white;
    }
    
    .hero-image {
        position: absolute;
        right: 40px;
        bottom: 0;
        font-size: 12rem;
        opacity: 0.9;
        z-index: 1;
    }
    
    /* Stats Section */
    .stats-section {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        transition: all 0.3s;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin: 0 auto 1rem;
    }
    
    .stat-icon.green { background: linear-gradient(135deg, #e8f5e9, #c8e6c9); }
    .stat-icon.blue { background: linear-gradient(135deg, #e3f2fd, #bbdefb); }
    .stat-icon.orange { background: linear-gradient(135deg, #fff3e0, #ffe0b2); }
    .stat-icon.purple { background: linear-gradient(135deg, #f3e5f5, #e1bee7); }
    
    .stat-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: var(--text-gray);
    }
    
    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }
    
    .action-card {
        background: white;
        border-radius: 20px;
        padding: 2rem 1.5rem;
        text-align: center;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        transition: all 0.3s;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }
    
    .action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary);
        transform: scaleX(0);
        transition: transform 0.3s;
    }
    
    .action-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(17, 153, 142, 0.15);
        border-color: #11998e;
    }
    
    .action-card:hover::before {
        transform: scaleX(1);
    }
    
    .action-icon {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.25rem;
        margin: 0 auto 1rem;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }
    
    .action-card:nth-child(1) .action-icon { background: linear-gradient(135deg, #e8f5e9, #c8e6c9); }
    .action-card:nth-child(2) .action-icon { background: linear-gradient(135deg, #fff3e0, #ffe0b2); }
    .action-card:nth-child(3) .action-icon { background: linear-gradient(135deg, #e3f2fd, #bbdefb); }
    .action-card:nth-child(4) .action-icon { background: linear-gradient(135deg, #f3e5f5, #e1bee7); }
    
    .action-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }
    
    .action-desc {
        font-size: 0.8rem;
        color: var(--text-gray);
    }
    
    /* Categories Section */
    .section-container {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.35rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .see-all {
        color: #11998e;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        transition: gap 0.3s;
    }
    
    .see-all:hover {
        gap: 0.5rem;
        color: #0d7d74;
    }
    
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 1rem;
    }
    
    .category-card {
        background: linear-gradient(135deg, #f8f9fa, #fff);
        border-radius: 16px;
        padding: 1.25rem 1rem;
        text-align: center;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s;
        border: 1px solid #eee;
    }
    
    .category-card:hover {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(17, 153, 142, 0.15);
        border-color: #11998e;
    }
    
    .category-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .category-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-dark);
    }
    
    /* Promo Banner */
    .promo-section {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .promo-card {
        border-radius: 20px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 180px;
    }
    
    .promo-main {
        background: linear-gradient(135deg, #ff6b35, #f7931e);
    }
    
    .promo-secondary {
        background: linear-gradient(135deg, #5c6bc0, #3949ab);
    }
    
    .promo-card::after {
        content: '';
        position: absolute;
        right: -50px;
        top: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .promo-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }
    
    .promo-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .promo-desc {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 1rem;
    }
    
    .promo-btn {
        display: inline-block;
        background: white;
        color: #333;
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        width: fit-content;
        transition: all 0.3s;
    }
    
    .promo-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .promo-emoji {
        position: absolute;
        right: 20px;
        bottom: 15px;
        font-size: 4rem;
        opacity: 0.8;
    }
    
    /* Footer Info */
    .info-section {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .info-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    
    .info-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        flex-shrink: 0;
    }
    
    .info-content h4 {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .info-content p {
        font-size: 0.8rem;
        color: var(--text-gray);
        margin: 0;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .hero-section {
            padding: 2rem;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-image {
            font-size: 8rem;
            right: 20px;
        }
        
        .stats-section,
        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .categories-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        
        .promo-section {
            grid-template-columns: 1fr;
        }
        
        .info-section {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 576px) {
        .hero-content {
            max-width: 100%;
        }
        
        .hero-image {
            display: none;
        }
        
        .hero-title {
            font-size: 1.5rem;
        }
        
        .stats-section,
        .quick-actions {
            grid-template-columns: 1fr 1fr;
        }
        
        .categories-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <div class="hero-badge">🎉 Selamat datang di Peukan Rumoh!</div>
            <h1 class="hero-title">Belanja Kebutuhan<br>Dapur Jadi Mudah! 🛒</h1>
            <p class="hero-subtitle">Temukan produk segar berkualitas langsung dari pasar tradisional. Harga terjangkau, kualitas terjamin!</p>
            <div class="hero-buttons">
                <a href="{{ route('shop.index') }}" class="btn-hero btn-hero-primary">🛍️ Mulai Belanja</a>
                <a href="{{ route('pembeli.orders.index') }}" class="btn-hero btn-hero-outline">📦 Cek Pesanan</a>
            </div>
        </div>
        <div class="hero-image">🥗</div>
    </div>
    
    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="{{ route('shop.index') }}" class="action-card">
            <div class="action-icon">🛒</div>
            <div class="action-title">Mulai Belanja</div>
            <div class="action-desc">Jelajahi produk segar</div>
        </a>
        <a href="{{ route('cart.index') }}" class="action-card">
            <div class="action-icon">🧺</div>
            <div class="action-title">Keranjang</div>
            <div class="action-desc">Lihat item pilihan</div>
        </a>
        <a href="{{ route('pembeli.orders.index') }}" class="action-card">
            <div class="action-icon">📦</div>
            <div class="action-title">Pesanan Saya</div>
            <div class="action-desc">Lacak pengiriman</div>
        </a>
        <a href="{{ route('profile.index') }}" class="action-card">
            <div class="action-icon">👤</div>
            <div class="action-title">Profil</div>
            <div class="action-desc">Kelola akun Anda</div>
        </a>
    </div>
    
    <!-- Promo Section -->
    <div class="promo-section">
        <div class="promo-card promo-main">
            <div class="promo-label">🔥 Promo Spesial</div>
            <div class="promo-title">Diskon Sayuran Segar!</div>
            <div class="promo-desc">Dapatkan potongan harga untuk pembelian pertama Anda.</div>
            <a href="{{ route('shop.index', ['category' => 'Sayuran']) }}" class="promo-btn">Belanja Sekarang →</a>
            <div class="promo-emoji">🥬</div>
        </div>
        <div class="promo-card promo-secondary">
            <div class="promo-label">✨ Gratis Ongkir</div>
            <div class="promo-title">Min. Belanja 50rb</div>
            <div class="promo-desc">Hemat biaya pengiriman!</div>
            <a href="{{ route('shop.index') }}" class="promo-btn">Lihat Produk →</a>
            <div class="promo-emoji">🚚</div>
        </div>
    </div>
    
    <!-- Categories Section -->
    <div class="section-container">
        <div class="section-header">
            <h2 class="section-title">📁 Kategori Produk</h2>
            <a href="{{ route('shop.index') }}" class="see-all">Lihat Semua →</a>
        </div>
        <div class="categories-grid">
            <a href="{{ route('shop.index', ['category' => 'Sayuran']) }}" class="category-card">
                <span class="category-icon">🥬</span>
                <span class="category-name">Sayuran</span>
            </a>
            <a href="{{ route('shop.index', ['category' => 'Buah']) }}" class="category-card">
                <span class="category-icon">🥭</span>
                <span class="category-name">Buah-buahan</span>
            </a>
            <a href="{{ route('shop.index', ['category' => 'Bumbu']) }}" class="category-card">
                <span class="category-icon">🧄</span>
                <span class="category-name">Bumbu Dapur</span>
            </a>
            <a href="{{ route('shop.index', ['category' => 'Protein']) }}" class="category-card">
                <span class="category-icon">🥚</span>
                <span class="category-name">Protein</span>
            </a>
            <a href="{{ route('shop.index', ['category' => 'Sembako']) }}" class="category-card">
                <span class="category-icon">🍚</span>
                <span class="category-name">Sembako</span>
            </a>
            <a href="{{ route('shop.index', ['category' => 'Daging']) }}" class="category-card">
                <span class="category-icon">🥩</span>
                <span class="category-name">Daging</span>
            </a>
        </div>
    </div>
    
    <!-- Info Cards -->
    <div class="info-section">
        <div class="info-card">
            <div class="info-icon">🚚</div>
            <div class="info-content">
                <h4>Pengiriman Cepat</h4>
                <p>Pesanan diantar dalam waktu singkat</p>
            </div>
        </div>
        <div class="info-card">
            <div class="info-icon">✅</div>
            <div class="info-content">
                <h4>Produk Berkualitas</h4>
                <p>Langsung dari petani & pedagang terpercaya</p>
            </div>
        </div>
        <div class="info-card">
            <div class="info-icon">💬</div>
            <div class="info-content">
                <h4>Layanan Pelanggan</h4>
                <p>Bantuan 24/7 untuk pertanyaan Anda</p>
            </div>
        </div>
    </div>
</div>
@endsection
