@extends('layouts.dashboard')

@section('title', 'Dashboard Kurir')
@section('panel_subtitle', 'Kurir Panel')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Siap untuk mengantarkan pesanan hari ini?')

@section('styles')
<style>
    /* Main Container */
    .kurir-dashboard {
        min-height: calc(100vh - 200px);
    }
    
    /* Premium Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
        color: white;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .hero-content {
        position: relative;
        z-index: 1;
    }
    
    .hero-greeting {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .hero-subtitle {
        opacity: 0.9;
        font-size: 1.1rem;
    }
    
    .hero-icon {
        position: absolute;
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 7rem;
        opacity: 0.2;
    }
    
    /* Stats Overview */
    .stats-overview {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-card-modern {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.12);
    }
    
    .stat-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }
    
    .stat-card-modern.orange::before { background: linear-gradient(90deg, #ff9966, #ff5e62); }
    .stat-card-modern.blue::before { background: linear-gradient(90deg, #4facfe, #00f2fe); }
    .stat-card-modern.green::before { background: linear-gradient(90deg, #11998e, #38ef7d); }
    .stat-card-modern.purple::before { background: linear-gradient(90deg, #a18cd1, #fbc2eb); }
    
    .stat-card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .stat-icon-modern {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }
    
    .stat-icon-modern.orange { background: linear-gradient(135deg, #ff9966, #ff5e62); }
    .stat-icon-modern.blue { background: linear-gradient(135deg, #4facfe, #00f2fe); }
    .stat-icon-modern.green { background: linear-gradient(135deg, #11998e, #38ef7d); }
    .stat-icon-modern.purple { background: linear-gradient(135deg, #a18cd1, #fbc2eb); }
    
    .stat-value-large {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1a1a2e;
        line-height: 1;
    }
    
    .stat-label-modern {
        font-size: 0.9rem;
        color: #888;
        margin-top: 0.5rem;
        font-weight: 500;
    }
    
    /* Earnings Section */
    .earnings-section {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .earnings-card-large {
        border-radius: 24px;
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    }
    
    .earnings-card-large::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .earnings-card-large.today {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    
    .earnings-card-large.total {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    .earnings-card-content {
        position: relative;
        z-index: 1;
    }
    
    .earnings-icon-large {
        width: 64px;
        height: 64px;
        background: rgba(255,255,255,0.2);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    
    .earnings-value-large {
        font-size: 2.25rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
    }
    
    .earnings-label-large {
        font-size: 1rem;
        opacity: 0.9;
    }
    
    /* Task Cards Section */
    .tasks-section {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    
    .task-card-modern {
        background: white;
        border-radius: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        min-height: 350px;
        display: flex;
        flex-direction: column;
    }
    
    .task-card-header-modern {
        padding: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .task-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a2e;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .task-card-title-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .task-card-title-icon.pickup { background: linear-gradient(135deg, #ff9966, #ff5e62); }
    .task-card-title-icon.delivery { background: linear-gradient(135deg, #4facfe, #00f2fe); }
    
    .task-card-badge {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .task-card-body {
        flex: 1;
        padding: 0;
    }
    
    .task-list {
        width: 100%;
    }
    
    .task-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f5f5f5;
        transition: background 0.2s ease;
    }
    
    .task-item:hover {
        background: #fafafa;
    }
    
    .task-item:last-child {
        border-bottom: none;
    }
    
    .task-info {
        flex: 1;
    }
    
    .task-order-id {
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 0.25rem;
    }
    
    .task-address {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.2rem;
        max-width: 280px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .task-phone {
        font-size: 0.8rem;
        color: #999;
    }
    
    .btn-action {
        padding: 0.6rem 1.25rem;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .btn-action.pickup {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }
    
    .btn-action.deliver {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }
    
    /* Empty State */
    .task-empty-state {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        color: #999;
    }
    
    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .empty-text {
        font-size: 1rem;
        text-align: center;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .stats-overview { grid-template-columns: repeat(2, 1fr); }
    }
    
    @media (max-width: 900px) {
        .earnings-section { grid-template-columns: 1fr; }
        .tasks-section { grid-template-columns: 1fr; }
    }
    
    @media (max-width: 600px) {
        .stats-overview { grid-template-columns: 1fr; }
        .hero-icon { display: none; }
    }
</style>
@endsection

@section('content')
<div class="kurir-dashboard">
    @if(!auth()->user()->is_approved)
    <div class="alert alert-warning">
        ⚠️ Akun Anda sedang menunggu persetujuan dari Admin. Anda belum dapat menerima pesanan.
    </div>
    @endif

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <div class="hero-greeting">Halo, {{ auth()->user()->name }}! 👋</div>
            <div class="hero-subtitle">Siap untuk mengantarkan pesanan hari ini?</div>
        </div>
        <div class="hero-icon">🚚</div>
    </div>

    <!-- Stats Overview -->
    <div class="stats-overview">
        <div class="stat-card-modern orange">
            <div class="stat-card-header">
                <div class="stat-icon-modern orange">📦</div>
            </div>
            <div class="stat-value-large">{{ $stats['pending_pickup'] ?? 0 }}</div>
            <div class="stat-label-modern">Siap Diambil</div>
        </div>
        <div class="stat-card-modern blue">
            <div class="stat-card-header">
                <div class="stat-icon-modern blue">🚚</div>
            </div>
            <div class="stat-value-large">{{ $stats['in_delivery'] ?? 0 }}</div>
            <div class="stat-label-modern">Dalam Pengiriman</div>
        </div>
        <div class="stat-card-modern green">
            <div class="stat-card-header">
                <div class="stat-icon-modern green">✅</div>
            </div>
            <div class="stat-value-large">{{ $stats['completed_today'] ?? 0 }}</div>
            <div class="stat-label-modern">Selesai Hari Ini</div>
        </div>
        <div class="stat-card-modern purple">
            <div class="stat-card-header">
                <div class="stat-icon-modern purple">🔄</div>
            </div>
            <div class="stat-value-large">{{ $stats['returns'] ?? 0 }}</div>
            <div class="stat-label-modern">Return Aktif</div>
        </div>
    </div>

    <!-- Earnings Section -->
    <div class="earnings-section">
        <div class="earnings-card-large today">
            <div class="earnings-card-content">
                <div class="earnings-icon-large">💵</div>
                <div class="earnings-value-large">Rp {{ number_format($stats['earnings_today'] ?? 0, 0, ',', '.') }}</div>
                <div class="earnings-label-large">Pendapatan Hari Ini</div>
            </div>
        </div>
        <div class="earnings-card-large total">
            <div class="earnings-card-content">
                <div class="earnings-icon-large">💰</div>
                <div class="earnings-value-large">Rp {{ number_format($stats['total_earnings'] ?? 0, 0, ',', '.') }}</div>
                <div class="earnings-label-large">Total Pendapatan</div>
            </div>
        </div>
    </div>

    <!-- Task Cards -->
    <div class="tasks-section">
        <!-- Pending Pickups -->
        <div class="task-card-modern">
            <div class="task-card-header-modern">
                <div class="task-card-title">
                    <div class="task-card-title-icon pickup">📦</div>
                    <span>Siap Diambil</span>
                </div>
                @if(count($pendingPickups ?? []) > 0)
                <span class="task-card-badge">{{ count($pendingPickups) }} pesanan</span>
                @endif
            </div>
            <div class="task-card-body">
                @if(count($pendingPickups ?? []) > 0)
                <div class="task-list">
                    @foreach($pendingPickups as $order)
                    <div class="task-item">
                        <div class="task-info">
                            <div class="task-order-id">#{{ $order->id }}</div>
                            <div class="task-address">{{ Str::limit($order->shipping_address, 40) }}</div>
                            <div class="task-phone">📞 {{ $order->phone }}</div>
                        </div>
                        <form action="{{ route('kurir.deliveries.pickup', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-action pickup">Ambil</button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="task-empty-state">
                    <div class="empty-icon">📭</div>
                    <div class="empty-text">Belum ada pesanan<br>siap diambil</div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- In Delivery -->
        <div class="task-card-modern">
            <div class="task-card-header-modern">
                <div class="task-card-title">
                    <div class="task-card-title-icon delivery">🚚</div>
                    <span>Dalam Pengiriman</span>
                </div>
                @if(count($inDelivery ?? []) > 0)
                <span class="task-card-badge">{{ count($inDelivery) }} aktif</span>
                @endif
            </div>
            <div class="task-card-body">
                @if(count($inDelivery ?? []) > 0)
                <div class="task-list">
                    @foreach($inDelivery as $order)
                    <div class="task-item">
                        <div class="task-info">
                            <div class="task-order-id">#{{ $order->id }}</div>
                            <div class="task-address">{{ Str::limit($order->shipping_address, 40) }}</div>
                            <div class="task-phone">📞 {{ $order->phone }}</div>
                        </div>
                        <form action="{{ route('kurir.deliveries.deliver', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-action deliver">Selesai</button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="task-empty-state">
                    <div class="empty-icon">🚚</div>
                    <div class="empty-text">Tidak ada<br>pengiriman aktif</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
