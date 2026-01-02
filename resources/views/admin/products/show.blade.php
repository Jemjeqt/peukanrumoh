@extends('layouts.dashboard')

@section('title', 'Detail Produk - ' . $product->name)
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Detail Produk')
@section('page_subtitle', $product->name)

@section('header_actions')
<a href="{{ route('admin.products.index') }}" class="btn btn-secondary">← Kembali</a>
@endsection

@section('styles')
<style>
    /* Hero Header */
    .product-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .product-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 50%;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(30deg);
    }
    
    .product-hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 2rem;
    }
    
    .hero-image-box {
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 4px solid rgba(255,255,255,0.4);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        flex-shrink: 0;
        overflow: hidden;
    }
    
    .hero-image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .hero-info { flex: 1; }
    
    .hero-name {
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .hero-category {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.5rem 1rem;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .hero-price {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .hero-badges {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .hero-badge {
        padding: 0.4rem 1rem;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 600;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
    }
    
    .badge-active {
        background: rgba(34, 197, 94, 0.3);
        border: 1px solid rgba(34, 197, 94, 0.5);
    }
    
    .badge-inactive {
        background: rgba(239, 68, 68, 0.3);
        border: 1px solid rgba(239, 68, 68, 0.5);
    }
    
    /* Stats Cards */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        text-align: center;
        transition: all 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 0.75rem;
    }
    
    .stat-icon.price { background: linear-gradient(135deg, #d1fae5, #a7f3d0); }
    .stat-icon.stock { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
    .stat-icon.reviews { background: linear-gradient(135deg, #fef3c7, #fde68a); }
    .stat-icon.sold { background: linear-gradient(135deg, #ede9fe, #ddd6fe); }
    
    .stat-value {
        font-size: 1.35rem;
        font-weight: 700;
        color: #1a1a2e;
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
    
    /* Main Grid */
    .product-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
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
    
    .info-icon.product { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
    .info-icon.seller { background: linear-gradient(135deg, #d1fae5, #a7f3d0); }
    .info-icon.desc { background: linear-gradient(135deg, #fef3c7, #fde68a); }
    .info-icon.review { background: linear-gradient(135deg, #fce7f3, #fbcfe8); }
    
    .info-card-header h3 {
        font-size: 1.05rem;
        font-weight: 700;
        margin: 0;
        color: #1a1a2e;
    }
    
    .info-card-body { padding: 1.5rem; }
    
    /* Product Info Items */
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
    
    .info-item-value.price {
        color: #16a34a;
        font-size: 1.25rem;
        font-weight: 700;
    }
    
    /* Seller Card */
    .seller-profile {
        display: flex;
        gap: 1rem;
        padding: 1.25rem;
        background: linear-gradient(135deg, #f8fafc, #ffffff);
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.2s;
    }
    
    .seller-profile:hover {
        border-color: #22c55e;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    
    .seller-avatar {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #22c55e, #16a34a);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    
    .seller-info { flex: 1; }
    
    .seller-name {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1a1a2e;
    }
    
    .seller-email {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }
    
    .seller-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #b45309;
    }
    
    /* Description */
    .description-box {
        background: linear-gradient(135deg, #f8fafc, #ffffff);
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.25rem;
        line-height: 1.7;
        color: #374151;
    }
    
    /* Reviews */
    .review-item {
        padding: 1rem;
        background: linear-gradient(135deg, #f8fafc, #ffffff);
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 0.75rem;
        transition: all 0.2s;
    }
    
    .review-item:hover {
        border-color: #f59e0b;
    }
    
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.5rem;
    }
    
    .review-user {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .review-avatar {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .review-name {
        font-weight: 600;
        color: #1a1a2e;
    }
    
    .review-date {
        font-size: 0.75rem;
        color: #9ca3af;
    }
    
    .review-stars {
        color: #f59e0b;
        font-size: 0.9rem;
    }
    
    .review-comment {
        color: #4b5563;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-top: 0.5rem;
    }
    
    .no-reviews {
        text-align: center;
        padding: 2rem;
        color: #9ca3af;
    }
    
    .no-reviews-icon {
        font-size: 3rem;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .product-hero-content { flex-direction: column; text-align: center; }
        .hero-badges { justify-content: center; }
        .stats-row { grid-template-columns: repeat(2, 1fr); }
        .product-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
@php
    $avgRating = $product->reviews && $product->reviews->count() > 0 
        ? round($product->reviews->avg('rating'), 1) 
        : 0;
    $reviewCount = $product->reviews ? $product->reviews->count() : 0;
@endphp

<!-- Hero Header -->
<div class="product-hero">
    <div class="product-hero-content">
        <div class="hero-image-box">
            @if($product->image)
                <img src="{{ $product->image_url ?? $product->image }}" alt="{{ $product->name }}">
            @else
                📦
            @endif
        </div>
        <div class="hero-info">
            <span class="hero-category">🏷️ {{ $product->category }}</span>
            <div class="hero-name">{{ $product->name }}</div>
            <div class="hero-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <div class="hero-badges">
                @if($product->is_active)
                    <span class="hero-badge badge-active">✓ Aktif</span>
                @else
                    <span class="hero-badge badge-inactive">✗ Nonaktif</span>
                @endif
                <span class="hero-badge">📦 Stok: {{ $product->stock }} unit</span>
                @if($avgRating > 0)
                    <span class="hero-badge">⭐ {{ $avgRating }}/5</span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon price">💰</div>
        <div class="stat-value">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
        <div class="stat-label">Harga</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stock">📦</div>
        <div class="stat-value">{{ $product->stock }}</div>
        <div class="stat-label">Stok Tersedia</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon reviews">⭐</div>
        <div class="stat-value">{{ $avgRating > 0 ? $avgRating : '-' }}</div>
        <div class="stat-label">Rating ({{ $reviewCount }} ulasan)</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon sold">🛒</div>
        <div class="stat-value">-</div>
        <div class="stat-label">Terjual</div>
    </div>
</div>

<!-- Main Grid -->
<div class="product-grid">
    <!-- Left Column -->
    <div>
        <!-- Product Details -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon product">📋</div>
                <h3>Detail Produk</h3>
            </div>
            <div class="info-card-body">
                <div class="info-item">
                    <div class="info-item-icon">🆔</div>
                    <div class="info-item-content">
                        <div class="info-item-label">ID Produk</div>
                        <div class="info-item-value">#{{ $product->id }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">📦</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Nama Produk</div>
                        <div class="info-item-value">{{ $product->name }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">🏷️</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Kategori</div>
                        <div class="info-item-value">{{ $product->category }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">💰</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Harga</div>
                        <div class="info-item-value price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">📊</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Status</div>
                        <div class="info-item-value">
                            @if($product->is_active)
                                <span style="color: #16a34a; font-weight: 600;">✓ Aktif</span>
                            @else
                                <span style="color: #dc2626; font-weight: 600;">✗ Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Seller Info -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon seller">🏪</div>
                <h3>Informasi Pedagang</h3>
            </div>
            <div class="info-card-body">
                <div class="seller-profile">
                    <div class="seller-avatar">
                        {{ strtoupper(substr($product->pedagang->name ?? 'P', 0, 1)) }}
                    </div>
                    <div class="seller-info">
                        <div class="seller-name">{{ $product->pedagang->name ?? '-' }}</div>
                        <div class="seller-email">{{ $product->pedagang->email ?? '-' }}</div>
                        <span class="seller-badge">🏪 Pedagang Terverifikasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Column -->
    <div>
        <!-- Description -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon desc">📝</div>
                <h3>Deskripsi Produk</h3>
            </div>
            <div class="info-card-body">
                <div class="description-box">
                    {{ $product->description ?? 'Tidak ada deskripsi' }}
                </div>
            </div>
        </div>
        
        <!-- Reviews -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon review">⭐</div>
                <h3>Ulasan Produk ({{ $reviewCount }})</h3>
            </div>
            <div class="info-card-body">
                @if($product->reviews && $product->reviews->count() > 0)
                    @foreach($product->reviews->take(5) as $review)
                    <div class="review-item">
                        <div class="review-header">
                            <div class="review-user">
                                <div class="review-avatar">
                                    {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="review-name">{{ $review->user->name ?? 'User' }}</div>
                                    <div class="review-date">{{ $review->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                            <div class="review-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $review->rating ? '⭐' : '☆' }}
                                @endfor
                            </div>
                        </div>
                        @if($review->comment)
                        <p class="review-comment">{{ $review->comment }}</p>
                        @endif
                    </div>
                    @endforeach
                @else
                    <div class="no-reviews">
                        <div class="no-reviews-icon">💬</div>
                        <p>Belum ada ulasan untuk produk ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
