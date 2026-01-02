<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - Peukan Rumoh</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    .login-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fffe 0%, #f0f9f6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    
    .login-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        max-width: 900px;
        width: 100%;
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    /* Left Side - Branding */
    .login-brand {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .login-brand::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .login-brand::after {
        content: '';
        position: absolute;
        bottom: -150px;
        left: -50px;
        width: 250px;
        height: 250px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    
    .brand-content {
        position: relative;
        z-index: 1;
    }
    
    .brand-logo {
        font-size: 3rem;
        margin-bottom: 1.5rem;
    }
    
    .brand-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .brand-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        line-height: 1.6;
        margin-bottom: 2rem;
    }
    
    .brand-features {
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
        width: 32px;
        height: 32px;
        background: rgba(255,255,255,0.2);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Right Side - Form */
    .login-form {
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .form-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
    }
    
    .form-subtitle {
        color: #888;
        font-size: 0.95rem;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .form-input-premium {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafafa;
    }
    
    .form-input-premium:focus {
        outline: none;
        border-color: #11998e;
        background: white;
        box-shadow: 0 0 0 4px rgba(17, 153, 142, 0.1);
    }
    
    .remember-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .remember-row input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #11998e;
    }
    
    .remember-row label {
        font-size: 0.9rem;
        color: #666;
        cursor: pointer;
    }
    
    .btn-login {
        width: 100%;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
    }
    
    .form-divider {
        display: flex;
        align-items: center;
        margin: 1.5rem 0;
    }
    
    .form-divider::before,
    .form-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e0e0e0;
    }
    
    .form-divider span {
        padding: 0 1rem;
        color: #888;
        font-size: 0.85rem;
    }
    
    .register-link {
        text-align: center;
        font-size: 0.95rem;
        color: #666;
    }
    
    .register-link a {
        color: #11998e;
        font-weight: 700;
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .register-link a:hover {
        color: #0d7d73;
    }
    
    @media (max-width: 768px) {
        .login-container {
            grid-template-columns: 1fr;
        }
        
        .login-brand {
            display: none;
        }
    }
</style>
</head>
<body>
<div class="login-page">
    <div class="login-container">
        <!-- Left - Branding -->
        <div class="login-brand">
            <div class="brand-content">
                <div class="brand-logo">🥬</div>
                <h1 class="brand-title">Peukan Rumoh</h1>
                <p class="brand-subtitle">Belanja kebutuhan dapur dengan mudah, harga terjangkau, kualitas terjamin!</p>
                
                <div class="brand-features">
                    <div class="feature-item">
                        <div class="feature-icon">🚚</div>
                        <span>Pengiriman cepat ke rumah</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✅</div>
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
        <div class="login-form">
            <div class="form-header">
                <h2 class="form-title">Selamat Datang! 👋</h2>
                <p class="form-subtitle">Masuk ke akun Anda untuk melanjutkan</p>
            </div>
            
            @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input-premium" 
                           value="{{ old('email') }}" placeholder="email@contoh.com" required autofocus>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input-premium" 
                           placeholder="••••••••" required>
                </div>
                
                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya</label>
                </div>
                
                <button type="submit" class="btn-login">
                    🔐 Masuk
                </button>
            </form>
            
            <div class="form-divider">
                <span>atau</span>
            </div>
            
            <p class="register-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>

