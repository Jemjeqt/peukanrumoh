@extends('layouts.app')

@section('title', 'Keranjang')

@section('styles')
<style>
    .cart-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fffe 0%, #f0f9f6 100%);
        padding: 2rem 0;
    }
    
    .cart-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .cart-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
    }
    
    .cart-subtitle {
        color: #888;
        font-size: 0.95rem;
    }
    
    /* Progress Steps */
    .cart-steps {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 2.5rem;
    }
    
    .step {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .step-number {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
    }
    
    .step.active .step-number {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
    }
    
    .step.pending .step-number {
        background: #e0e0e0;
        color: #888;
    }
    
    .step-label {
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .step.active .step-label { color: #11998e; }
    .step.pending .step-label { color: #888; }
    
    .step-connector {
        width: 60px;
        height: 2px;
        background: #e0e0e0;
        margin-top: -10px;
    }
    
    .cart-container {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2rem;
        align-items: start;
    }
    
    /* Cart Items Card */
    .cart-items-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .items-header {
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .items-title {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .items-count {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    /* Cart Item */
    .cart-item {
        display: grid;
        grid-template-columns: 90px 1fr auto;
        gap: 1.25rem;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        align-items: center;
    }
    
    .cart-item:last-child {
        border-bottom: none;
    }
    
    .cart-item-image {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .cart-item-info {
        min-width: 0;
    }
    
    .cart-item-name {
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 0.35rem;
        font-size: 1rem;
    }
    
    .cart-item-price {
        color: #888;
        font-size: 0.85rem;
        margin-bottom: 0.75rem;
    }
    
    .cart-item-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .qty-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f8f9fa;
        padding: 0.375rem;
        border-radius: 10px;
    }
    
    .qty-input {
        width: 50px;
        padding: 0.5rem;
        text-align: center;
        border: none;
        background: white;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
    }
    
    .btn-qty-update {
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        border: none;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-qty-update:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(17, 153, 142, 0.3);
    }
    
    .btn-remove {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #fef2f2;
        border: none;
        color: #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-remove:hover {
        background: #fee2e2;
        transform: scale(1.1);
    }
    
    .cart-item-subtotal {
        text-align: right;
    }
    
    .subtotal-label {
        font-size: 0.75rem;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .subtotal-amount {
        font-size: 1.1rem;
        font-weight: 700;
        color: #11998e;
    }
    
    /* Cart Summary */
    .cart-summary {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        position: sticky;
        top: 100px;
    }
    
    .summary-header {
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
    }
    
    .summary-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
    }
    
    .summary-body {
        padding: 1.5rem;
    }
    
    .summary-line {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        font-size: 0.9rem;
    }
    
    .summary-line.subtle {
        color: #888;
    }
    
    .summary-divider {
        height: 1px;
        background: linear-gradient(to right, transparent, #e0e0e0, transparent);
        margin: 0.75rem 0;
    }
    
    .summary-total {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0 0;
        font-size: 1.25rem;
        font-weight: 700;
    }
    
    .summary-total .amount {
        color: #11998e;
    }
    
    .btn-checkout {
        width: 100%;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        border: none;
        border-radius: 14px;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        text-decoration: none;
        margin-top: 1rem;
    }
    
    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
    }
    
    .btn-continue {
        width: 100%;
        padding: 0.875rem 1.5rem;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        color: #666;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        margin-top: 0.75rem;
    }
    
    .btn-continue:hover {
        border-color: #11998e;
        color: #11998e;
    }
    
    /* Security Badge */
    .security-badge {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 12px;
        margin-top: 1rem;
    }
    
    .security-icon {
        font-size: 1.5rem;
    }
    
    .security-text {
        font-size: 0.8rem;
        color: #166534;
        line-height: 1.4;
    }
    
    /* Empty Cart */
    .empty-cart {
        background: white;
        border-radius: 20px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    }
    
    .empty-icon {
        font-size: 5rem;
        margin-bottom: 1.5rem;
    }
    
    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
    }
    
    .empty-text {
        color: #888;
        margin-bottom: 1.5rem;
    }
    
    .btn-shop {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        border: none;
        border-radius: 14px;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-shop:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
    }
    
    @media (max-width: 992px) {
        .cart-container {
            grid-template-columns: 1fr;
        }
        
        .cart-summary {
            position: static;
        }
        
        .cart-steps {
            flex-wrap: wrap;
            gap: 1rem;
        }
    }
    
    @media (max-width: 768px) {
        .cart-item {
            grid-template-columns: 70px 1fr;
        }
        
        .cart-item-subtotal {
            grid-column: 2;
            text-align: left;
            margin-top: 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="cart-page">
    <div class="container">
        <!-- Header -->
        <div class="cart-header">
            <h1 class="cart-title">🛒 Keranjang Belanja</h1>
            <p class="cart-subtitle">Review produk sebelum melanjutkan ke checkout</p>
        </div>
        
        <!-- Progress Steps -->
        <div class="cart-steps">
            <div class="step active">
                <div class="step-number">1</div>
                <span class="step-label">Keranjang</span>
            </div>
            <div class="step-connector"></div>
            <div class="step pending">
                <div class="step-number">2</div>
                <span class="step-label">Checkout</span>
            </div>
            <div class="step-connector"></div>
            <div class="step pending">
                <div class="step-number">3</div>
                <span class="step-label">Pembayaran</span>
            </div>
            <div class="step-connector"></div>
            <div class="step pending">
                <div class="step-number">4</div>
                <span class="step-label">Selesai</span>
            </div>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success" style="margin-bottom: 1.5rem;">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error" style="margin-bottom: 1.5rem;">{{ session('error') }}</div>
        @endif
        
        @if($cartItems->count() > 0)
            <div class="cart-container">
                <!-- Cart Items -->
                <div class="cart-items-card">
                    <div class="items-header">
                        <h3 class="items-title"><span>📦</span> Produk</h3>
                        <span class="items-count">{{ $cartItems->count() }} item</span>
                    </div>
                    
                    @foreach($cartItems as $item)
                        <div class="cart-item">
                            <img src="{{ $item->product->image ?? 'https://via.placeholder.com/90x90/f5f5f5/999' }}" 
                                 alt="{{ $item->product->name }}" class="cart-item-image">
                            
                            <div class="cart-item-info">
                                <div class="cart-item-name">{{ $item->product->name }}</div>
                                <div class="cart-item-price">Rp {{ number_format($item->product->price, 0, ',', '.') }} / unit</div>
                                
                                <div class="cart-item-actions">
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="qty-control ajax-cart-form" data-item-id="{{ $item->id }}" data-price="{{ $item->product->price }}">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                               min="1" max="{{ $item->product->stock }}" class="qty-input">
                                        <button type="submit" class="btn-qty-update">Update</button>
                                    </form>
                                    
                                    <form action="{{ route('cart.remove', $item) }}" method="POST" class="ajax-remove-form">
                                        @csrf
                                        <button type="submit" class="btn-remove" title="Hapus">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="cart-item-subtotal" data-item-id="{{ $item->id }}">
                                <div class="subtotal-label">Subtotal</div>
                                <div class="subtotal-amount">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Cart Summary -->
                <div class="cart-summary">
                    <div class="summary-header">
                        <h3 class="summary-title">📋 Ringkasan Belanja</h3>
                    </div>
                    <div class="summary-body">
                        <div class="summary-line">
                            <span>Subtotal (<span id="total-items">{{ $cartItems->sum('quantity') }}</span> item)</span>
                            <span id="summary-subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-line subtle">
                            <span>Biaya Admin</span>
                            <span>Rp {{ number_format(\App\Models\Order::ADMIN_FEE, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-line subtle">
                            <span>🚚 Ongkos Kirim</span>
                            <span>Rp {{ number_format(\App\Models\Order::SHIPPING_COST, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="summary-divider"></div>
                        
                        <div class="summary-total">
                            <span>Total</span>
                            <span class="amount" id="summary-total">Rp {{ number_format($total + \App\Models\Order::ADMIN_FEE + \App\Models\Order::SHIPPING_COST, 0, ',', '.') }}</span>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" class="btn-checkout">
                            🛍️ Lanjut ke Checkout
                        </a>
                        
                        <a href="{{ route('shop.index') }}" class="btn-continue">
                            ← Lanjut Belanja
                        </a>
                        
                        <div class="security-badge">
                            <span class="security-icon">🔒</span>
                            <span class="security-text">Checkout aman & terlindungi</span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-icon">🛒</div>
                <h3 class="empty-title">Keranjang Masih Kosong</h3>
                <p class="empty-text">Belum ada produk di keranjang Anda. Yuk mulai belanja!</p>
                <a href="{{ route('shop.index') }}" class="btn-shop">
                    🛍️ Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const adminFee = {{ \App\Models\Order::ADMIN_FEE }};
    const shippingCost = {{ \App\Models\Order::SHIPPING_COST }};
    
    // SweetAlert2 Toast
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });
    
    // Update quantity forms
    document.querySelectorAll('.ajax-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = form.querySelector('.btn-qty-update');
            const originalText = btn.innerHTML;
            btn.innerHTML = '...';
            btn.disabled = true;
            
            fetch(form.action, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            })
            .then(() => {
                // Update subtotal display
                const itemId = form.dataset.itemId;
                const price = parseFloat(form.dataset.price);
                const qty = parseInt(form.querySelector('.qty-input').value);
                const subtotal = price * qty;
                
                const subtotalEl = document.querySelector(`.cart-item-subtotal[data-item-id="${itemId}"] .subtotal-amount`);
                if (subtotalEl) {
                    subtotalEl.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                }
                
                updateTotals();
                Toast.fire({ icon: 'success', title: 'Jumlah berhasil diupdate!' });
                
                btn.innerHTML = '✓';
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 1000);
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerHTML = originalText;
                btn.disabled = false;
                Toast.fire({ icon: 'error', title: 'Gagal update' });
            });
        });
    });
    
    // Remove item forms
    document.querySelectorAll('.ajax-remove-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Hapus Item?',
                text: 'Item ini akan dihapus dari keranjang',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const cartItem = form.closest('.cart-item');
                    
                    fetch(form.action, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: new FormData(form)
                    })
                    .then(() => {
                        cartItem.style.transition = 'all 0.3s ease';
                        cartItem.style.opacity = '0';
                        cartItem.style.transform = 'translateX(-20px)';
                        
                        setTimeout(() => {
                            cartItem.remove();
                            updateTotals();
                            
                            if (document.querySelectorAll('.cart-item').length === 0) {
                                location.reload();
                            }
                        }, 300);
                        
                        Toast.fire({ icon: 'success', title: 'Item dihapus dari keranjang' });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Toast.fire({ icon: 'error', title: 'Gagal menghapus' });
                    });
                }
            });
        });
    });
    
    function updateTotals() {
        let subtotal = 0;
        let totalItems = 0;
        
        document.querySelectorAll('.ajax-cart-form').forEach(form => {
            const price = parseFloat(form.dataset.price);
            const qty = parseInt(form.querySelector('.qty-input').value);
            subtotal += price * qty;
            totalItems += qty;
        });
        
        const total = subtotal + adminFee + shippingCost;
        
        document.getElementById('total-items').textContent = totalItems;
        document.getElementById('summary-subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('summary-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
    

});
</script>
@endsection

