<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Peukan Rumoh') - Pasar Online</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary: #2E7D32;
            --primary-light: #4CAF50;
            --primary-dark: #1B5E20;
            --accent: #FF6F00;
            --bg-white: #ffffff;
            --bg-gray: #f8f9fa;
            --text-dark: #212121;
            --text-gray: #666666;
            --text-light: #999999;
            --border: #e0e0e0;
            --shadow: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-hover: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html { height: 100%; }
        
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg-gray);
            color: var(--text-dark);
            font-size: 14px;
            line-height: 1.5;
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        /* Navbar */
        .navbar {
            background: var(--bg-white);
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0.75rem 1.5rem;
        }
        
        .nav-container {
            max-width: 1140px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--primary);
        }
        
        .logo-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        
        .logo span { color: var(--accent); }
        
        .search-box {
            flex: 1;
            max-width: 400px;
            display: flex;
            border: 1px solid var(--border);
            border-radius: 6px;
            overflow: hidden;
        }
        
        .search-box input {
            flex: 1;
            padding: 0.5rem 0.75rem;
            border: none;
            font-size: 13px;
            outline: none;
        }
        
        .search-box button {
            padding: 0.5rem 0.75rem;
            background: var(--primary);
            border: none;
            color: white;
            cursor: pointer;
            font-size: 12px;
        }
        
        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-left: auto;
        }
        
        .nav-link {
            color: var(--text-gray);
            text-decoration: none;
            padding: 0.5rem 0.75rem;
            font-size: 13px;
            font-weight: 500;
            border-radius: 4px;
            transition: all 0.2s;
        }
        
        .nav-link:hover { color: var(--primary); background: rgba(46,125,50,0.08); }
        
        .nav-badge {
            background: var(--accent);
            color: white;
            font-size: 11px;
            padding: 0.125rem 0.375rem;
            border-radius: 10px;
            font-weight: 600;
            margin-left: 0.25rem;
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            padding: 0.5rem 1rem;
            font-size: 13px;
            font-weight: 600;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            font-family: inherit;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        .btn-primary:hover { background: var(--primary-dark); }
        
        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        .btn-outline:hover { background: rgba(46,125,50,0.08); }
        
        .btn-danger { background: #dc3545; color: white; }
        .btn-danger:hover { background: #c82333; }
        
        .btn-sm { padding: 0.375rem 0.75rem; font-size: 12px; }
        
        /* Cards */
        .card {
            background: var(--bg-white);
            border-radius: 8px;
            box-shadow: var(--shadow);
        }
        
        /* Forms */
        .form-group { margin-bottom: 1rem; }
        
        .form-label {
            display: block;
            margin-bottom: 0.25rem;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-dark);
        }
        
        .form-input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            font-size: 13px;
            border: 1px solid var(--border);
            border-radius: 6px;
            transition: border-color 0.2s;
            font-family: inherit;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
        }
        
        /* Alerts */
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 13px;
        }
        
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        
        /* Container */
        .container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 1rem 1.5rem;
        }
        
        /* Main */
        .main-content {
            flex: 1;
            padding: 1rem 0;
        }
        
        /* Badge */
        .badge {
            display: inline-block;
            padding: 0.2rem 0.5rem;
            font-size: 11px;
            font-weight: 600;
            border-radius: 4px;
        }
        
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        
        /* Pagination - FIXED */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.25rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }
        
        .pagination a, .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 0.5rem;
            font-size: 13px;
            text-decoration: none;
            border-radius: 4px;
            border: 1px solid var(--border);
            color: var(--text-gray);
            background: white;
        }
        
        .pagination a:hover { border-color: var(--primary); color: var(--primary); }
        
        .pagination .active span {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        
        .pagination .disabled span {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .pagination svg {
            width: 16px;
            height: 16px;
        }
        
        /* Footer - Full Style */
        .footer {
            background: #1a1a2e;
            color: white;
            padding: 3rem 2rem 1.5rem;
            margin-top: auto;
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
        
        @media (max-width: 768px) {
            .footer-content { grid-template-columns: 1fr; text-align: center; }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .nav-container { flex-wrap: wrap; gap: 0.75rem; }
            .search-box { order: 3; max-width: 100%; flex: 1 1 100%; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('welcome') }}" class="logo">
                <div class="logo-icon">🏪</div>
                Peukan<span>Rumoh</span>
            </a>
            
            @auth
                @if(!auth()->user()->isAdmin())
                <form action="{{ route('shop.index') }}" method="GET" class="search-box">
                    <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                    <button type="submit">🔍</button>
                </form>
                @endif
            @endauth
            
            <div class="nav-links">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                        <a href="{{ route('admin.products.index') }}" class="nav-link">Produk</a>
                        <a href="{{ route('profile.index') }}" class="nav-link">👤 Akun</a>
                    @else
                        <a href="{{ route('home') }}" class="nav-link">🏠 Beranda</a>
                        <a href="{{ route('shop.index') }}" class="nav-link">🛍️ Belanja</a>
                        <a href="{{ route('cart.index') }}" class="nav-link">
                            🛒 Keranjang
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                            @endphp
                            <span class="nav-badge" id="cart-badge" style="{{ $cartCount == 0 ? 'display:none;' : '' }}">{{ $cartCount }}</span>
                        </a>
                        <a href="{{ route('pembeli.orders.index') }}" class="nav-link">
                            📦 Pesanan
                            @php
                                // Count active orders (not completed/cancelled)
                                $orderCount = \App\Models\Order::where('user_id', auth()->id())
                                    ->whereNotIn('status', ['completed', 'cancelled'])
                                    ->count();
                                // Count returns needing buyer confirmation
                                $returnCount = \App\Models\ProductReturn::where('user_id', auth()->id())
                                    ->whereIn('status', ['replacement_delivered', 'refund_sent'])
                                    ->count();
                                $totalNotif = $orderCount + $returnCount;
                            @endphp
                            <span class="nav-badge" id="order-badge" style="{{ $totalNotif == 0 ? 'display:none;' : '' }}">{{ $totalNotif }}</span>
                        </a>
                        <a href="{{ route('profile.index') }}" class="nav-link">👤 Akun</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>
    
    <main class="main-content">
        @yield('content')
    </main>
    
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">
                <h3>Peukan<span>Rumoh</span></h3>
                <p>Pasar online terpercaya untuk kebutuhan dapur Anda dari pedagang lokal.</p>
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
            &copy; {{ date('Y') }} Peukan Rumoh - Pasar Online Terpercaya
        </div>
    </footer>
    
    <script>
        // Auto-dismiss alerts after 10 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 10000); // 10 seconds
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
