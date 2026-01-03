@extends('layouts.dashboard')

@section('title', 'Detail Pesanan #' . $order->id)
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Detail Pesanan')
@section('page_subtitle', 'Pesanan #' . $order->id)

@section('header_actions')
<a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">← Kembali</a>
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
        font-size: 2rem;
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
        font-size: 1.5rem;
        font-weight: 700;
        display: block;
    }
    
    .hero-stat-label {
        font-size: 0.8rem;
        opacity: 0.9;
    }
    
    /* Timeline */
    .order-timeline {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }
    
    .timeline-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .timeline-track {
        display: flex;
        justify-content: space-between;
        position: relative;
    }
    
    .timeline-track::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 5%;
        right: 5%;
        height: 4px;
        background: #e5e7eb;
        border-radius: 2px;
    }
    
    .timeline-step {
        flex: 1;
        text-align: center;
        position: relative;
        z-index: 1;
    }
    
    .timeline-dot {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        font-size: 1rem;
        transition: all 0.3s;
    }
    
    .timeline-step.active .timeline-dot {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.4);
    }
    
    .timeline-step.completed .timeline-dot {
        background: #22c55e;
        color: white;
    }
    
    .timeline-step.cancelled .timeline-dot {
        background: #ef4444;
        color: white;
    }
    
    .timeline-label {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 500;
    }
    
    .timeline-step.active .timeline-label,
    .timeline-step.completed .timeline-label {
        color: #11998e;
        font-weight: 600;
    }
    
    /* Main Grid */
    .order-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 1.5rem;
    }
    
    .order-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    
    .order-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .order-header-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .order-header h2 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        color: #1a1a2e;
    }
    
    .order-body { padding: 1.5rem; }
    
    /* Product Cards */
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
        border-radius: 12px;
        transition: all 0.2s;
    }
    
    .product-item:hover {
        border-color: #11998e;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    
    .product-image {
        width: 70px;
        height: 70px;
        border-radius: 10px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
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
    }
    
    .product-name {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 0.25rem;
    }
    
    .product-price {
        font-size: 0.85rem;
        color: #6b7280;
    }
    
    .product-subtotal {
        text-align: right;
    }
    
    .product-qty {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }
    
    .product-total {
        font-weight: 700;
        color: #11998e;
        font-size: 1.1rem;
    }
    
    /* Order Summary */
    .order-summary {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 12px;
        padding: 1.25rem;
        margin-top: 1rem;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    
    .summary-row.total {
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 2px dashed #22c55e;
        font-size: 1.25rem;
        font-weight: 700;
    }
    
    .summary-row.total .summary-value {
        color: #16a34a;
    }
    
    /* Info Cards */
    .info-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        margin-bottom: 1rem;
    }
    
    .info-card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .info-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }
    
    .info-icon.user { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
    .info-icon.shipping { background: linear-gradient(135deg, #fef3c7, #fde68a); }
    .info-icon.status { background: linear-gradient(135deg, #d1fae5, #a7f3d0); }
    
    .info-card-header h3 {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        color: #1a1a2e;
    }
    
    .info-card-body { padding: 1.25rem; }
    
    /* User Profile Card */
    .user-profile {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
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
        font-size: 1.1rem;
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
        width: 28px;
        height: 28px;
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
        font-size: 0.75rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .info-item-value {
        font-size: 0.95rem;
        color: #1a1a2e;
        font-weight: 500;
    }
    
    /* Shipping Timeline Mini */
    .shipping-timeline {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .shipping-step {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: #f9fafb;
        border-radius: 10px;
    }
    
    .shipping-step.done {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    }
    
    .shipping-dot {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
    }
    
    .shipping-step.done .shipping-dot {
        background: #22c55e;
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
    
    /* Update Form */
    .update-form select {
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
    
    .update-form select:focus {
        outline: none;
        border-color: #11998e;
        box-shadow: 0 0 0 3px rgba(17, 153, 142, 0.1);
    }
    
    .btn-update {
        width: 100%;
        padding: 0.9rem;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(17, 153, 142, 0.35);
    }
    
    /* Quick Actions */
    .quick-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    
    .quick-btn {
        flex: 1;
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        background: white;
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
    }
    
    .quick-btn:hover {
        border-color: #11998e;
        color: #11998e;
    }

    @media (max-width: 768px) {
        .order-grid { grid-template-columns: 1fr; }
        .hero-stats { grid-template-columns: repeat(2, 1fr); }
        .timeline-track { flex-wrap: wrap; gap: 0.5rem; }
        .timeline-track::before { display: none; }
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
<div class="order-hero">
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

<!-- Order Status Timeline -->
<div class="order-timeline">
    <div class="timeline-title">📊 Status Pesanan</div>
    <div class="timeline-track">
        @php
            $steps = [
                ['key' => 'pending', 'icon' => '⏳', 'label' => 'Menunggu'],
                ['key' => 'paid', 'icon' => '💳', 'label' => 'Dibayar'],
                ['key' => 'processing', 'icon' => '📦', 'label' => 'Diproses'],
                ['key' => 'ready_pickup', 'icon' => '🏪', 'label' => 'Siap Kirim'],
                ['key' => 'shipped', 'icon' => '🚚', 'label' => 'Dikirim'],
                ['key' => 'completed', 'icon' => '✅', 'label' => 'Selesai'],
            ];
        @endphp
        @foreach($steps as $index => $step)
            @php
                $stepClass = '';
                if ($isCancelled) {
                    $stepClass = 'cancelled';
                } elseif ($currentIndex !== false && $index < $currentIndex) {
                    $stepClass = 'completed';
                } elseif ($currentIndex !== false && $index == $currentIndex) {
                    $stepClass = 'active';
                }
            @endphp
            <div class="timeline-step {{ $stepClass }}">
                <div class="timeline-dot">{{ $step['icon'] }}</div>
                <div class="timeline-label">{{ $step['label'] }}</div>
            </div>
        @endforeach
    </div>
</div>

<div class="order-grid">
    <!-- Order Details -->
    <div class="order-card">
        <div class="order-header">
            <div class="order-header-icon" style="background: linear-gradient(135deg, #fef3c7, #fde68a);">🛒</div>
            <h2>Daftar Produk</h2>
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

    <!-- Order Info Sidebar -->
    <div>
        <!-- User Info Card -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon user">👤</div>
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
                    <div class="info-item-icon">📧</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Email</div>
                        <div class="info-item-value">{{ $order->user->email ?? '-' }}</div>
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

        <!-- Shipping Info Card -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon shipping">🚚</div>
                <h3>Informasi Pengiriman</h3>
            </div>
            <div class="info-card-body">
                <div class="shipping-timeline">
                    <div class="shipping-step {{ $order->kurir ? 'done' : '' }}">
                        <div class="shipping-dot">{{ $order->kurir ? '✓' : '1' }}</div>
                        <div class="shipping-info">
                            <div class="shipping-title">Kurir Ditugaskan</div>
                            <div class="shipping-time">{{ $order->kurir->name ?? 'Menunggu...' }}</div>
                        </div>
                    </div>
                    <div class="shipping-step {{ $order->picked_up_at ? 'done' : '' }}">
                        <div class="shipping-dot">{{ $order->picked_up_at ? '✓' : '2' }}</div>
                        <div class="shipping-info">
                            <div class="shipping-title">Diambil Kurir</div>
                            <div class="shipping-time">{{ $order->picked_up_at ? $order->picked_up_at->format('d M Y, H:i') : 'Menunggu...' }}</div>
                        </div>
                    </div>
                    <div class="shipping-step {{ $order->delivered_at ? 'done' : '' }}">
                        <div class="shipping-dot">{{ $order->delivered_at ? '✓' : '3' }}</div>
                        <div class="shipping-info">
                            <div class="shipping-title">Pesanan Diantar</div>
                            <div class="shipping-time">{{ $order->delivered_at ? $order->delivered_at->format('d M Y, H:i') : 'Menunggu...' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Status Card -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon status">⚙️</div>
                <h3>Update Status</h3>
            </div>
            <div class="info-card-body">
                <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="update-form">
                    @csrf @method('PATCH')
                    <select name="status">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ Menunggu Bayar</option>
                        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>💳 Sudah Dibayar</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>📦 Diproses</option>
                        <option value="ready_pickup" {{ $order->status === 'ready_pickup' ? 'selected' : '' }}>🏪 Siap Diambil Kurir</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>🚚 Dalam Pengiriman</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                    </select>
                    <button type="submit" class="btn-update">
                        🔄 Update Status
                    </button>
                </form>
                
                <div class="quick-actions">
                    <button class="quick-btn" onclick="window.print()">🖨️ Print</button>
                    <a href="mailto:{{ $order->user->email ?? '' }}" class="quick-btn">📧 Email</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
