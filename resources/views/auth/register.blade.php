<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - Peukan Rumoh</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    body {
        font-family: 'Inter', -apple-system, sans-serif;
        line-height: 1.5;
    }
    
    .register-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fffe 0%, #f0f9f6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    
    .register-container {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        max-width: 1000px;
        width: 100%;
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    /* Left Side - Branding */
    .register-brand {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .register-brand::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
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
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .brand-subtitle {
        font-size: 0.95rem;
        opacity: 0.9;
        line-height: 1.6;
        margin-bottom: 2rem;
    }
    
    /* Role Cards */
    .role-preview {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .role-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1rem;
        background: rgba(255,255,255,0.15);
        border-radius: 12px;
    }
    
    .role-icon {
        font-size: 1.5rem;
    }
    
    .role-info {
        flex: 1;
    }
    
    .role-name {
        font-weight: 600;
        font-size: 0.95rem;
    }
    
    .role-desc {
        font-size: 0.75rem;
        opacity: 0.8;
    }
    
    /* Right Side - Form */
    .register-form {
        padding: 2.5rem;
        overflow-y: auto;
        max-height: 90vh;
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 1.75rem;
    }
    
    .form-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 0.35rem;
    }
    
    .form-subtitle {
        color: #888;
        font-size: 0.9rem;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.4rem;
        font-size: 0.85rem;
    }
    
    .form-input-premium {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #fafafa;
    }
    
    .form-input-premium:focus {
        outline: none;
        border-color: #11998e;
        background: white;
        box-shadow: 0 0 0 4px rgba(17, 153, 142, 0.1);
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    /* Role Selector */
    .role-selector {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .role-option {
        position: relative;
    }
    
    .role-option input {
        position: absolute;
        opacity: 0;
    }
    
    .role-option label {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1rem 0.75rem;
        border: 2px solid #e0e0e0;
        border-radius: 14px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
    }
    
    .role-option label:hover {
        border-color: #11998e;
    }
    
    .role-option input:checked + label {
        border-color: #11998e;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    }
    
    .role-emoji {
        font-size: 1.75rem;
        margin-bottom: 0.35rem;
    }
    
    .role-label-text {
        font-weight: 700;
        font-size: 0.85rem;
        color: #1a1a2e;
    }
    
    .role-label-desc {
        font-size: 0.7rem;
        color: #888;
        margin-top: 0.15rem;
    }
    
    .role-note {
        font-size: 0.75rem;
        color: #888;
        text-align: center;
        margin-bottom: 1rem;
        padding: 0.5rem;
        background: #fef3c7;
        border-radius: 8px;
        color: #92400e;
    }
    
    .btn-register {
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
        margin-top: 0.5rem;
    }
    
    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
    }
    
    .form-divider {
        display: flex;
        align-items: center;
        margin: 1.25rem 0;
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
    
    .login-link {
        text-align: center;
        font-size: 0.9rem;
        color: #666;
    }
    
    .login-link a {
        color: #11998e;
        font-weight: 700;
        text-decoration: none;
    }
    
    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }
    
    @media (max-width: 768px) {
        .register-container {
            grid-template-columns: 1fr;
        }
        
        .register-brand {
            display: none;
        }
        
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .role-selector {
            grid-template-columns: 1fr;
        }
    }
</style>
</head>
<body>
<div class="register-page">
    <div class="register-container">
        <!-- Left - Branding -->
        <div class="register-brand">
            <div class="brand-content">
                <div class="brand-logo">🥬</div>
                <h1 class="brand-title">Bergabung dengan Peukan Rumoh</h1>
                <p class="brand-subtitle">Pilih peran Anda dan mulai perjalanan bersama kami!</p>
                
                <div class="role-preview">
                    <div class="role-item">
                        <span class="role-icon">👤</span>
                        <div class="role-info">
                            <div class="role-name">Pembeli</div>
                            <div class="role-desc">Belanja kebutuhan sehari-hari</div>
                        </div>
                    </div>
                    <div class="role-item">
                        <span class="role-icon">🏪</span>
                        <div class="role-info">
                            <div class="role-name">Pedagang</div>
                            <div class="role-desc">Jual produk segar Anda</div>
                        </div>
                    </div>
                    <div class="role-item">
                        <span class="role-icon">🚚</span>
                        <div class="role-info">
                            <div class="role-name">Kurir</div>
                            <div class="role-desc">Antar pesanan ke pelanggan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right - Form -->
        <div class="register-form">
            <a href="{{ route('welcome') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #11998e; text-decoration: none; font-weight: 600; margin-bottom: 1rem; font-size: 0.9rem;">
                ← Kembali ke Beranda
            </a>
            
            <div class="form-header">
                <h2 class="form-title">Buat Akun Baru ✨</h2>
                <p class="form-subtitle">Isi data diri Anda untuk mendaftar</p>
            </div>
            
            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-input-premium" 
                               value="{{ old('name') }}" placeholder="Nama Anda" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input-premium" 
                               value="{{ old('email') }}" placeholder="email@contoh.com" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Daftar Sebagai</label>
                    <div class="role-selector">
                        <div class="role-option">
                            <input type="radio" name="role" id="role_pembeli" value="pembeli" {{ old('role', 'pembeli') === 'pembeli' ? 'checked' : '' }}>
                            <label for="role_pembeli">
                                <span class="role-emoji">👤</span>
                                <span class="role-label-text">Pembeli</span>
                                <span class="role-label-desc">Belanja harian</span>
                            </label>
                        </div>
                        <div class="role-option">
                            <input type="radio" name="role" id="role_pedagang" value="pedagang" {{ old('role') === 'pedagang' ? 'checked' : '' }}>
                            <label for="role_pedagang">
                                <span class="role-emoji">🏪</span>
                                <span class="role-label-text">Pedagang</span>
                                <span class="role-label-desc">Jual produk</span>
                            </label>
                        </div>
                        <div class="role-option">
                            <input type="radio" name="role" id="role_kurir" value="kurir" {{ old('role') === 'kurir' ? 'checked' : '' }}>
                            <label for="role_kurir">
                                <span class="role-emoji">🚚</span>
                                <span class="role-label-text">Kurir</span>
                                <span class="role-label-desc">Antar pesanan</span>
                            </label>
                        </div>
                    </div>
                    <div class="role-note">⚠️ Pedagang & Kurir memerlukan persetujuan Admin</div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="phone" class="form-input-premium" 
                               value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="address" class="form-input-premium" 
                               value="{{ old('address') }}" placeholder="Alamat lengkap">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-input-premium" 
                               placeholder="Min 8 karakter" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-input-premium" 
                               placeholder="Ulangi password" required>
                    </div>
                </div>
                
                <button type="submit" class="btn-register">
                    🚀 Daftar Sekarang
                </button>
            </form>
            
            <div class="form-divider">
                <span>atau</span>
            </div>
            
            <p class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
