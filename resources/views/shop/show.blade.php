@extends('layouts.app')

@section('title', $product->name)

@section('styles')
<style>
    .product-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fffe 0%, #f0f9f6 100%);
        padding: 2rem 0;
    }
    
    /* Breadcrumb */
    .breadcrumb {
        display: flex;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: #888;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    
    .breadcrumb a {
        color: #11998e;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }
    
    .breadcrumb a:hover {
        color: #0d7d73;
    }
    
    /* Product Detail Card */
    .product-detail {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2.5rem;
        background: white;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    }
    
    /* Image Section */
    .product-image-section {
        position: relative;
    }
    
    .product-image-main {
        width: 100%;
        border-radius: 20px;
        background: #f5f5f5;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }
    
    .image-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: linear-gradient(135deg, #ff6b35, #f7931e);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    /* Info Section */
    .product-info-section {
        display: flex;
        flex-direction: column;
    }
    
    .product-category {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        color: #166534;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1rem;
        width: fit-content;
    }
    
    .product-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }
    
    .product-store {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: #888;
        margin-bottom: 1.25rem;
    }
    
    .product-price-big {
        font-size: 2rem;
        font-weight: 800;
        color: #11998e;
        margin-bottom: 1.25rem;
    }
    
    .product-description {
        color: #666;
        line-height: 1.7;
        margin-bottom: 1.5rem;
        padding: 1rem 1.25rem;
        background: #f8f9fa;
        border-radius: 12px;
        border-left: 4px solid #11998e;
    }
    
    /* Stock Info */
    .stock-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        border-radius: 14px;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }
    
    .stock-info.in-stock {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        color: #166534;
    }
    
    .stock-info.low-stock {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }
    
    .stock-info.out-stock {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        color: #dc2626;
    }
    
    .stock-icon {
        font-size: 1.5rem;
    }
    
    /* Quantity Selector */
    .quantity-section {
        background: #f8f9fa;
        padding: 1.25rem;
        border-radius: 14px;
        margin-bottom: 1.25rem;
    }
    
    .quantity-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.75rem;
        display: block;
    }
    
    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .qty-btn {
        width: 40px;
        height: 40px;
        border: 2px solid #e0e0e0;
        background: white;
        border-radius: 10px;
        font-size: 1.25rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        color: #666;
    }
    
    .qty-btn:hover {
        border-color: #11998e;
        color: #11998e;
    }
    
    .quantity-input {
        width: 80px;
        padding: 0.75rem;
        text-align: center;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 700;
    }
    
    .quantity-input:focus {
        outline: none;
        border-color: #11998e;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
    }
    
    .btn-add-cart {
        flex: 2;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
        border: none;
        border-radius: 14px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .btn-add-cart:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
    }
    
    .btn-back {
        flex: 1;
        padding: 1rem 1.5rem;
        background: white;
        color: #666;
        border: 2px solid #e0e0e0;
        border-radius: 14px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s;
    }
    
    .btn-back:hover {
        border-color: #11998e;
        color: #11998e;
    }
    
    /* Related Products */
    .related-section {
        margin-top: 3rem;
    }
    
    .related-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a2e;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .related-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1.25rem;
    }
    
    .related-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        text-decoration: none;
        transition: all 0.3s;
        border: 2px solid transparent;
    }
    
    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        border-color: #11998e;
    }
    
    .related-card img {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
    }
    
    .related-card-info {
        padding: 1rem;
    }
    
    .related-card-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 0.35rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .related-card-price {
        font-size: 1rem;
        font-weight: 700;
        color: #11998e;
    }
    
    @media (max-width: 992px) {
        .related-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .product-detail {
            grid-template-columns: 1fr;
        }
        
        .related-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    /* Product Stats */
    .product-stats {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    
    .stat-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.5rem 0.85rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .stat-badge.sold {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }
    
    .stat-badge.rating {
        background: linear-gradient(135deg, #fef9c3, #fef08a);
        color: #854d0e;
    }
    
    .stat-badge .stars {
        color: #f59e0b;
    }
    
    /* Reviews Section */
    .reviews-section {
        margin-top: 3rem;
        background: white;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    }
    
    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .reviews-summary {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .rating-big {
        text-align: center;
    }
    
    .rating-number {
        font-size: 3rem;
        font-weight: 800;
        color: #1a1a2e;
        line-height: 1;
    }
    
    .rating-stars {
        font-size: 1.25rem;
        color: #f59e0b;
        margin-top: 0.25rem;
    }
    
    .rating-count {
        font-size: 0.85rem;
        color: #888;
        margin-top: 0.25rem;
    }
    
    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }
    
    .review-card {
        background: #f8f9fa;
        border-radius: 16px;
        padding: 1.25rem;
        transition: all 0.3s;
    }
    
    .review-card:hover {
        background: #f0f9f6;
    }
    
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    
    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .reviewer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
    }
    
    .reviewer-name {
        font-weight: 600;
        color: #1a1a2e;
    }
    
    .review-date {
        font-size: 0.8rem;
        color: #888;
    }
    
    .review-rating {
        color: #f59e0b;
        font-size: 1rem;
    }
    
    .review-content {
        color: #555;
        line-height: 1.6;
    }
    
    .no-reviews {
        text-align: center;
        padding: 3rem;
        color: #888;
    }
    
    .no-reviews-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="product-page">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success" style="margin-bottom: 1.5rem;">{{ session('success') }}</div>
        @endif
        
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('home') }}">🏠 Beranda</a>
            <span>/</span>
            <a href="{{ route('shop.index') }}">🛒 Belanja</a>
            <span>/</span>
            <a href="{{ route('shop.index', ['category' => $product->category]) }}">{{ $product->category }}</a>
            <span>/</span>
            <span>{{ Str::limit($product->name, 30) }}</span>
        </div>
        
        <!-- Product Detail -->
        <div class="product-detail">
            <!-- Image -->
            <div class="product-image-section">
                <img src="{{ $product->image ?? 'https://via.placeholder.com/500x500/f5f5f5/999?text=No+Image' }}" 
                     alt="{{ $product->name }}" 
                     class="product-image-main">
                @if($product->stock <= 5 && $product->stock > 0)
                    <span class="image-badge">⚡ Stok Terbatas</span>
                @endif
            </div>
            
            <!-- Info -->
            <div class="product-info-section">
                <span class="product-category">🏷️ {{ $product->category }}</span>
                <h1 class="product-title">{{ $product->name }}</h1>
                
                <div class="product-store">
                    🏪 {{ $product->pedagang->store_name ?? $product->pedagang->name }}
                </div>
                
                <!-- Product Stats -->
                <div class="product-stats">
                    <span class="stat-badge sold">
                        📦 {{ $soldCount }} terjual
                    </span>
                    @if($reviewCount > 0)
                    <span class="stat-badge rating">
                        <span class="stars">⭐</span> {{ number_format($avgRating, 1) }} ({{ $reviewCount }} ulasan)
                    </span>
                    @endif
                </div>
                
                <div class="product-price-big">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                
                @if($product->description)
                <p class="product-description">{{ $product->description }}</p>
                @endif
                
                <!-- Stock Info -->
                @if($product->stock > 5)
                    <div class="stock-info in-stock">
                        <span class="stock-icon">✅</span>
                        <span>Stok tersedia ({{ $product->stock }} unit)</span>
                    </div>
                @elseif($product->stock > 0)
                    <div class="stock-info low-stock">
                        <span class="stock-icon">⚠️</span>
                        <span>Stok hampir habis! ({{ $product->stock }} tersisa)</span>
                    </div>
                @else
                    <div class="stock-info out-stock">
                        <span class="stock-icon">❌</span>
                        <span>Stok habis</span>
                    </div>
                @endif
                
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST" id="addToCartForm">
                        @csrf
                        <!-- Quantity -->
                        <div class="quantity-section">
                            <label class="quantity-label">Jumlah Pembelian</label>
                            <div class="quantity-selector">
                                <button type="button" class="qty-btn" onclick="decreaseQty()">−</button>
                                <input type="number" name="quantity" id="quantityInput" value="1" min="1" max="{{ $product->stock }}" class="quantity-input">
                                <button type="button" class="qty-btn" onclick="increaseQty({{ $product->stock }})">+</button>
                                <span style="margin-left: 0.5rem; color: #888; font-size: 0.85rem;">Maks. {{ $product->stock }}</span>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button type="submit" class="btn-add-cart" id="addToCartBtn">🛒 Tambah ke Keranjang</button>
                            <a href="{{ route('shop.index') }}" class="btn-back">← Kembali</a>
                        </div>
                    </form>
                @else
                    <a href="{{ route('shop.index') }}" class="btn-back" style="width: 100%; display: block;">← Kembali Belanja</a>
                @endif
            </div>
        </div>
        
        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="related-section">
                <div class="related-header">
                    <h2 class="section-title">🛍️ Produk Terkait</h2>
                </div>
                <div class="related-grid">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('shop.show', $related) }}" class="related-card">
                            <img src="{{ $related->image ?? 'https://via.placeholder.com/150x150/f5f5f5/999' }}" alt="{{ $related->name }}">
                            <div class="related-card-info">
                                <div class="related-card-name">{{ Str::limit($related->name, 30) }}</div>
                                <div class="related-card-price">Rp {{ number_format($related->price, 0, ',', '.') }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Reviews Section -->
        <div class="reviews-section">
            <div class="reviews-header">
                <h2 class="section-title">⭐ Ulasan Pembeli</h2>
                <div class="reviews-summary">
                    <div class="rating-big">
                        <div class="rating-number">{{ number_format($avgRating, 1) }}</div>
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($avgRating))
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </div>
                        <div class="rating-count">{{ $reviewCount }} ulasan</div>
                    </div>
                </div>
            </div>
            
            @if($product->reviews->count() > 0)
                <div class="reviews-list">
                    @foreach($product->reviews->take(5) as $review)
                        <div class="review-card">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <div class="reviewer-avatar">
                                        {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="reviewer-name">{{ $review->user->name ?? 'Anonim' }}</div>
                                        <div class="review-date">{{ $review->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            @if($review->comment)
                                <p class="review-content">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-reviews">
                    <div class="no-reviews-icon">📝</div>
                    <p>Belum ada ulasan untuk produk ini</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function decreaseQty() {
    const input = document.getElementById('quantityInput');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function increaseQty(max) {
    const input = document.getElementById('quantityInput');
    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
    }
}

// AJAX Add to Cart
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('addToCartForm');
    const btn = document.getElementById('addToCartBtn');
    
    // SweetAlert2 Toast
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳ Menambahkan...';
            btn.disabled = true;
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            })
            .then(() => {
                btn.innerHTML = '✓ Ditambahkan ke Keranjang!';
                btn.style.background = 'linear-gradient(135deg, #059669, #10b981)';
                Toast.fire({ icon: 'success', title: 'Berhasil ditambahkan ke keranjang!' });
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.background = '';
                    btn.disabled = false;
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerHTML = originalText;
                btn.disabled = false;
                Toast.fire({ icon: 'error', title: 'Gagal menambahkan' });
            });
        });
    }
});
</script>
@endsection


