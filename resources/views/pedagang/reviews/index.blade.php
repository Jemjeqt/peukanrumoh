@extends('layouts.dashboard')

@section('title', 'Ulasan Produk')
@section('panel_subtitle', 'Pedagang Panel')
@section('page_title', 'Ulasan')
@section('page_subtitle', 'Lihat ulasan dari pembeli')

@section('content')
<!-- Stats Cards -->
<div class="stats-grid mb-2">
    <div class="stat-card">
        <div class="stat-icon green">⭐</div>
        <div class="stat-info">
            <h3>{{ number_format($stats['average'], 1) }}</h3>
            <p>Rating Rata-rata</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">📝</div>
        <div class="stat-info">
            <h3>{{ $stats['total'] }}</h3>
            <p>Total Ulasan</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">🌟</div>
        <div class="stat-info">
            <h3>{{ $stats['count_5'] }}</h3>
            <p>Rating 5 Bintang</p>
        </div>
    </div>
</div>

<!-- Rating Distribution -->
<div class="card mb-2">
    <div class="card-header">
        <h3 class="card-title">📊 Distribusi Rating</h3>
    </div>
    <div class="card-body">
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            @foreach([5, 4, 3, 2, 1] as $rating)
            @php
                $count = $stats['count_' . $rating];
                $percentage = $stats['total'] > 0 ? ($count / $stats['total']) * 100 : 0;
            @endphp
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span style="width: 60px; font-size: 13px;">{{ $rating }} ⭐</span>
                <div style="flex: 1; height: 8px; background: #e0e0e0; border-radius: 4px; overflow: hidden;">
                    <div style="width: {{ $percentage }}%; height: 100%; background: linear-gradient(90deg, var(--primary), var(--primary-light)); border-radius: 4px;"></div>
                </div>
                <span style="width: 40px; font-size: 12px; color: var(--text-gray);">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-2">
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
            <div class="form-group mb-0" style="flex: 1; min-width: 150px;">
                <label class="form-label">Filter Rating</label>
                <select name="rating" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Rating</option>
                    @for($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                    @endfor
                </select>
            </div>
            <div class="form-group mb-0" style="flex: 2; min-width: 200px;">
                <label class="form-label">Filter Produk</label>
                <select name="product_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Produk</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }} ({{ $product->reviews_count }} ulasan)
                    </option>
                    @endforeach
                </select>
            </div>
            @if(request('rating') || request('product_id'))
            <a href="{{ route('pedagang.reviews.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>
    </div>
</div>

<!-- Reviews List -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">📋 Daftar Ulasan</h3>
    </div>
    <div class="card-body" style="padding: 0;">
        @forelse($reviews as $review)
        <div style="padding: 1rem 1.25rem; border-bottom: 1px solid var(--border);">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                <div>
                    <div style="font-weight: 600; margin-bottom: 0.25rem;">{{ $review->user->name ?? 'Pembeli' }}</div>
                    <div style="font-size: 12px; color: var(--text-gray);">
                        📦 {{ $review->product->name ?? 'Produk' }} • 🛒 Order #{{ str_pad($review->order_id ?? 0, 6, '0', STR_PAD_LEFT) }}
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="color: #ffc107; font-size: 14px;">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        @endfor
                    </div>
                    <div style="font-size: 11px; color: var(--text-gray);">{{ $review->created_at->format('d M Y') }}</div>
                </div>
            </div>
            @if($review->comment)
            <p style="margin: 0; color: var(--text-dark); font-size: 13px; line-height: 1.5;">
                "{{ $review->comment }}"
            </p>
            @else
            <p style="margin: 0; color: var(--text-gray); font-size: 13px; font-style: italic;">
                (Tidak ada komentar)
            </p>
            @endif
        </div>
        @empty
        <div style="text-align: center; padding: 4rem 2rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">⭐</div>
            <h3 style="margin-bottom: 0.5rem;">Belum Ada Ulasan</h3>
            <p class="text-muted">Ulasan dari pembeli akan muncul di sini</p>
        </div>
        @endforelse
    </div>
</div>

@if($reviews->hasPages())
<div style="margin-top: 1.5rem;">
    {{ $reviews->withQueryString()->links() }}
</div>
@endif
@endsection
