@extends('layouts.dashboard')

@section('title', 'Laporan Ulasan')
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Laporan Ulasan')
@section('page_subtitle', 'Analisis ulasan pembeli')

@section('styles')
<style>
    .report-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .report-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .report-card-lg {
        grid-column: span 2;
    }

    .metric-value {
        font-size: 2rem;
        font-weight: 700;
        color: #11998e;
    }

    .metric-label {
        font-size: 0.85rem;
        color: #888;
        margin-top: 0.25rem;
    }

    .metric-icon {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    /* Rating Bar Chart */
    .rating-chart {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .rating-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .rating-label {
        width: 50px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .rating-bar-bg {
        flex: 1;
        height: 24px;
        background: #f0f0f0;
        border-radius: 6px;
        overflow: hidden;
    }

    .rating-bar {
        height: 100%;
        background: linear-gradient(90deg, #11998e, #38ef7d);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 8px;
        min-width: 30px;
    }

    .rating-bar span {
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
    }

    .rating-count {
        width: 40px;
        text-align: right;
        font-size: 0.85rem;
        color: #666;
    }

    /* Reviews Table */
    .reviews-table {
        width: 100%;
        border-collapse: collapse;
    }

    .reviews-table th {
        text-align: left;
        padding: 1rem;
        background: #f8f9fa;
        font-size: 0.8rem;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .reviews-table td {
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.9rem;
        vertical-align: top;
    }

    .reviews-table tr:hover {
        background: #fafafa;
    }

    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .reviewer-avatar {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .reviewer-name {
        font-weight: 600;
        color: #333;
    }

    .reviewer-email {
        font-size: 0.8rem;
        color: #888;
    }

    .product-info {
        max-width: 200px;
    }

    .product-name {
        font-weight: 500;
        color: #333;
    }

    .product-seller {
        font-size: 0.8rem;
        color: #888;
    }

    .rating-stars {
        display: flex;
        gap: 2px;
    }

    .star-filled {
        color: #ffc107;
    }

    .star-empty {
        color: #ddd;
    }

    .comment-text {
        max-width: 300px;
        font-size: 0.85rem;
        color: #555;
        line-height: 1.5;
    }

    .comment-empty {
        color: #999;
        font-style: italic;
    }

    .date-col {
        white-space: nowrap;
        color: #888;
        font-size: 0.85rem;
    }

    /* Filters */
    .filter-bar {
        display: flex;
        gap: 1rem;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px 8px 0 0;
        border-bottom: 1px solid #eee;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-group label {
        font-size: 0.85rem;
        color: #666;
    }

    .filter-group select {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 0.85rem;
        background: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    @media (max-width: 992px) {
        .report-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .report-card-lg {
            grid-column: span 2;
        }
    }

    @media (max-width: 576px) {
        .report-grid {
            grid-template-columns: 1fr;
        }
        .report-card-lg {
            grid-column: span 1;
        }
    }
</style>
@endsection

@section('content')
<!-- Stats Overview -->
<div class="report-grid">
    <div class="report-card">
        <div class="metric-icon">⭐</div>
        <div class="metric-value">{{ number_format($stats['average'], 1) }}</div>
        <div class="metric-label">Rating Rata-rata</div>
    </div>
    <div class="report-card">
        <div class="metric-icon">📝</div>
        <div class="metric-value">{{ $stats['total'] }}</div>
        <div class="metric-label">Total Ulasan</div>
    </div>
    <div class="report-card">
        <div class="metric-icon">🌟</div>
        <div class="metric-value">{{ $stats['count_5'] }}</div>
        <div class="metric-label">Rating 5 Bintang</div>
    </div>
    <div class="report-card">
        <div class="metric-icon">📊</div>
        <div class="metric-value">{{ $stats['total'] > 0 ? round(($stats['count_5'] + $stats['count_4']) / $stats['total'] * 100) : 0 }}%</div>
        <div class="metric-label">Kepuasan (4-5⭐)</div>
    </div>
</div>

<!-- Rating Distribution Chart -->
<div class="report-card report-card-lg mb-2">
    <h4 style="margin: 0 0 1rem 0; font-size: 1rem; font-weight: 600;">📊 Distribusi Rating</h4>
    <div class="rating-chart">
        @foreach([5, 4, 3, 2, 1] as $rating)
        @php
            $count = $stats['count_' . $rating];
            $percentage = $stats['total'] > 0 ? ($count / $stats['total']) * 100 : 0;
        @endphp
        <div class="rating-row">
            <div class="rating-label">{{ $rating }} ⭐</div>
            <div class="rating-bar-bg">
                <div class="rating-bar" style="width: {{ max($percentage, 5) }}%;">
                    @if($percentage > 15)
                    <span>{{ round($percentage) }}%</span>
                    @endif
                </div>
            </div>
            <div class="rating-count">{{ $count }}</div>
        </div>
        @endforeach
    </div>
</div>

<!-- Reviews Table -->
<div class="card">
    <form method="GET" class="filter-bar">
        <div class="filter-group">
            <label>Rating:</label>
            <select name="rating" onchange="this.form.submit()">
                <option value="">Semua</option>
                @for($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                @endfor
            </select>
        </div>
        <div class="filter-group">
            <label>Produk:</label>
            <select name="product_id" onchange="this.form.submit()">
                <option value="">Semua Produk</option>
                @foreach($products as $product)
                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                    {{ Str::limit($product->name, 30) }} ({{ $product->reviews_count }})
                </option>
                @endforeach
            </select>
        </div>
        @if(request('rating') || request('product_id'))
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary btn-sm">Reset Filter</a>
        @endif
    </form>

    @if($reviews->count() > 0)
    <table class="reviews-table">
        <thead>
            <tr>
                <th>Pembeli</th>
                <th>Produk</th>
                <th>Rating</th>
                <th>Komentar</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
            <tr>
                <td>
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">{{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}</div>
                        <div>
                            <div class="reviewer-name">{{ $review->user->name ?? 'Unknown' }}</div>
                            <div class="reviewer-email">{{ $review->user->email ?? '-' }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="product-info">
                        <div class="product-name">{{ $review->product->name ?? 'Produk Dihapus' }}</div>
                        @if($review->product && $review->product->pedagang)
                        <div class="product-seller">🏪 {{ $review->product->pedagang->name }}</div>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}">★</span>
                        @endfor
                    </div>
                </td>
                <td>
                    @if($review->comment)
                    <div class="comment-text">"{{ Str::limit($review->comment, 100) }}"</div>
                    @else
                    <span class="comment-empty">Tidak ada komentar</span>
                    @endif
                </td>
                <td class="date-col">{{ $review->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <div class="empty-icon">⭐</div>
        <h3>Belum Ada Ulasan</h3>
        <p class="text-muted">Data ulasan akan muncul di sini</p>
    </div>
    @endif
</div>

@if($reviews->hasPages())
<div style="margin-top: 1rem;">
    {{ $reviews->withQueryString()->links() }}
</div>
@endif
@endsection
