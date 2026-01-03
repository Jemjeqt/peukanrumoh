<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - Peukan Rumoh</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    body {
        font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
        min-height: 100vh;
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0fdfa 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    
    .login-card {
        display: grid;
        grid-template-columns: 1fr 1fr;
        max-width: 900px;
        width: 100%;
        background: white;
        border-radius: 24px;
        box-shadow: 0 25px 50px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    /* Left - Branding */
    .brand-side {
        background: linear-gradient(160deg, #059669 0%, #10b981 50%, #34d399 100%);
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .brand-side::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
        top: -100px;
        right: -100px;
        border-radius: 50%;
    }
    
    .brand-side::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        bottom: -50px;
        left: -50px;
        border-radius: 50%;
    }
    
    .brand-content {
        position: relative;
        z-index: 1;
    }
    
    .brand-logo {
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
    }
    
    .brand-title {
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }
    
    .brand-desc {
        font-size: 0.95rem;
        opacity: 0.9;
        line-height: 1.6;
        margin-bottom: 2rem;
    }
    
    .feature-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .feature-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
    }
    
    .feature-icon {
        width: 36px;
        height: 36px;
        background: rgba(255,255,255,0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }
    
    /* Right - Form */
    .form-side {
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        color: #059669;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        transition: color 0.2s;
    }
    
    .back-link:hover {
        color: #047857;
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 1.75rem;
    }
    
    .form-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 0.35rem;
        letter-spacing: -0.3px;
    }
    
    .form-subtitle {
        color: #6b7280;
        font-size: 0.9rem;
    }
    
    .alert-box {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        margin-bottom: 1.25rem;
        font-size: 0.85rem;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.4rem;
        font-size: 0.85rem;
    }
    
    .form-input {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.95rem;
        font-family: inherit;
        transition: all 0.2s;
        background: #fafafa;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #10b981;
        background: white;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .form-input::placeholder {
        color: #9ca3af;
    }
    
    .remember-row {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 1.25rem;
    }
    
    .checkbox-custom {
        width: 18px;
        height: 18px;
        accent-color: #10b981;
        cursor: pointer;
    }
    
    .remember-label {
        font-size: 0.85rem;
        color: #4b5563;
        cursor: pointer;
    }
    
    .btn-login {
        width: 100%;
        padding: 0.9rem;
        background: linear-gradient(135deg, #059669, #10b981);
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: 700;
        font-size: 0.95rem;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    }
    
    .divider {
        display: flex;
        align-items: center;
        margin: 1.5rem 0;
        color: #9ca3af;
        font-size: 0.8rem;
    }
    
    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e5e7eb;
    }
    
    .divider span {
        padding: 0 0.75rem;
    }
    
    .register-link {
        text-align: center;
        font-size: 0.9rem;
        color: #6b7280;
    }
    
    .register-link a {
        color: #059669;
        font-weight: 700;
        text-decoration: none;
    }
    
    .register-link a:hover {
        text-decoration: underline;
    }
    
    @media (max-width: 768px) {
        .login-card {
            grid-template-columns: 1fr;
        }
        
        .brand-side {
            display: none;
        }
    }
</style>
</head>
<body>
<div class="login-card">
    <!-- Left - Branding -->
    <div class="brand-side">
        <div class="brand-content">
            <div class="brand-logo">🛒</div>
            <h1 class="brand-title">Peukan Rumoh</h1>
            <p class="brand-desc">Belanja kebutuhan dapur dengan mudah, harga terjangkau, kualitas terjamin!</p>
            
            <div class="feature-list">
                <div class="feature-item">
                    <div class="feature-icon">🚀</div>
                    <span>Pengiriman cepat ke rumah</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🥬</div>
                    <span>Produk segar berkualitas</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">💰</div>
                    <span>Harga terjangkau</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right - Form -->
    <div class="form-side">
        <a href="{{ route('welcome') }}" class="back-link">← Kembali ke Beranda</a>
        
        <div class="form-header">
            <h2 class="form-title">Selamat Datang! 👋</h2>
            <p class="form-subtitle">Masuk ke akun Anda untuk melanjutkan</p>
        </div>
        
        @if(session('success'))
            <div style="background: #d1fae5; border: 1px solid #a7f3d0; color: #065f46; padding: 0.75rem 1rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: 0.85rem;">
                ✓ {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert-box">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" 
                       value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
            </div>
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" 
                       placeholder="Masukkan password" required>
            </div>
            
            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember" class="checkbox-custom">
                <label for="remember" class="remember-label">Ingat saya</label>
                <a href="{{ route('password.request') }}" style="margin-left: auto; color: #059669; font-size: 0.85rem; text-decoration: none; font-weight: 600;">Lupa Password?</a>
            </div>
            
            <button type="submit" class="btn-login">🔐 Masuk</button>
        </form>
        
        <div class="divider"><span>atau</span></div>
        
        <p class="register-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
        </p>
    </div>
</div>
</body>
</html>
