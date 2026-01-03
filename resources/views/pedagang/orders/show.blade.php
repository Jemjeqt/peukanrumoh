@extends('layouts.dashboard')

@section('title', 'Detail Pesanan #' . $order->id)
@section('panel_subtitle', 'Pedagang Panel')
@section('page_title', 'Detail Pesanan')
@section('page_subtitle', 'Pesanan #' . str_pad($order->id, 6, '0', STR_PAD_LEFT))

@section('header_actions')
<a href="{{ route('pedagang.orders.index') }}" class="btn btn-secondary">← Kembali</a>
@endsection

@section('styles')
<style>
    /* Hero Header */
    .order-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .order-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 50%;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(30deg);
    }
    
    .order-hero.pending { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .order-hero.paid { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    .order-hero.processing { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .order-hero.ready_pickup { background: linear-gradient(135deg, #ff9966 0%, #ff5e62 100%); }
    .order-hero.shipped { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .order-hero.completed { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    .order-hero.cancelled { background: linear-gradient(135deg, #434343 0%, #000000 100%); }
    
    .order-hero-content {
        position: relative;
        z-index: 1;
    }
    
    .order-hero-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    
    .order-id-large {
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
    }
    
    .order-date {
        opacity: 0.9;
        font-size: 0.95rem;
    }
    
    .status-badge-large {
        padding: 0.6rem 1.5rem;
        border-radius: 30px;
        font-size: 0.95rem;
        font-weight: 700;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255,255,255,0.3);
    }
    
    /* Quick Stats */
    .hero-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
    }
    
    .hero-stat {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
    }
    
    .hero-stat-value {
        font-size: 1.35rem;
        font-weight: 700;
        display: block;
    }
    
    .hero-stat-label {
        font-size: 0.8rem;
        opacity: 0.9;
    }
    
    /* Main Grid */
    .order-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 1.5rem;
    }
    
    /* Card Styles */
    .order-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 25px rgba(0,0,0,0.08);
        margin-bottom: 1.25rem;
    }
    
    .order-card:last-child {
        margin-bottom: 0;
    }
    
    .order-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: linear-gradient(135deg, #f8fafc, #ffffff);
    }
    
    .order-header-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .order-header h3 {
        font-size: 1.05rem;
        font-weight: 700;
        margin: 0;
        color: #1a1a2e;
    }
    
    .order-body { 
        padding: 1.5rem; 
    }
    
    /* Product List */
    .product-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .product-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        background: linear-gradient(135deg, #f8fafc, #ffffff);
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        transition: all 0.2s;
    }
    
    .product-item:hover {
        border-color: #11998e;
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.1);
        transform: translateY(-2px);
    }
    
    .product-image {
        width: 65px;
        height: 65px;
        border-radius: 10px;
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        flex-shrink: 0;
        overflow: hidden;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .product-name {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }
    
    .product-price {
        font-size: 0.85rem;
        color: #6b7280;
    }
    
    .product-subtotal {
        text-align: right;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .product-qty {
        font-size: 0.8rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }
    
    .product-total {
        font-weight: 700;
        color: #11998e;
        font-size: 1.05rem;
    }
    
    /* Order Summary */
    .order-summary {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 14px;
        padding: 1.25rem;
        margin-top: 1rem;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #374151;
    }
    
    .summary-row.total {
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 2px dashed #22c55e;
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 0;
    }
    
    .summary-row.total .summary-value {
        color: #16a34a;
    }
    
    /* Info Cards */
    .info-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        margin-bottom: 1rem;
    }
    
    .info-card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: linear-gradient(135deg, #f8fafc, #ffffff);
    }
    
    .info-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
    
    .info-icon.buyer { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
    .info-icon.shipping { background: linear-gradient(135deg, #fef3c7, #fde68a); }
    .info-icon.action { background: linear-gradient(135deg, #d1fae5, #a7f3d0); }
    .info-icon.kurir { background: linear-gradient(135deg, #e0e7ff, #c7d2fe); }
    
    .info-card-header h3 {
        font-size: 0.95rem;
        font-weight: 700;
        margin: 0;
        color: #1a1a2e;
    }
    
    .info-card-body { 
        padding: 1.25rem; 
    }
    
    /* User Profile */
    .user-profile {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    
    .user-name {
        font-weight: 700;
        font-size: 1.05rem;
        color: #1a1a2e;
    }
    
    .user-role {
        font-size: 0.8rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.6rem 0;
    }
    
    .info-item-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    
    .info-item-content {
        flex: 1;
    }
    
    .info-item-label {
        font-size: 0.7rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .info-item-value {
        font-size: 0.9rem;
        color: #1a1a2e;
        font-weight: 500;
    }
    
    /* Action Cards */
    .action-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        margin-bottom: 1rem;
        border: 2px solid transparent;
        transition: all 0.3s;
    }
    
    .action-card:hover {
        border-color: #11998e;
    }
    
    .action-header {
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .action-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }
    
    .action-icon.process { background: linear-gradient(135deg, #ddd6fe, #c4b5fd); }
    .action-icon.ship { background: linear-gradient(135deg, #fed7aa, #fdba74); }
    
    .action-title {
        font-size: 0.95rem;
        font-weight: 700;
        margin: 0;
        color: #1a1a2e;
    }
    
    .action-body {
        padding: 1.25rem;
    }
    
    .action-desc {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 1rem;
        line-height: 1.5;
    }
    
    .btn-action {
        width: 100%;
        padding: 0.9rem 1.5rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-process {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }
    
    .btn-process:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }
    
    .btn-ship {
        background: linear-gradient(135deg, #ff9966, #ff5e62);
        color: white;
    }
    
    .btn-ship:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 153, 102, 0.4);
    }
    
    .form-select-custom {
        width: 100%;
        padding: 0.85rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.95rem;
        margin-bottom: 1rem;
        transition: all 0.2s;
        background: white;
        cursor: pointer;
    }
    
    .form-select-custom:focus {
        outline: none;
        border-color: #ff9966;
        box-shadow: 0 0 0 3px rgba(255, 153, 102, 0.15);
    }
    
    /* Shipping Timeline */
    .shipping-timeline {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .shipping-step {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem;
        background: #f9fafb;
        border-radius: 12px;
        transition: all 0.2s;
    }
    
    .shipping-step.done {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    }
    
    .shipping-dot {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .shipping-step.done .shipping-dot {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;
    }
    
    .shipping-info {
        flex: 1;
    }
    
    .shipping-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
    }
    
    .shipping-time {
        font-size: 0.75rem;
        color: #9ca3af;
    }

    @media (max-width: 992px) {
        .order-grid { grid-template-columns: 1fr; }
        .hero-stats { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endsection

@section('content')
@php
    $statusOrder = ['pending', 'paid', 'processing', 'ready_pickup', 'shipped', 'completed'];
    $currentIndex = array_search($order->status, $statusOrder);
    $isCancelled = $order->status === 'cancelled';
@endphp

<!-- Hero Header -->
<div class="order-hero {{ $order->status }}">
    <div class="order-hero-content">
        <div class="order-hero-top">
            <div>
                <div class="order-id-large">Pesanan #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="order-date">📅 {{ $order->created_at->format('d F Y, H:i') }} WIB</div>
            </div>
            <span class="status-badge-large">{{ $order->status_label }}</span>
        </div>
        
        <div class="hero-stats">
            <div class="hero-stat">
                <span class="hero-stat-value">{{ $order->items->count() }}</span>
                <span class="hero-stat-label">Produk</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-value">{{ $order->items->sum('quantity') }}</span>
                <span class="hero-stat-label">Total Item</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-value">Rp {{ number_format($order->total + $order->shipping_cost + $order->admin_fee, 0, ',', '.') }}</span>
                <span class="hero-stat-label">Total Bayar</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-value">{{ $order->created_at->diffForHumans() }}</span>
                <span class="hero-stat-label">Waktu Order</span>
            </div>
        </div>
    </div>
</div>

<div class="order-grid">
    <!-- Left Column: Products -->
    <div>
        <div class="order-card">
            <div class="order-header">
                <div class="order-header-icon" style="background: linear-gradient(135deg, #fef3c7, #fde68a);">🛒</div>
                <h3>Daftar Produk</h3>
            </div>
            <div class="order-body">
                <div class="product-list">
                    @foreach($order->items as $item)
                    <div class="product-item">
                        <div class="product-image">
                            @if($item->product && $item->product->image)
                                <img src="{{ $item->product->image_url ?? $item->product->image }}" alt="{{ $item->product_name }}">
                            @else
                                📦
                            @endif
                        </div>
                        <div class="product-info">
                            <div class="product-name">{{ $item->product_name }}</div>
                            <div class="product-price">Rp {{ number_format($item->price, 0, ',', '.') }} / item</div>
                        </div>
                        <div class="product-subtotal">
                            <div class="product-qty">× {{ $item->quantity }}</div>
                            <div class="product-total">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="order-summary">
                    <div class="summary-row">
                        <span>Subtotal ({{ $order->items->sum('quantity') }} item)</span>
                        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkos Kirim</span>
                        @if($order->shipping_cost > 0)
                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        @else
                            <span style="color: #22c55e;">Gratis</span>
                        @endif
                    </div>
                    <div class="summary-row">
                        <span>Biaya Admin</span>
                        @if($order->admin_fee > 0)
                            <span>Rp {{ number_format($order->admin_fee, 0, ',', '.') }}</span>
                        @else
                            <span style="color: #22c55e;">Gratis</span>
                        @endif
                    </div>
                    <div class="summary-row total">
                        <span>Total Pembayaran</span>
                        <span class="summary-value">Rp {{ number_format($order->total + $order->shipping_cost + $order->admin_fee, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Info & Actions -->
    <div>
        <!-- Buyer Info -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon buyer">👤</div>
                <h3>Informasi Pembeli</h3>
            </div>
            <div class="info-card-body">
                <div class="user-profile">
                    <div class="user-avatar">
                        {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                    </div>
                    <div>
                        <div class="user-name">{{ $order->user->name ?? 'Guest' }}</div>
                        <div class="user-role">🛒 Pembeli</div>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-item-icon">📱</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Telepon</div>
                        <div class="info-item-value">{{ $order->phone ?? '-' }}</div>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-item-icon">📍</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Alamat Pengiriman</div>
                        <div class="info-item-value">{{ $order->shipping_address ?? '-' }}</div>
                    </div>
                </div>
                
                @if($order->notes)
                <div class="info-item">
                    <div class="info-item-icon">📝</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Catatan</div>
                        <div class="info-item-value">{{ $order->notes }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions based on status -->
        @if($order->status === 'paid')
        <div class="action-card">
            <div class="action-header">
                <div class="action-icon process">🔄</div>
                <h4 class="action-title">Proses Pesanan</h4>
            </div>
            <div class="action-body">
                <p class="action-desc">Pesanan sudah dibayar. Mulai proses pengemasan produk sekarang.</p>
                <form action="{{ route('pedagang.orders.process', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-action btn-process">
                        🔄 Mulai Proses Pesanan
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if(in_array($order->status, ['paid', 'processing']))
        <div class="action-card">
            <div class="action-header">
                <div class="action-icon ship">🚚</div>
                <h4 class="action-title">Kirim ke Kurir</h4>
            </div>
            <div class="action-body">
                <form action="{{ route('pedagang.orders.ready-pickup', $order) }}" method="POST">
                    @csrf
                    <label style="font-size: 0.85rem; font-weight: 600; color: #374151; display: block; margin-bottom: 0.5rem;">Pilih Kurir</label>
                    <select name="kurir_id" class="form-select-custom" required>
                        <option value="">-- Pilih Kurir --</option>
                        @foreach($kurirs ?? [] as $kurir)
                        <option value="{{ $kurir->id }}">{{ $kurir->name }} ({{ $kurir->phone ?? '-' }})</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-action btn-ship">
                        📦 Siap Diambil Kurir
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if(in_array($order->status, ['ready_pickup', 'shipped', 'completed']))
        <!-- Delivery Timeline -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon kurir">🚚</div>
                <h3>Info Pengiriman</h3>
            </div>
            <div class="info-card-body">
                @if($order->kurir)
                <div class="user-profile">
                    <div class="user-avatar" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                        {{ strtoupper(substr($order->kurir->name ?? 'K', 0, 1)) }}
                    </div>
                    <div>
                        <div class="user-name">{{ $order->kurir->name ?? '-' }}</div>
                        <div class="user-role">🛵 Kurir</div>
                    </div>
                </div>
                @endif
                
                <div class="shipping-timeline">
                    <div class="shipping-step {{ $order->kurir ? 'done' : '' }}">
                        <div class="shipping-dot">{{ $order->kurir ? '✓' : '1' }}</div>
                        <div class="shipping-info">
                            <div class="shipping-title">Kurir Ditugaskan</div>
                            <div class="shipping-time">{{ $order->kurir ? $order->kurir->name : 'Menunggu...' }}</div>
                        </div>
                    </div>
                    <div class="shipping-step {{ $order->picked_up_at ? 'done' : '' }}">
                        <div class="shipping-dot">{{ $order->picked_up_at ? '✓' : '2' }}</div>
                        <div class="shipping-info">
                            <div class="shipping-title">Diambil Kurir</div>
                            <div class="shipping-time">{{ $order->picked_up_at ? $order->picked_up_at->format('d M Y H:i') : 'Menunggu...' }}</div>
                        </div>
                    </div>
                    <div class="shipping-step {{ $order->delivered_at ? 'done' : '' }}">
                        <div class="shipping-dot">{{ $order->delivered_at ? '✓' : '3' }}</div>
                        <div class="shipping-info">
                            <div class="shipping-title">Diterima Pembeli</div>
                            <div class="shipping-time">{{ $order->delivered_at ? $order->delivered_at->format('d M Y H:i') : 'Menunggu...' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
