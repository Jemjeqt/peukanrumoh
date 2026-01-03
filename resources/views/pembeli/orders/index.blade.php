@extends('layouts.main')

@section('title', 'Riwayat Pesanan')

@section('styles')
<style>
    .orders-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fffe 0%, #f0f9f6 100%);
        padding: 2rem 0;
    }
    
    .orders-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .orders-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
    }
    
    .orders-subtitle {
        color: #888;
        font-size: 0.95rem;
    }
    
    .orders-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    /* Order Item Card */
    .order-item-card {
        padding: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.3s;
    }
    
    .order-item-card:last-child {
        border-bottom: none;
    }
    
    .order-item-card:hover {
        background: #fafffe;
    }
    
    .order-row {
        display: grid;
        grid-template-columns: 120px 1fr 140px 100px auto;
        gap: 1.5rem;
        align-items: center;
    }
    
    /* Order ID */
    .order-id {
        font-weight: 800;
        font-size: 1rem;
        color: #11998e;
    }
    
    /* Products */
    .order-products {
        min-width: 0;
    }
    
    .product-line {
        font-size: 0.9rem;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 0.2rem;
    }
    
    .product-more {
        font-size: 0.8rem;
        color: #888;
    }
    
    /* Total */
    .order-total {
        font-weight: 700;
        font-size: 1.1rem;
        color: #11998e;
    }
    
    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.5rem 0.875rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .status-badge.pending { background: #fef3c7; color: #92400e; }
    .status-badge.paid { background: #dbeafe; color: #1e40af; }
    .status-badge.processing { background: #e0e7ff; color: #3730a3; }
    .status-badge.shipped { background: #cffafe; color: #0e7490; }
    .status-badge.delivered { background: #d1fae5; color: #065f46; }
    .status-badge.completed { background: linear-gradient(135deg, #f0fdf4, #dcfce7); color: #166534; }
    .status-badge.return { background: #fef3c7; color: #92400e; }
    
    .kurir-info {
        font-size: 0.75rem;
        color: #888;
        margin-top: 0.35rem;
    }
    
    /* Actions */
    .order-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    
    .btn-confirm {
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(17, 153, 142, 0.3);
    }
    
    .btn-detail {
        padding: 0.5rem 1rem;
        background: #f8f9fa;
        color: #666;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .btn-detail:hover {
        background: #e9ecef;
        color: #333;
    }
    
    .btn-pay {
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-pay:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        color: white;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
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
        color: white;
        border: none;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .btn-shop:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
    }
    
    /* Pagination */
    .pagination-wrapper {
        padding: 1.5rem;
        border-top: 1px solid #f0f0f0;
    }
    
    @media (max-width: 992px) {
        .order-row {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        
        .order-actions {
            justify-content: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="orders-page">
    <div class="container">
        <!-- Header -->
        <div class="orders-header">
            <h1 class="orders-title">📦 Riwayat Pesanan</h1>
            <p class="orders-subtitle">Lacak dan kelola semua pesanan Anda</p>
        </div>
        
        <div class="orders-card">
            @if($orders->count() > 0)
                @foreach($orders as $order)
                    <div class="order-item-card">
                        <div class="order-row">
                            <!-- Order ID -->
                            <div class="order-id">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                            
                            <!-- Products -->
                            <div class="order-products">
                                @foreach($order->items->take(2) as $item)
                                    <div class="product-line">{{ Str::limit($item->product_name, 30) }} ×{{ $item->quantity }}</div>
                                @endforeach
                                @if($order->items->count() > 2)
                                    <div class="product-more">+{{ $order->items->count() - 2 }} produk lainnya</div>
                                @endif
                            </div>
                            
                            <!-- Total -->
                            <div class="order-total">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                            
                            <!-- Status -->
                            <div>
                                @php
                                    $orderReturn = $returns[$order->id] ?? null;
                                @endphp
                                @if($orderReturn && $orderReturn->status !== 'completed' && $orderReturn->status !== 'rejected')
                                    <span class="status-badge return">🔄 {{ $orderReturn->status_label }}</span>
                                @else
                                    <span class="status-badge {{ $order->status }}">{{ $order->status_label }}</span>
                                @endif
                                @if($order->kurir && in_array($order->status, ['shipped', 'completed']))
                                    <div class="kurir-info">🚚 {{ $order->kurir->name }}</div>
                                @endif
                            </div>
                            
                            <!-- Actions -->
                            <div class="order-actions">
                                @if($order->status === 'pending')
                                    <a href="{{ route('checkout.pay-order', $order) }}" class="btn-pay">💳 Bayar</a>
                                @endif
                                @if($order->status === 'delivered')
                                    <form action="{{ route('pembeli.orders.confirm-delivery', $order) }}" method="POST" class="ajax-confirm-form">
                                        @csrf
                                        <button type="submit" class="btn-confirm ajax-btn">✅ Konfirmasi</button>
                                    </form>
                                @endif
                                <a href="{{ route('pembeli.orders.show', $order) }}" class="btn-detail">Lihat Detail →</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <div class="pagination-wrapper">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">📦</div>
                    <h3 class="empty-title">Belum Ada Pesanan</h3>
                    <p class="empty-text">Mulai belanja dan pesanan Anda akan muncul di sini</p>
                    <a href="{{ route('shop.index') }}" class="btn-shop">🛒 Mulai Belanja</a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" style="position: fixed; bottom: 20px; right: 20px; background: linear-gradient(135deg, #11998e, #38ef7d); color: white; padding: 1rem 1.5rem; border-radius: 12px; font-weight: 600; box-shadow: 0 8px 30px rgba(0,0,0,0.2); z-index: 9999; transform: translateY(100px); opacity: 0; transition: all 0.3s ease;">
    <span id="toast-message">Berhasil!</span>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');
    
    document.querySelectorAll('.ajax-confirm-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = form.querySelector('.ajax-btn');
            const card = form.closest('.order-item-card');
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳';
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
                card.style.transition = 'all 0.3s ease';
                card.style.background = '#d1fae5';
                
                const badge = card.querySelector('.status-badge');
                if (badge) {
                    badge.innerHTML = '✅ Selesai';
                    badge.className = 'status-badge completed';
                }
                
                // Update order badge in navbar
                const orderBadge = document.getElementById('order-badge');
                if (orderBadge) {
                    let count = parseInt(orderBadge.textContent) || 0;
                    count = Math.max(0, count - 1);
                    orderBadge.textContent = count;
                    if (count === 0) {
                        orderBadge.style.display = 'none';
                    }
                }
                
                form.remove();
                
                // Use SweetAlert2 Toast
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Pesanan dikonfirmasi! Terima kasih 🎉',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    });
                } else {
                    showToast('Pesanan dikonfirmasi! Terima kasih 🎉');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerHTML = originalText;
                btn.disabled = false;
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Gagal konfirmasi',
                        showConfirmButton: false,
                        timer: 2500
                    });
                } else {
                    showToast('Gagal konfirmasi', true);
                }
            });
        });
    });
    
    function showToast(message, isError = false) {
        toastMessage.textContent = message;
        toast.style.background = isError 
            ? 'linear-gradient(135deg, #dc2626, #ef4444)' 
            : 'linear-gradient(135deg, #11998e, #38ef7d)';
        toast.style.transform = 'translateY(0)';
        toast.style.opacity = '1';
        
        setTimeout(() => {
            toast.style.transform = 'translateY(100px)';
            toast.style.opacity = '0';
        }, 2500);
    }
});
</script>
@endsection


