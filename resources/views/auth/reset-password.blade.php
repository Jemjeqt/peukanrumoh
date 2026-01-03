<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - Peukan Rumoh</title>
    
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
        }
        
        .form-group {
            margin-bottom: 1.25rem;
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
        
        .form-input:read-only {
            background: #f3f4f6;
            color: #6b7280;
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
            margin-top: 0.5rem;
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
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        
        .password-hint {
            font-size: 0.8rem;
            color: #6b7280;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="logo">
                <div class="logo-icon">🏪</div>
                <div class="logo-text">Peukan<span>Rumoh</span></div>
            </div>
            
            <h1>🔐 Reset Password</h1>
            <p class="subtitle">Masukkan password baru Anda</p>
            
            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif
            
            <form method="POST" action="{{ route('password.update') }}" id="resetForm">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="form-group">
                    <label class="form-label">📧 Email</label>
                    <input type="email" name="email" class="form-input" 
                           value="{{ $email ?? old('email') }}" readonly required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">🔒 Password Baru</label>
                    <input type="password" name="password" class="form-input" 
                           placeholder="Masukkan password baru" required autofocus>
                    <p class="password-hint">Minimal 8 karakter</p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">🔒 Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-input" 
                           placeholder="Ulangi password baru" required>
                </div>
                
                <button type="submit" class="btn-submit" id="submitBtn">
                    ✓ Reset Password
                </button>
            </form>
        </div>
    </div>
    
    <script>
        document.getElementById('resetForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.innerHTML = '⏳ Memproses...';
            btn.disabled = true;
        });
    </script>
</body>
</html>
