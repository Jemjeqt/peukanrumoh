<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Peukan Rumoh</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* ========== CSS Variables ========== */
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
            
            /* Sidebar */
            --sidebar-dark: #1a2e1a;
            --sidebar-darker: #142114;
            --sidebar-light: #2d4a2d;
            --sidebar-hover: #3d5a3d;
            --sidebar-width: 260px;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg-gray);
            color: var(--text-dark);
            font-size: 14px;
            line-height: 1.5;
            min-height: 100vh;
        }
        
        /* ========== Sidebar ========== */
        .dashboard-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--sidebar-dark) 0%, var(--sidebar-darker) 100%);
            display: flex;
            flex-direction: column;
            z-index: 100;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        }
        
        .sidebar-header {
            padding: 1.25rem;
            border-bottom: 1px solid var(--sidebar-light);
        }
        
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .sidebar-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 4px 12px rgba(46,125,50,0.3);
        }
        
        .sidebar-title {
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
        }
        
        .sidebar-subtitle {
            color: rgba(255,255,255,0.5);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .sidebar-user {
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid var(--sidebar-light);
            background: rgba(0,0,0,0.15);
        }
        
        .sidebar-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff9800, #f57c00);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
        }
        
        .sidebar-user-name {
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .sidebar-user-email {
            color: rgba(255,255,255,0.5);
            font-size: 0.7rem;
        }
        
        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }
        
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
        
        .sidebar-menu {
            list-style: none;
            padding: 0 0.75rem;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 0.25rem;
        }
        
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .sidebar-link:hover {
            background: var(--sidebar-hover);
            color: white;
        }
        
        .sidebar-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(46,125,50,0.3);
        }
        
        .sidebar-link-icon {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }
        
        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid var(--sidebar-light);
        }
        
        .sidebar-logout {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem;
            color: rgba(255,255,255,0.6);
            background: transparent;
            border: 1px solid var(--sidebar-light);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.85rem;
            font-family: inherit;
        }
        
        .sidebar-logout:hover {
            background: rgba(244,67,54,0.15);
            color: #ff6b6b;
            border-color: rgba(244,67,54,0.4);
        }
        
        /* ========== Main Content ========== */
        .dashboard-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
        .dashboard-header {
            background: var(--bg-white);
            padding: 1rem 1.5rem;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        
        .dashboard-header-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }
        
        .dashboard-header-subtitle {
            font-size: 0.8rem;
            color: var(--text-gray);
            margin: 0;
        }
        
        .dashboard-body {
            padding: 1.5rem;
        }
        
        /* ========== Buttons (from original) ========== */
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
        .btn-danger:hover { box-shadow: 0 4px 12px rgba(220,53,69,0.35); }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            color: white;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
            color: white;
        }
        
        .btn-sm { padding: 0.375rem 0.75rem; font-size: 12px; }
        .btn-lg { padding: 0.75rem 1.5rem; font-size: 15px; }
        
        /* ========== Cards (from original) ========== */
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
            margin: 0;
        }
        
        .card-body {
            padding: 1.25rem;
        }
        
        /* ========== Forms (from original) ========== */
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
        
        /* ========== Alerts (from original) ========== */
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
        
        /* ========== Badge (from original) ========== */
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
        
        /* ========== Tables (from original) ========== */
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
        
        /* ========== Pagination (from original) ========== */
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
        
        /* ========== Stats Cards (from original) ========== */
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
            margin: 0;
        }
        
        .stat-info p {
            font-size: 12px;
            color: var(--text-gray);
            margin: 0;
        }
        
        /* ========== Utilities (from original) ========== */
        .text-muted { color: var(--text-gray); }
        .text-small { font-size: 12px; }
        .mb-0 { margin-bottom: 0 !important; }
        .mb-1 { margin-bottom: 0.5rem !important; }
        .mb-2 { margin-bottom: 1rem !important; }
        .mt-2 { margin-top: 1rem !important; }
        .d-flex { display: flex; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        .align-center { align-items: center; }
        .gap-1 { gap: 0.5rem; }
        .gap-2 { gap: 1rem; }
        .flex-wrap { flex-wrap: wrap; }
        
        /* ========== Responsive ========== */
        @media (max-width: 992px) {
            .dashboard-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            .dashboard-sidebar.open {
                transform: translateX(0);
            }
            .dashboard-main {
                margin-left: 0;
            }
        }
        
        @media (max-width: 768px) {
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
    <!-- Sidebar -->
    <aside class="dashboard-sidebar">
        <!-- Logo/Brand -->
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <div class="sidebar-logo">🏪</div>
                <div>
                    <div class="sidebar-title">Peukan Rumoh</div>
                    <div class="sidebar-subtitle">@yield('panel_subtitle', 'Dashboard')</div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="sidebar-nav">
            <ul class="sidebar-menu">
                @if(auth()->user()->role === 'admin')
                    @include('admin.partials.sidebar-menu')
                @elseif(auth()->user()->role === 'pedagang')
                    @include('pedagang.partials.sidebar-menu')
                @elseif(auth()->user()->role === 'kurir')
                    @include('kurir.partials.sidebar-menu')
                @else
                    @yield('sidebar_menu')
                @endif
            </ul>
        </nav>
        
        <!-- User Info (Above Logout) -->
        <div class="sidebar-user" style="border-top: 1px solid var(--sidebar-light); border-bottom: none;">
            <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
            <div style="flex: 1; min-width: 0;">
                <div class="sidebar-user-name" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->name ?? 'User' }}</div>
                <div class="sidebar-user-email" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->email ?? '' }}</div>
            </div>
        </div>
        
        <!-- Logout -->
        <div class="sidebar-footer" style="border-top: none; padding-top: 0;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <span>↪</span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="dashboard-main">
        <!-- Top Header -->
        <header class="dashboard-header">
            <div>
                <h1 class="dashboard-header-title">@yield('page_title', 'Dashboard')</h1>
                @hasSection('page_subtitle')
                <p class="dashboard-header-subtitle">@yield('page_subtitle')</p>
                @endif
            </div>
            <div class="d-flex gap-1 align-center">
                @yield('header_actions')
            </div>
        </header>
        
        <!-- Page Content -->
        <div class="dashboard-body">
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
    
    <script>
        // CSRF Token for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
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
        
        function confirmDelete(message = 'Apakah Anda yakin ingin menghapus?') {
            return confirm(message);
        }
        
        // Auto-dismiss alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(function() { alert.remove(); }, 500);
                }, 10000);
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
