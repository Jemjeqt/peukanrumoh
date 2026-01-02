<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peukan Rumoh - Pasar Online Aceh</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Inter', sans-serif;
            background: #fafafa;
            color: #333;
            overflow-x: hidden;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            padding: 4rem 2rem 3rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .hero-container {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        .hero-logo {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.15);
            padding: 0.5rem 1rem;
            border-radius: 30px;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .hero h1 {
            font-size: 2.75rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .hero p {
            font-size: 1.05rem;
            opacity: 0.95;
            max-width: 550px;
            margin: 0 auto 2rem;
            line-height: 1.7;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 0.875rem 1.75rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            border: none;
        }
        
        .btn-white {
            background: white;
            color: #11998e;
        }
        
        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid rgba(255,255,255,0.5);
        }
        
        .btn-outline:hover {
            background: rgba(255,255,255,0.1);
            border-color: white;
        }
        
        /* Product Marquee - 2 Rows */
        .marquee-section {
            background: linear-gradient(180deg, #fff 0%, #f8fffe 100%);
            padding: 2.5rem 0;
            overflow: hidden;
        }
        
        .marquee-section h3 {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 0.5rem;
        }
        
        .marquee-section p {
            text-align: center;
            color: #888;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }
        
        .marquee-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .marquee {
            display: flex;
            animation: marquee-left 30s linear infinite;
        }
        
        .marquee.reverse {
            animation: marquee-right 30s linear infinite;
        }
        
        .marquee:hover,
        .marquee.reverse:hover {
            animation-play-state: paused;
        }
        
        @keyframes marquee-left {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        @keyframes marquee-right {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0); }
        }
        
        .marquee-item {
            flex-shrink: 0;
            width: 180px;
            margin: 0 0.75rem;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 1px solid #eee;
        }
        
        .marquee-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(17, 153, 142, 0.15);
            border-color: #11998e;
        }
        
        .marquee-img {
            width: 100%;
            height: 100px;
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }
        
        .marquee-info {
            padding: 0.75rem;
            text-align: center;
        }
        
        .marquee-name {
            font-weight: 600;
            font-size: 0.85rem;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .marquee-price {
            font-weight: 700;
            color: #11998e;
            font-size: 0.9rem;
        }
        
        /* Stats Bar */
        .stats-bar {
            background: white;
            padding: 2rem;
            color: #333;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        
        .stats-container {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            justify-content: space-around;
            gap: 2rem;
            flex-wrap: wrap;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #11998e;
        }
        
        .stat-label {
            font-size: 0.85rem;
            opacity: 0.8;
            margin-top: 0.25rem;
        }
        
        /* Features Section */
        .features {
            padding: 5rem 2rem;
            background: linear-gradient(180deg, #fafafa 0%, #e8f5e9 100%);
        }
        
        .section-container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-header h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 0.5rem;
        }
        
        .section-header p {
            color: #888;
            font-size: 1rem;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2rem 1.5rem;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            transition: all 0.3s;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #11998e, #38ef7d);
        }
        
        .feature-card:nth-child(2)::before {
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        .feature-card:nth-child(3)::before {
            background: linear-gradient(90deg, #f093fb, #f5576c);
        }
        
        .feature-card:nth-child(4)::before {
            background: linear-gradient(90deg, #4facfe, #00f2fe);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #11998e, #38ef7d);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.25rem;
            box-shadow: 0 8px 20px rgba(17, 153, 142, 0.3);
        }
        
        .feature-card:nth-child(2) .feature-icon {
            background: linear-gradient(135deg, #667eea, #764ba2);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
        
        .feature-card:nth-child(3) .feature-icon {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            box-shadow: 0 8px 20px rgba(245, 87, 108, 0.3);
        }
        
        .feature-card:nth-child(4) .feature-icon {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
        }
        
        .feature-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 0.5rem;
        }
        
        .feature-card p {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.6;
        }
        
        /* Categories Section - 3x3 */
        .categories {
            padding: 5rem 2rem;
            background: linear-gradient(135deg, #667eea15, #764ba215);
        }
        
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .category-card {
            background: white;
            border-radius: 24px;
            padding: 2rem 1.5rem;
            text-align: center;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s;
            border: none;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
        }
        
        .category-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent, rgba(17, 153, 142, 0.05));
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .category-card:hover::after {
            opacity: 1;
        }
        
        .category-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 40px rgba(17, 153, 142, 0.2);
        }
        
        .category-icon {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .category-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a2e;
        }
        
        .category-count {
            font-size: 0.85rem;
            color: #11998e;
            margin-top: 0.35rem;
            font-weight: 600;
        }
        
        /* Reviews Section */
        .reviews {
            padding: 5rem 2rem;
            background: linear-gradient(135deg, #f0f9f6, #e8f5e9);
        }
        
        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .review-card {
            background: white;
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }
        
        .review-card:hover {
            transform: translateY(-5px);
        }
        
        .review-stars {
            color: #ffc107;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }
        
        .review-text {
            font-size: 0.95rem;
            line-height: 1.7;
            color: #555;
            margin-bottom: 1.25rem;
        }
        
        .review-author {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .review-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #11998e, #38ef7d);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
        }
        
        .review-name {
            font-weight: 600;
            color: #1a1a2e;
            font-size: 0.9rem;
        }
        
        .review-location {
            font-size: 0.8rem;
            color: #888;
        }
        
        /* CTA Section */
        .cta {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            padding: 5rem 2rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .cta::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .cta h2 {
            font-size: 2.25rem;
            font-weight: 800;
            margin-bottom: 1rem;
            position: relative;
        }
        
        .cta p {
            font-size: 1.05rem;
            opacity: 0.95;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .cta .btn {
            background: white;
            color: #11998e;
            font-size: 1.1rem;
            padding: 1rem 2.5rem;
        }
        
        /* Footer */
        .footer {
            background: #1a1a2e;
            color: white;
            padding: 3rem 2rem 1.5rem;
        }
        
        .footer-content {
            max-width: 1000px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-brand h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }
        
        .footer-brand h3 span {
            color: #38ef7d;
        }
        
        .footer-brand p {
            color: #888;
            font-size: 0.875rem;
            line-height: 1.6;
        }
        
        .footer-links h4 {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .footer-links a {
            display: block;
            color: #888;
            text-decoration: none;
            font-size: 0.85rem;
            padding: 0.25rem 0;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: #38ef7d;
        }
        
        .footer-bottom {
            border-top: 1px solid #333;
            padding-top: 1.5rem;
            text-align: center;
            color: #666;
            font-size: 0.85rem;
        }
        
        @media (max-width: 992px) {
            .features-grid { grid-template-columns: repeat(2, 1fr); }
            .reviews-grid { grid-template-columns: 1fr; }
        }
        
        @media (max-width: 768px) {
            .hero h1 { font-size: 2rem; }
            .hero { padding: 3rem 1.5rem 2rem; }
            .categories-grid { grid-template-columns: repeat(2, 1fr); }
            .features-grid { grid-template-columns: 1fr; }
            .footer-content { grid-template-columns: 1fr; text-align: center; }
        }
    </style>
</head>
<body>
    <!-- Hero -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-logo">🥬 Peukan Rumoh</div>
            <h1>Pasar Segar di Genggaman Anda</h1>
            <p>Produk segar berkualitas dari petani dan pedagang lokal. Sayuran, buah, bumbu dapur - semua diantar cepat ke rumah Anda.</p>
            
            <div class="hero-buttons">
                @auth
                    <a href="{{ route('shop.index') }}" class="btn btn-white">🛒 Mulai Belanja</a>
                    <a href="{{ route('home') }}" class="btn btn-outline">Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-white">Daftar Gratis</a>
                    <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                @endauth
            </div>
        </div>
    </section>
    
    

    <!-- Stats Bar -->
    <section class="stats-bar">
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-number">500+</div>
                <div class="stat-label">Produk Segar</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">1000+</div>
                <div class="stat-label">Pelanggan Puas</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">4.9★</div>
                <div class="stat-label">Rating</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">2 Jam</div>
                <div class="stat-label">Pengiriman</div>
            </div>
        </div>
    </section>
    
    <!-- Features -->
    <section class="features">
        <div class="section-container">
            <div class="section-header">
                <h2>Kenapa Belanja di Sini?</h2>
                <p>Pengalaman belanja pasar yang lebih mudah</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🥬</div>
                    <h3>Produk Segar</h3>
                    <p>Langsung dari petani lokal setiap pagi</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🚚</div>
                    <h3>Gratis Ongkir</h3>
                    <p>Tanpa minimum pembelian</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💳</div>
                    <h3>Bayar COD</h3>
                    <p>Bayar saat barang sampai</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔄</div>
                    <h3>Garansi</h3>
                    <p>Uang kembali jika tidak puas</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Product Marquee -->
    <section class="marquee-section">
        <h3>🔥 Produk Populer</h3>
        <p>Contoh produk dari setiap kategori</p>
        
        <div class="marquee-wrapper">
            <div class="marquee">
                <div class="marquee-item"><div class="marquee-img">🥬</div><div class="marquee-info"><div class="marquee-name">Kangkung</div><div class="marquee-price">Rp 5.000</div></div></div>
                <div class="marquee-item"><div class="marquee-img">🥭</div><div class="marquee-info"><div class="marquee-name">Mangga</div><div class="marquee-price">Rp 25.000</div></div></div>
                <div class="marquee-item"><div class="marquee-img">🧄</div><div class="marquee-info"><div class="marquee-name">Bawang Putih</div><div class="marquee-price">Rp 35.000</div></div></div>
                <div class="marquee-item"><div class="marquee-img">🥚</div><div class="marquee-info"><div class="marquee-name">Telur Ayam</div><div class="marquee-price">Rp 28.000</div></div></div>
                <div class="marquee-item"><div class="marquee-img">🍚</div><div class="marquee-info"><div class="marquee-name">Beras 5kg</div><div class="marquee-price">Rp 65.000</div></div></div>
                <div class="marquee-item"><div class="marquee-img">�</div><div class="marquee-info"><div class="marquee-name">Daging Sapi</div><div class="marquee-price">Rp 120.000</div></div></div>
                <!-- Duplicate for seamless loop -->
                <div class="marquee-item"><div class="marquee-img">🥬</div><div class="marquee-info"><div class="marquee-name">Kangkung</div><div class="marquee-price">Rp 5.000</div></div></div>
                <div class="marquee-item"><div class="marquee-img">🥭</div><div class="marquee-info"><div class="marquee-name">Mangga</div><div class="marquee-price">Rp 25.000</div></div></div>
                <div class="marquee-item"><div class="marquee-img">�</div><div class="marquee-info"><div class="marquee-name">Bawang Putih</div><div class="marquee-price">Rp 35.000</div></div></div>
                <div class="marquee-item"><div class="marquee-img">🥚</div><div class="marquee-info"><div class="marquee-name">Telur Ayam</div><div class="marquee-price">Rp 28.000</div></div></div>
                <div class="marquee-item"><div class="marquee-img">🍚</div><div class="marquee-info"><div class="marquee-name">Beras 5kg</div><div class="marquee-price">Rp 65.000</div></div></div>
                <div class="marquee-item"><div class="marquee-img">�</div><div class="marquee-info"><div class="marquee-name">Daging Sapi</div><div class="marquee-price">Rp 120.000</div></div></div>
            </div>
        </div>
    </section>


    <!-- Categories - 3x3 Grid -->
    <section class="categories">
        <div class="section-container">
            <div class="section-header">
                <h2>Kategori Produk</h2>
                <p>Pilih kebutuhan dapur Anda</p>
            </div>
            
            <div class="categories-grid">
                <a href="{{ route('shop.index', ['category' => 'Sayuran']) }}" class="category-card">
                    <div class="category-icon">🥬</div>
                    <div class="category-name">Sayuran</div>
                    <div class="category-count">50+ produk</div>
                </a>
                <a href="{{ route('shop.index', ['category' => 'Buah']) }}" class="category-card">
                    <div class="category-icon">🥭</div>
                    <div class="category-name">Buah</div>
                    <div class="category-count">30+ produk</div>
                </a>
                <a href="{{ route('shop.index', ['category' => 'Bumbu']) }}" class="category-card">
                    <div class="category-icon">🧄</div>
                    <div class="category-name">Bumbu</div>
                    <div class="category-count">40+ produk</div>
                </a>
                <a href="{{ route('shop.index', ['category' => 'Protein']) }}" class="category-card">
                    <div class="category-icon">🥚</div>
                    <div class="category-name">Protein</div>
                    <div class="category-count">25+ produk</div>
                </a>
                <a href="{{ route('shop.index', ['category' => 'Sembako']) }}" class="category-card">
                    <div class="category-icon">🍚</div>
                    <div class="category-name">Sembako</div>
                    <div class="category-count">35+ produk</div>
                </a>
                <a href="{{ route('shop.index', ['category' => 'Daging']) }}" class="category-card">
                    <div class="category-icon">🥩</div>
                    <div class="category-name">Daging</div>
                    <div class="category-count">20+ produk</div>
                </a>
                <a href="{{ route('shop.index', ['category' => 'Ikan']) }}" class="category-card">
                    <div class="category-icon">🐟</div>
                    <div class="category-name">Ikan</div>
                    <div class="category-count">15+ produk</div>
                </a>
                <a href="{{ route('shop.index', ['category' => 'Minuman']) }}" class="category-card">
                    <div class="category-icon">🥤</div>
                    <div class="category-name">Minuman</div>
                    <div class="category-count">20+ produk</div>
                </a>
                <a href="{{ route('shop.index', ['category' => 'Snack']) }}" class="category-card">
                    <div class="category-icon">🍿</div>
                    <div class="category-name">Snack</div>
                    <div class="category-count">30+ produk</div>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Reviews Section -->
    <section class="reviews">
        <div class="section-container">
            <div class="section-header">
                <h2>Apa Kata Mereka? 💬</h2>
                <p>Review dari pelanggan setia kami</p>
            </div>
            
            <div class="reviews-grid">
                <div class="review-card">
                    <div class="review-stars">⭐⭐⭐⭐⭐</div>
                    <p class="review-text">"Sayurannya segar banget! Diantar cepat dan packagingnya rapi. Pasti order lagi!"</p>
                    <div class="review-author">
                        <div class="review-avatar">S</div>
                        <div>
                            <div class="review-name">Siti Aminah</div>
                            <div class="review-location">Banda Aceh</div>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                    <div class="review-stars">⭐⭐⭐⭐⭐</div>
                    <p class="review-text">"Praktis banget! Ga perlu ke pasar pagi-pagi. Kualitas produknya sama kayak di pasar."</p>
                    <div class="review-author">
                        <div class="review-avatar">R</div>
                        <div>
                            <div class="review-name">Rizki Maulana</div>
                            <div class="review-location">Lhokseumawe</div>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                    <div class="review-stars">⭐⭐⭐⭐⭐</div>
                    <p class="review-text">"Harganya murah, gratis ongkir lagi. Pelayanannya ramah. Recommended!"</p>
                    <div class="review-author">
                        <div class="review-avatar">N</div>
                        <div>
                            <div class="review-name">Nurul Fadillah</div>
                            <div class="review-location">Meulaboh</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA -->
    <section class="cta">
        <h2>Siap Belanja Segar? 🛒</h2>
        <p>Daftar sekarang dan nikmati belanja kebutuhan dapur dari rumah!</p>
        @auth
            <a href="{{ route('shop.index') }}" class="btn">Belanja Sekarang →</a>
        @else
            <a href="{{ route('register') }}" class="btn">Daftar Gratis →</a>
        @endauth
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">
                <h3>Peukan<span>Rumoh</span></h3>
                <p>Pasar online terpercaya untuk kebutuhan dapur Anda dari pedagang lokal Aceh.</p>
            </div>
            
            <div class="footer-links">
                <h4>Belanja</h4>
                <a href="{{ route('shop.index') }}">Semua Produk</a>
                <a href="{{ route('shop.index', ['category' => 'Sayuran']) }}">Sayuran</a>
                <a href="{{ route('shop.index', ['category' => 'Buah']) }}">Buah</a>
            </div>
            
            <div class="footer-links">
                <h4>Akun</h4>
                <a href="{{ route('login') }}">Masuk</a>
                <a href="{{ route('register') }}">Daftar</a>
            </div>
            
            <div class="footer-links">
                <h4>Bantuan</h4>
                <a href="#">FAQ</a>
                <a href="#">Kontak</a>
            </div>
        </div>
        
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Peukan Rumoh. Made with 💚 in Aceh.
        </div>
    </footer>
</body>
</html>
