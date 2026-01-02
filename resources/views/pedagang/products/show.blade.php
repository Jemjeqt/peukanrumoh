@extends('layouts.dashboard')

@section('title', $product->name)
@section('panel_subtitle', 'Pedagang Panel')
@section('page_title', 'Detail Produk')
@section('page_subtitle', $product->name)

@section('header_actions')
<a href="{{ route('pedagang.products.index') }}" class="btn btn-secondary">← Kembali</a>
@endsection

@section('styles')
<style>
    .product-detail {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 2rem;
    }
    
    .product-image-section {
        position: sticky;
        top: 80px;
    }
    
    .product-main-image {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
        border-radius: 16px;
        background: #f5f5f5;
    }
    
    .product-info h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .product-price {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1rem;
    }
    
    .product-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #f5f5f5;
        border-radius: 8px;
        font-size: 0.9rem;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-box {
        background: linear-gradient(135deg, #f8faff, #fff);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
    }
    
    .stat-box .icon {
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
    }
    
    .stat-box .value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
    }
    
    .stat-box .label {
        font-size: 0.8rem;
        color: var(--text-gray);
    }
    
    .description-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .description-section h3 {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
    }
    
    .action-buttons .btn {
        flex: 1;
    }
    
    @media (max-width: 768px) {
        .product-detail {
            grid-template-columns: 1fr;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="mb-2">
    <a href="{{ route('pedagang.products.index') }}" class="btn btn-outline btn-sm">← Kembali ke Daftar Produk</a>
</div>

<div class="product-detail">
    <!-- Left: Image -->
    <div class="product-image-section">
        @if($product->image)
            <img src="{{ $product->image_url ?? asset('storage/' . $product->image) }}" 
                 alt="{{ $product->name }}" class="product-main-image">
        @else
            <div class="product-main-image" style="display: flex; align-items: center; justify-content: center; font-size: 5rem;">📦</div>
        @endif
    </div>
    
    <!-- Right: Info -->
    <div class="product-info">
        <h1>{{ $product->name }}</h1>
        
        <div class="product-meta">
            <div class="meta-item">
                <span class="badge badge-{{ $product->is_active ? 'success' : 'secondary' }}">
                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            <div class="meta-item">
                📁 {{ $product->category }}
            </div>
            <div class="meta-item">
                📦 Stok: <strong>{{ $product->stock }}</strong>
            </div>
        </div>
        
        <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
        
        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-box">
                <div class="icon">📈</div>
                <div class="value">{{ $totalSold }}</div>
                <div class="label">Terjual</div>
            </div>
            <div class="stat-box">
                <div class="icon">💰</div>
                <div class="value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="label">Pendapatan</div>
            </div>
            <div class="stat-box">
                <div class="icon">⭐</div>
                <div class="value">{{ $avgRating ? number_format($avgRating, 1) : '-' }}</div>
                <div class="label">Rating</div>
            </div>
        </div>
        
        <!-- Description -->
        <div class="description-section">
            <h3>📝 Deskripsi Produk</h3>
            <p>{{ $product->description }}</p>
        </div>
        
        <!-- Actions -->
        <div class="action-buttons">
            <a href="{{ route('pedagang.products.edit', $product) }}" class="btn btn-primary">
                ✏️ Edit Produk
            </a>
            <button type="button" class="btn btn-danger" id="deleteProductBtn">🗑️ Hapus Produk</button>
        </div>
        
        <form id="deleteProductForm" action="{{ route('pedagang.products.destroy', $product) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        
        <!-- Reviews Section -->
        @if($product->reviews->count() > 0)
        <div class="card mt-2">
            <div class="card-header">
                <h3 style="margin: 0;">⭐ Ulasan ({{ $product->reviews->count() }})</h3>
            </div>
            <div class="card-body">
                @foreach($product->reviews->take(5) as $review)
                <div style="padding: 0.75rem 0; border-bottom: 1px solid var(--border);">
                    <div class="d-flex justify-between">
                        <strong>{{ $review->user->name ?? 'Pembeli' }}</strong>
                        <span>{{ str_repeat('⭐', $review->rating) }}</span>
                    </div>
                    <p class="text-muted text-small mb-0">{{ $review->comment }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('deleteProductBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Hapus Produk?',
            text: 'Produk "{{ $product->name }}" akan dihapus permanen. Tindakan ini tidak dapat dibatalkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteProductForm').submit();
            }
        });
    });
});
</script>
@endsection

