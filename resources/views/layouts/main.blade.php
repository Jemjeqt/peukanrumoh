<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Peukan Rumoh') - Pasar Online Terpercaya</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2E7D32;
            --primary-light: #4CAF50;
            --primary-dark: #1B5E20;
            --accent: #FF6F00;
            --accent-light: #FF8F00;
            --bg-white: #ffffff;
            --bg-gray: #f8f9fa;
            --bg-dark: #1a1a1a;
            --text-dark: #212121;
            --text-gray: #666666;
            --text-light: #999999;
            --border: #e0e0e0;
            --shadow: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-hover: 0 4px 12px rgba(0,0,0,0.1);
            --radius: 8px;
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
            max-width: 1200px;
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
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        
        .logo span { color: var(--accent); }
        
        .search-box {
            flex: 1;
            max-width: 400px;
            display: flex;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: border-color 0.2s;
        }
        
        .search-box:focus-within {
            border-color: var(--primary);
        }
        
        .search-box input {
            flex: 1;
            padding: 0.6rem 0.875rem;
            border: none;
            font-size: 13px;
            outline: none;
        }
        
        .search-box button {
            padding: 0.6rem 1rem;
            background: var(--primary);
            border: none;
            color: white;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s;
        }
        
        .search-box button:hover {
            background: var(--primary-dark);
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
            padding: 0.5rem 0.875rem;
            font-size: 13px;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }
        
        .nav-link:hover { 
            color: var(--primary); 
            background: rgba(46,125,50,0.08); 
        }
        
        .nav-link.active {
            color: var(--primary);
            background: rgba(46,125,50,0.1);
        }
        
        .nav-badge {
            background: var(--accent);
            color: white;
            font-size: 11px;
            padding: 0.125rem 0.375rem;
            border-radius: 10px;
            font-weight: 600;
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            padding: 0.5rem 1rem;
            font-size: 13px;
            font-weight: 600;
            border-radius: var(--radius);
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            font-family: inherit;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            box-shadow: 0 2px 8px rgba(46,125,50,0.25);
        }
        .btn-primary:hover { 
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(46,125,50,0.35); 
        }
        
        .btn-secondary {
            background: var(--bg-gray);
            color: var(--text-dark);
            border: 1px solid var(--border);
        }
        .btn-secondary:hover { 
            background: var(--bg-white); 
            border-color: var(--primary);
        }
        
        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        .btn-outline:hover { 
            background: rgba(46,125,50,0.08); 
        }
        
        .btn-danger { 
            background: linear-gradient(135deg, #dc3545, #c82333); 
            color: white; 
        }
        .btn-danger:hover { 
            box-shadow: 0 4px 12px rgba(220,53,69,0.35); 
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            color: white;
        }
        
        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
            color: white;
        }
        .btn-info:hover {
            box-shadow: 0 4px 12px rgba(23,162,184,0.35);
        }
        
        .btn-sm { padding: 0.375rem 0.75rem; font-size: 12px; }
        .btn-lg { padding: 0.75rem 1.5rem; font-size: 15px; }
        
        /* Cards */
        .card {
            background: var(--bg-white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }
        
        .card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .card-body {
            padding: 1.25rem;
        }
        
        /* Forms */
        .form-group { margin-bottom: 1rem; }
        
        .form-label {
            display: block;
            margin-bottom: 0.375rem;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-dark);
        }
        
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.6rem 0.875rem;
            font-size: 13px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
            background: var(--bg-white);
        }
        
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(46,125,50,0.1);
        }
        
        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .form-error {
            color: #dc3545;
            font-size: 12px;
            margin-top: 0.25rem;
        }
        
        /* Alerts */
        .alert {
            padding: 0.875rem 1rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .alert-success { 
            background: linear-gradient(135deg, #d4edda, #c3e6cb); 
            color: #155724; 
            border: 1px solid #c3e6cb; 
        }
        .alert-error, .alert-danger { 
            background: linear-gradient(135deg, #f8d7da, #f5c6cb); 
            color: #721c24; 
            border: 1px solid #f5c6cb; 
        }
        .alert-warning { 
            background: linear-gradient(135deg, #fff3cd, #ffe69c); 
            color: #856404; 
            border: 1px solid #ffe69c; 
        }
        .alert-info { 
            background: linear-gradient(135deg, #cce5ff, #b6d4fe); 
            color: #004085; 
            border: 1px solid #b6d4fe; 
        }
        
        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem;
        }
        
        /* Main */
        .main-content {
            flex: 1;
            padding: 1rem 0;
        }
        
        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.625rem;
            font-size: 11px;
            font-weight: 600;
            border-radius: 20px;
        }
        
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-info { background: #cce5ff; color: #004085; }
        .badge-secondary { background: #e2e3e5; color: #383d41; }
        .badge-primary { background: rgba(46,125,50,0.1); color: var(--primary); }
        
        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th, .table td {
            padding: 0.875rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        
        .table th {
            background: var(--bg-gray);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-gray);
        }
        
        .table tbody tr:hover {
            background: rgba(46,125,50,0.02);
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
        }
        
        .pagination li,
        .pagination .page-item {
            list-style: none;
            list-style-type: none;
            margin: 0;
        }
        
        .pagination a, 
        .pagination span,
        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 0.75rem;
            font-size: 13px;
            text-decoration: none;
            border-radius: 6px;
            border: 1px solid var(--border);
            color: var(--text-gray);
            background: white;
            transition: all 0.2s;
        }
        
        .pagination a:hover,
        .pagination .page-link:hover { 
            border-color: var(--primary); 
            color: var(--primary);
            background: rgba(46,125,50,0.05);
        }
        
        .pagination .active .page-link,
        .pagination span.active {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        
        .pagination .disabled .page-link,
        .pagination span.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }
        
        .pagination svg {
            display: none !important;
        }
        
        .page-item {
            margin: 0;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .stat-card {
            background: var(--bg-white);
            border-radius: var(--radius);
            padding: 1.25rem;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .stat-icon.green { background: rgba(46,125,50,0.1); }
        .stat-icon.orange { background: rgba(255,111,0,0.1); }
        .stat-icon.blue { background: rgba(33,150,243,0.1); }
        .stat-icon.red { background: rgba(244,67,54,0.1); }
        
        .stat-info h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        
        .stat-info p {
            font-size: 12px;
            color: var(--text-gray);
        }
        
        /* Footer */
        .footer {
            background: var(--bg-dark);
            color: #999;
            padding: 1.25rem 1.5rem;
            text-align: center;
            font-size: 13px;
            margin-top: auto;
        }
        
        .footer a { 
            color: var(--primary-light); 
            text-decoration: none; 
        }
        
        /* Utils */
        .text-muted { color: var(--text-gray); }
        .text-small { font-size: 12px; }
        .mb-0 { margin-bottom: 0 !important; }
        .mb-1 { margin-bottom: 0.5rem !important; }
        .mb-2 { margin-bottom: 1rem !important; }
        .mt-2 { margin-top: 1rem !important; }
        .d-flex { display: flex; }
        .justify-between { justify-content: space-between; }
        .align-center { align-items: center; }
        .gap-1 { gap: 0.5rem; }
        .gap-2 { gap: 1rem; }
        
        /* Responsive */
        @media (max-width: 768px) {
            .nav-container { flex-wrap: wrap; gap: 0.75rem; }
            .search-box { order: 3; max-width: 100%; flex: 1 1 100%; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (max-width: 576px) {
            .stats-grid { grid-template-columns: 1fr; }
            .table { font-size: 12px; }
            .table th, .table td { padding: 0.625rem 0.5rem; }
        }
    </style>
    @yield('styles')
</head>
<body>
    @include('partials.navbar')
    
    <main class="main-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">✓ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">✕ {{ session('error') }}</div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning">⚠ {{ session('warning') }}</div>
            @endif
            @if(session('info'))
                <div class="alert alert-info">ℹ {{ session('info') }}</div>
            @endif
            
            @yield('content')
        </div>
    </main>
    
    <footer class="footer">
        &copy; {{ date('Y') }} <a href="{{ route('welcome') }}">Peukan Rumoh</a> - Digitalisasi Pasar Tradisional Kabupaten Bandung
    </footer>
    
    <script>
        // CSRF Token for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Generic AJAX helper
        async function ajaxRequest(url, options = {}) {
            const defaultOptions = {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            };
            
            const response = await fetch(url, { ...defaultOptions, ...options });
            return response.json();
        }
        
        // Confirm delete
        function confirmDelete(message = 'Apakah Anda yakin ingin menghapus?') {
            return confirm(message);
        }
        
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
