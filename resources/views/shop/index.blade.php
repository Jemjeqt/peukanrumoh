@extends('layouts.app')

@section('title', 'Belanja')

@section('styles')
<style>
    .shop-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fffe 0%, #f0f9f6 100%);
        padding: 2rem 0;
    }
    
    /* Page Header */
    .shop-header {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        border-radius: 24px;
        padding: 2.5rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .shop-header::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .shop-header::after {
        content: '';
        position: absolute;
        bottom: -80px;
        left: 30%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    
    .header-content {
        position: relative;
        z-index: 1;
    }
    
    .shop-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .shop-subtitle {
        font-size: 1rem;
        opacity: 0.9;
    }
    
    .header-emoji {
        position: absolute;
        right: 40px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 6rem;
        opacity: 0.8;
        z-index: 1;
    }
    
    /* Category Tabs */
    .category-section {
        background: white;
        border-radius: 20px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }
    
    .category-tabs {
        display: flex;
        gap: 0.75rem;
        overflow-x: auto;
        padding-bottom: 0.25rem;
    }
    
    .category-tab {
        padding: 0.625rem 1.25rem;
        background: #f8f9fa;
        border: 2px solid transparent;
        border-radius: 25px;
        color: #666;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        white-space: nowrap;
        transition: all 0.3s;
    }
    
    .category-tab:hover {
        border-color: #11998e;
        color: #11998e;
        background: #f0fdf4;
    }
    
    .category-tab.active {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
        border-color: transparent;
    }
    
    /* Products Grid */
    .products-section {
        margin-bottom: 2rem;
    }
    
    .products-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }
    
    /* Product Card */
    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s;
        border: 2px solid transparent;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.12);
        border-color: #11998e;
    }
    
    .product-image-container {
        position: relative;
        overflow: hidden;
    }
    
    .product-image {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
        background: #f5f5f5;
        transition: transform 0.3s;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .product-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: linear-gradient(135deg, #ff6b35, #f7931e);
        color: white;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 600;
        z-index: 5;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        white-space: nowrap;
    }
    
    .product-info {
        padding: 1.25rem;
    }
    
    .product-name {
        font-size: 1rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .product-name:hover {
        color: #11998e;
    }
    
    .product-price {
        font-size: 1.25rem;
        font-weight: 800;
        color: #11998e;
        margin-bottom: 0.5rem;
    }
    
    .product-store {
        font-size: 0.8rem;
        color: #888;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        margin-bottom: 0.35rem;
    }
    
    .product-stock {
        font-size: 0.75rem;
        color: #666;
        padding: 0.25rem 0.5rem;
        background: #f0f0f0;
        border-radius: 6px;
        display: inline-block;
    }
    
    .product-stock.low {
        background: #fef2f2;
        color: #dc2626;
    }
    
    .product-actions {
        padding: 0 1.25rem 1.25rem;
    }
    
    .add-cart-btn {
        width: 100%;
        padding: 0.875rem;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        font-family: inherit;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .add-cart-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(17, 153, 142, 0.3);
    }
    
    /* No Products */
    .no-products {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }
    
    .no-products-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }
    
    .no-products-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
    }
    
    .no-products-text {
        color: #888;
    }
    
    /* Pagination */
    .pagination-wrapper {
        margin-top: 2rem;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .products-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        
        .header-emoji {
            display: none;
        }
    }
    
    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .shop-header {
            padding: 1.5rem;
        }
        
        .shop-title {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="shop-page">
    <div class="container">
        <!-- Header -->
        <div class="shop-header">
            <div class="header-content">
                <h1 class="shop-title">🛒 Produk Segar</h1>
                <p class="shop-subtitle">Langsung dari pasar tradisional, kualitas terjamin!</p>
            </div>
            <div class="header-emoji">🥬</div>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success" style="margin-bottom: 1.5rem;">{{ session('success') }}</div>
        @endif
        
        <!-- Category Tabs -->
        <div class="category-section">
            <div class="category-tabs">
                <a href="{{ route('shop.index') }}" class="category-tab {{ !request('category') ? 'active' : '' }}">🏷️ Semua</a>
                @foreach($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category]) }}" 
                       class="category-tab {{ request('category') == $category ? 'active' : '' }}">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="products-section">
            @if($products->count() > 0)
                <div class="products-grid">
                    @foreach($products as $product)
                        <div class="product-card">
                            <a href="{{ route('shop.show', $product) }}" class="product-image-container">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/200x200/f5f5f5/999?text=No+Image' }}" 
                                     alt="{{ $product->name }}" class="product-image">
                                @if($product->stock <= 5 && $product->stock > 0)
                                    <span class="product-badge">Stok Terbatas</span>
                                @endif
                            </a>
                            <div class="product-info">
                                <a href="{{ route('shop.show', $product) }}" class="product-name">{{ $product->name }}</a>
                                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <div class="product-store">
                                    🏪 {{ $product->pedagang->store_name ?? $product->pedagang->name }}
                                </div>
                                <span class="product-stock {{ $product->stock <= 5 ? 'low' : '' }}">
                                    Stok: {{ $product->stock }}
                                </span>
                            </div>
                            <div class="product-actions">
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="ajax-cart-form">
                                    @csrf
                                    <button type="submit" class="add-cart-btn">🛒 + Keranjang</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="pagination-wrapper">
                    {{ $products->links() }}
                </div>
            @else
                <div class="no-products">
                    <div class="no-products-icon">📦</div>
                    <h3 class="no-products-title">Tidak Ada Produk</h3>
                    <p class="no-products-text">Belum ada produk dalam kategori ini</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.ajax-cart-form');
    
    // SweetAlert2 Toast
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = form.querySelector('.add-cart-btn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳ Menambahkan...';
            btn.disabled = true;
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(form)
            })
            .then(() => {
                btn.innerHTML = '✓ Ditambahkan!';
                btn.style.background = 'linear-gradient(135deg, #059669, #10b981)';
                Toast.fire({ icon: 'success', title: 'Berhasil ditambahkan ke keranjang!' });
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.background = '';
                    btn.disabled = false;
                }, 1500);
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerHTML = originalText;
                btn.disabled = false;
                Toast.fire({ icon: 'error', title: 'Gagal menambahkan ke keranjang' });
            });
        });
    });
});
</script>
@endsection


