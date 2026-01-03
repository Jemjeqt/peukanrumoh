<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password - Peukan Rumoh</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #bbf7d0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .container {
            width: 100%;
            max-width: 420px;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #166534;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 1.5rem;
            transition: color 0.3s;
        }
        
        .back-link:hover { color: #14532d; }
        
        .card {
            background: white;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);
        }
        
        .logo-text {
            font-size: 1.5rem;
            font-weight: 800;
            color: #166534;
        }
        
        .logo-text span { color: #f97316; }
        
        h1 {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 0.5rem;
        }
        
        .subtitle {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 2rem;
            line-height: 1.5;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #22c55e;
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1);
        }
        
        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-family: inherit;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.35);
        }
        
        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        
        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
            font-size: 0.9rem;
        }
        
        .footer-text a {
            color: #16a34a;
            text-decoration: none;
            font-weight: 600;
        }
        
        .footer-text a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('login') }}" class="back-link">
            ← Kembali ke Login
        </a>
        
        <div class="card">
            <div class="logo">
                <div class="logo-icon">🏪</div>
                <div class="logo-text">Peukan<span>Rumoh</span></div>
            </div>
            
            <h1>🔑 Lupa Password?</h1>
            <p class="subtitle">Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>
            
            @if(session('success'))
                <div class="alert alert-success">
                    ✓ {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            
            <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">📧 Email</label>
                    <input type="email" name="email" class="form-input" 
                           placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                </div>
                
                <button type="submit" class="btn-submit" id="submitBtn">
                    📨 Kirim Link Reset Password
                </button>
            </form>
            
            <p class="footer-text">
                Ingat password? <a href="{{ route('login') }}">Login di sini</a>
            </p>
        </div>
    </div>
    
    <script>
        document.getElementById('forgotForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.innerHTML = '⏳ Mengirim...';
            btn.disabled = true;
        });
    </script>
</body>
</html>
