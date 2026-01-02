@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('styles')
<style>
    .success-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fffe 0%, #f0f9f6 100%);
        padding: 2rem 0;
    }
    
    /* Progress Steps */
    .checkout-steps {
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
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
    }
    
    .step-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #11998e;
    }
    
    .step-connector {
        width: 60px;
        height: 2px;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        margin-top: -10px;
    }
    
    .success-container {
        max-width: 650px;
        margin: 0 auto;
    }
    
    .success-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        padding: 2.5rem;
        text-align: center;
    }
    
    .success-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 4rem;
        animation: scaleIn 0.5s ease-out;
    }
    
    @keyframes scaleIn {
        0% { transform: scale(0); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    .success-title {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.5rem;
    }
    
    .success-message {
        color: #888;
        font-size: 1rem;
        margin-bottom: 2rem;
    }
    
    .order-box {
        background: #f8f9fa;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        text-align: left;
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .order-number {
        font-weight: 800;
        font-size: 1.1rem;
        color: #1a1a2e;
    }
    
    .order-badge {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
        padding: 0.35rem 0.875rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 0.625rem 0;
        font-size: 0.9rem;
        color: #666;
    }
    
    .order-item span:last-child {
        font-weight: 600;
        color: #1a1a2e;
    }
    
    .order-total {
        display: flex;
        justify-content: space-between;
        padding-top: 1rem;
        margin-top: 0.75rem;
        border-top: 2px solid #e0e0e0;
        font-size: 1.1rem;
    }
    
    .order-total span:first-child {
        font-weight: 700;
        color: #1a1a2e;
    }
    
    .order-total .amount {
        font-size: 1.25rem;
        font-weight: 800;
        color: #11998e;
    }
    
    .delivery-info {
        text-align: left;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 14px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    .delivery-title {
        font-weight: 700;
        color: #166534;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .delivery-address {
        color: #166534;
        font-size: 0.95rem;
        line-height: 1.6;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
    }
    
    .btn-history {
        flex: 1;
        padding: 1rem 1.5rem;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 14px;
        color: #666;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s;
    }
    
    .btn-history:hover {
        border-color: #11998e;
        color: #11998e;
    }
    
    .btn-shop {
        flex: 1;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        border: none;
        border-radius: 14px;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s;
    }
    
    .btn-shop:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
    }
    
    @media (max-width: 768px) {
        .checkout-steps {
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="success-page">
    <div class="container">
        <!-- Progress Steps - All Completed -->
        <div class="checkout-steps">
            <div class="step">
                <div class="step-number">✓</div>
                <span class="step-label">Keranjang</span>
            </div>
            <div class="step-connector"></div>
            <div class="step">
                <div class="step-number">✓</div>
                <span class="step-label">Checkout</span>
            </div>
            <div class="step-connector"></div>
            <div class="step">
                <div class="step-number">✓</div>
                <span class="step-label">Pembayaran</span>
            </div>
            <div class="step-connector"></div>
            <div class="step">
                <div class="step-number">✓</div>
                <span class="step-label">Selesai</span>
            </div>
        </div>
        
        <div class="success-container">
            <div class="success-card">
                <div class="success-icon">🎉</div>
                
                <h1 class="success-title">Pesanan Berhasil!</h1>
                <p class="success-message">Terima kasih telah berbelanja di Peukan Rumoh</p>
                
                <div class="order-box">
                    <div class="order-header">
                        <span class="order-number">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                        <span class="order-badge">{{ ucfirst($order->status) }}</span>
                    </div>
                    
                    @foreach($order->items as $item)
                        <div class="order-item">
                            <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                            <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                    
                    <div class="order-total">
                        <span>Total Pembayaran</span>
                        <span class="amount">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="delivery-info">
                    <div class="delivery-title">📦 Alamat Pengiriman</div>
                    <div class="delivery-address">
                        {{ $order->shipping_address }}<br>
                        📞 {{ $order->phone }}
                    </div>
                </div>
                
                <div class="action-buttons">
                    <a href="{{ route('pembeli.orders.index') }}" class="btn-history">📋 Lihat Pesanan</a>
                    <a href="{{ route('shop.index') }}" class="btn-shop">🛍️ Belanja Lagi</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
