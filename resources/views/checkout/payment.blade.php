@extends('layouts.app')

@section('title', 'Pembayaran')

@section('styles')
<style>
    .payment-page {
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
        background: linear-gradient(135deg, #11998e, #38ef7d);
        margin-top: -10px;
    }
    
    .step-connector.pending {
        background: #e0e0e0;
    }
    
    .payment-container {
        max-width: 550px;
        margin: 0 auto;
    }
    
    .payment-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        padding: 2.5rem;
        text-align: center;
    }
    
    .payment-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 3rem;
    }
    
    .payment-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
    }
    
    .order-id {
        color: #888;
        font-size: 1rem;
        margin-bottom: 2rem;
    }
    
    .order-id span {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 700;
    }
    
    .order-details {
        background: #f8f9fa;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        text-align: left;
    }
    
    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #eee;
        font-size: 0.95rem;
    }
    
    .detail-row:last-child {
        border-bottom: none;
        padding-top: 1rem;
        margin-top: 0.5rem;
        border-top: 2px solid #e0e0e0;
        font-size: 1.1rem;
    }
    
    .detail-row .label {
        color: #666;
    }
    
    .detail-row .value {
        font-weight: 600;
        color: #1a1a2e;
    }
    
    .detail-row:last-child .value {
        font-size: 1.25rem;
        font-weight: 800;
        color: #11998e;
    }
    
    .demo-notice {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-radius: 14px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        color: #92400e;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        text-align: left;
    }
    
    .demo-icon {
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .btn-confirm {
        width: 100%;
        padding: 1.125rem 2rem;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        border: none;
        border-radius: 14px;
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
    }
    
    @media (max-width: 768px) {
        .checkout-steps {
            flex-wrap: wrap;
            gap: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="payment-page">
    <div class="container">
        <!-- Progress Steps -->
        <div class="checkout-steps">
            <div class="step active">
                <div class="step-number">✓</div>
                <span class="step-label">Keranjang</span>
            </div>
            <div class="step-connector"></div>
            <div class="step active">
                <div class="step-number">✓</div>
                <span class="step-label">Checkout</span>
            </div>
            <div class="step-connector"></div>
            <div class="step active">
                <div class="step-number">3</div>
                <span class="step-label">Pembayaran</span>
            </div>
            <div class="step-connector pending"></div>
            <div class="step pending">
                <div class="step-number">4</div>
                <span class="step-label">Selesai</span>
            </div>
        </div>
        
        <div class="payment-container">
            <div class="payment-card">
                <div class="payment-icon">💳</div>
                
                <h1 class="payment-title">Pembayaran</h1>
                <p class="order-id">Order <span>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span></p>
                
                <div class="order-details">
                    <div class="detail-row">
                        <span class="label">Metode Pembayaran</span>
                        <span class="value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Jumlah Produk</span>
                        <span class="value">{{ $order->items->count() }} item</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Total Bayar</span>
                        <span class="value">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="demo-notice">
                    <span class="demo-icon">⚠️</span>
                    <div>
                        <strong>Mode Demo</strong><br>
                        Ini adalah simulasi pembayaran. Klik tombol di bawah untuk konfirmasi.
                    </div>
                </div>
                
                <form action="{{ route('checkout.confirm') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-confirm">
                        ✅ Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
