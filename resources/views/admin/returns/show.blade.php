@extends('layouts.dashboard')

@section('title', 'Detail Return #' . $return->id)
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Detail Return')
@section('page_subtitle', 'Return #' . $return->id)

@section('header_actions')
<a href="{{ route('admin.returns.index') }}" class="btn btn-secondary">← Kembali</a>
@endsection

@section('styles')
<style>
    /* Hero Header */
    .return-hero {
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .return-hero.refund { background: linear-gradient(135deg, #f97316, #ea580c); }
    .return-hero.replacement { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .return-hero.pending { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .return-hero.completed { background: linear-gradient(135deg, #22c55e, #16a34a); }
    .return-hero.rejected { background: linear-gradient(135deg, #ef4444, #dc2626); }
    
    .return-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 50%;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(30deg);
    }
    
    .return-hero-content {
        position: relative;
        z-index: 1;
    }
    
    .return-hero-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    
    .return-id-large {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
    }
    
    .return-date {
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
        font-size: 1.25rem;
        font-weight: 700;
        display: block;
    }
    
    .hero-stat-label {
        font-size: 0.8rem;
        opacity: 0.9;
    }
    
    /* Timeline */
    .return-timeline {
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
        left: 10%;
        right: 10%;
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
        background: linear-gradient(135deg, #f97316, #ea580c);
        color: white;
        box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
    }
    
    .timeline-step.completed .timeline-dot {
        background: #22c55e;
        color: white;
    }
    
    .timeline-step.rejected .timeline-dot {
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
        color: #f97316;
        font-weight: 600;
    }
    
    /* Main Grid */
    .return-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 1.5rem;
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
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
    
    .info-icon.return { background: linear-gradient(135deg, #fef3c7, #fde68a); }
    .info-icon.product { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
    .info-icon.user { background: linear-gradient(135deg, #d1fae5, #a7f3d0); }
    .info-icon.shipping { background: linear-gradient(135deg, #ede9fe, #ddd6fe); }
    .info-icon.action { background: linear-gradient(135deg, #fce7f3, #fbcfe8); }
    
    .info-card-header h3 {
        font-size: 1.05rem;
        font-weight: 700;
        margin: 0;
        color: #1a1a2e;
    }
    
    .info-card-body { padding: 1.5rem; }
    
    /* Info Items */
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .info-item:last-child { border-bottom: none; }
    
    .info-item-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    
    .info-item-content { flex: 1; }
    
    .info-item-label {
        font-size: 0.75rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .info-item-value {
        font-size: 1rem;
        color: #1a1a2e;
        font-weight: 500;
    }
    
    /* Type Badge */
    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 1rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .type-badge.refund {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #b45309;
    }
    
    .type-badge.replacement {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1d4ed8;
    }
    
    /* Product Cards */
    .product-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
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
        border-color: #f97316;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    
    .product-image {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
        overflow: hidden;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-info { flex: 1; }
    
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
    }
    
    .product-total {
        font-weight: 700;
        color: #f97316;
        font-size: 1.05rem;
    }
    
    /* Order Summary */
    .order-summary {
        background: linear-gradient(135deg, #fff7ed, #ffedd5);
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
        border-top: 2px dashed #f97316;
        font-size: 1.25rem;
        font-weight: 700;
    }
    
    .summary-row.total .summary-value {
        color: #ea580c;
    }
    
    /* User Profile */
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
        background: linear-gradient(135deg, #22c55e, #16a34a);
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
    }
    
    /* Kurir Info */
    .kurir-card {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        background: linear-gradient(135deg, #f8fafc, #ffffff);
        border: 1px solid #e5e7eb;
        border-radius: 12px;
    }
    
    .kurir-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    
    .kurir-name {
        font-weight: 700;
        color: #1a1a2e;
    }
    
    .kurir-label {
        font-size: 0.8rem;
        color: #6b7280;
    }
    
    /* Reason Box */
    .reason-box {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        border: 1px solid #fecaca;
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        gap: 1rem;
    }
    
    .reason-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    
    .reason-content { flex: 1; }
    
    .reason-label {
        font-size: 0.75rem;
        color: #b91c1c;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }
    
    .reason-text {
        font-weight: 600;
        color: #991b1b;
    }
    
    /* Evidence */
    .evidence-section {
        margin-top: 1rem;
    }
    
    .evidence-label {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }
    
    .evidence-image {
        width: 100%;
        max-height: 200px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
    }

    @media (max-width: 768px) {
        .return-grid { grid-template-columns: 1fr; }
        .hero-stats { grid-template-columns: repeat(2, 1fr); }
        .timeline-track { flex-wrap: wrap; gap: 0.5rem; }
        .timeline-track::before { display: none; }
    }
</style>
@endsection

@section('content')
@php
    $statusOrder = ['pending', 'pickup', 'received', 'completed'];
    $currentIndex = array_search($return->status, $statusOrder);
    $isRejected = $return->status === 'rejected';
@endphp

<!-- Hero Header -->
<div class="return-hero {{ $return->type }} {{ $return->status }}">
    <div class="return-hero-content">
        <div class="return-hero-top">
            <div>
                <div class="return-id-large">Return #{{ $return->id }}</div>
                <div class="return-date">📅 Request: {{ $return->created_at->format('d F Y, H:i') }} WIB</div>
            </div>
            <span class="status-badge-large">{{ ucfirst($return->status) }}</span>
        </div>
        
        <div class="hero-stats">
            <div class="hero-stat">
                <span class="hero-stat-value">#{{ str_pad($return->order_id, 6, '0', STR_PAD_LEFT) }}</span>
                <span class="hero-stat-label">ID Pesanan</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-value">{{ $return->type === 'refund' ? '💰 Refund' : '🔄 Tukar' }}</span>
                <span class="hero-stat-label">Tipe Return</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-value">{{ $return->order->items->count() }}</span>
                <span class="hero-stat-label">Produk</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-value">Rp {{ number_format($return->order->total, 0, ',', '.') }}</span>
                <span class="hero-stat-label">Nilai Order</span>
            </div>
        </div>
    </div>
</div>

<!-- Return Timeline -->
<div class="return-timeline">
    <div class="timeline-title">📊 Status Return</div>
    <div class="timeline-track">
        @php
            $steps = [
                ['key' => 'pending', 'icon' => '📝', 'label' => 'Pending'],
                ['key' => 'pickup', 'icon' => '🚚', 'label' => 'Diambil'],
                ['key' => 'received', 'icon' => '📦', 'label' => 'Diterima'],
                ['key' => 'completed', 'icon' => '✅', 'label' => 'Selesai'],
            ];
        @endphp
        @foreach($steps as $index => $step)
            @php
                $stepClass = '';
                if ($isRejected) {
                    $stepClass = 'rejected';
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

<div class="return-grid">
    <!-- Main Info -->
    <div>
        <!-- Return Info Card -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon return">↩️</div>
                <h3>Informasi Return</h3>
            </div>
            <div class="info-card-body">
                <div class="info-item">
                    <div class="info-item-icon">🆔</div>
                    <div class="info-item-content">
                        <div class="info-item-label">ID Return</div>
                        <div class="info-item-value"><strong>#{{ $return->id }}</strong></div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">📦</div>
                    <div class="info-item-content">
                        <div class="info-item-label">ID Pesanan</div>
                        <div class="info-item-value">#{{ str_pad($return->order_id, 6, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">🏷️</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Tipe Return</div>
                        <div class="info-item-value">
                            <span class="type-badge {{ $return->type }}">
                                {{ $return->type === 'refund' ? '💰 Refund' : '🔄 Tukar Barang' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">📅</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Tanggal Request</div>
                        <div class="info-item-value">{{ $return->created_at->format('d F Y, H:i') }}</div>
                    </div>
                </div>
                
                <!-- Reason Box -->
                <div class="reason-box" style="margin-top: 1rem;">
                    <div class="reason-icon">❗</div>
                    <div class="reason-content">
                        <div class="reason-label">Alasan Return</div>
                        <div class="reason-text">{{ $return->reason }}</div>
                    </div>
                </div>
                
                @if($return->evidence)
                <div class="evidence-section">
                    <div class="evidence-label">📸 Bukti/Evidence:</div>
                    <img src="{{ asset('storage/' . $return->evidence) }}" alt="Evidence" class="evidence-image">
                </div>
                @endif
            </div>
        </div>
        
        <!-- Product Card -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon product">📦</div>
                <h3>Produk Pesanan</h3>
            </div>
            <div class="info-card-body">
                <div class="product-list">
                    @foreach($return->order->items as $item)
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
                        <span>Subtotal ({{ $return->order->items->sum('quantity') }} item)</span>
                        <span>Rp {{ number_format($return->order->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total Nilai Return</span>
                        <span class="summary-value">Rp {{ number_format($return->order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div>
        <!-- User Info -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon user">👤</div>
                <h3>Informasi Pembeli</h3>
            </div>
            <div class="info-card-body">
                <div class="user-profile">
                    <div class="user-avatar">
                        {{ strtoupper(substr($return->user->name ?? 'G', 0, 1)) }}
                    </div>
                    <div>
                        <div class="user-name">{{ $return->user->name ?? 'Guest' }}</div>
                        <div class="user-role">🛒 Pembeli</div>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-item-icon">📧</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Email</div>
                        <div class="info-item-value">{{ $return->user->email ?? '-' }}</div>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-item-icon">📱</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Telepon</div>
                        <div class="info-item-value">{{ $return->user->phone ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Kurir Info -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon shipping">🚚</div>
                <h3>Informasi Kurir</h3>
            </div>
            <div class="info-card-body">
                @if($return->order->kurir)
                <div class="kurir-card">
                    <div class="kurir-avatar">
                        {{ strtoupper(substr($return->order->kurir->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="kurir-name">{{ $return->order->kurir->name }}</div>
                        <div class="kurir-label">🚚 Kurir Pengantar</div>
                    </div>
                </div>
                @else
                <div style="text-align: center; padding: 1.5rem; color: #9ca3af;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.5;">🚚</div>
                    <p>Belum ada kurir ditugaskan</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon action">⚡</div>
                <h3>Aksi Cepat</h3>
            </div>
            <div class="info-card-body">
                <a href="{{ route('admin.orders.show', $return->order) }}" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 1rem; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s; margin-bottom: 0.75rem;">
                    📋 Lihat Detail Pesanan
                </a>
                <a href="mailto:{{ $return->user->email ?? '' }}" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 1rem; border: 2px solid #e5e7eb; color: #374151; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s;">
                    📧 Hubungi Pembeli
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
