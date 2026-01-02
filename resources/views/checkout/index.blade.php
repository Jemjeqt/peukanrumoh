@extends('layouts.app')

@section('title', 'Checkout')

@section('styles')
<style>
    .checkout-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fffe 0%, #f0f9f6 100%);
        padding: 2rem 0;
    }
    
    .checkout-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .checkout-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
    }
    
    .checkout-subtitle {
        color: #888;
        font-size: 0.95rem;
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
        background: #e0e0e0;
        margin-top: -10px;
    }
    
    .checkout-container {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
        align-items: start;
    }
    
    /* Cards */
    .checkout-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .card-header {
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-bottom: 1px solid #e2e8f0;
    }
    
    .card-title {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #1a1a2e;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    /* Form Styles */
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .form-label .required {
        color: #f5576c;
    }
    
    .form-input-premium {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #fafafa;
    }
    
    .form-input-premium:focus {
        outline: none;
        border-color: #11998e;
        background: white;
        box-shadow: 0 0 0 4px rgba(17, 153, 142, 0.1);
    }
    
    .form-textarea-premium {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #fafafa;
        resize: vertical;
    }
    
    .form-textarea-premium:focus {
        outline: none;
        border-color: #11998e;
        background: white;
        box-shadow: 0 0 0 4px rgba(17, 153, 142, 0.1);
    }
    
    /* Payment Options */
    .payment-options {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .payment-option {
        position: relative;
    }
    
    .payment-option input {
        position: absolute;
        opacity: 0;
    }
    
    .payment-option label {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        border: 2px solid #e0e0e0;
        border-radius: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }
    
    .payment-option label:hover {
        border-color: #11998e;
        background: #f0fdf4;
    }
    
    .payment-option input:checked + label {
        border-color: #11998e;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.15);
    }
    
    .payment-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    }
    
    .payment-option input:checked + label .payment-icon {
        background: linear-gradient(135deg, #11998e, #38ef7d);
    }
    
    .payment-option input:checked + label .payment-icon span {
        filter: brightness(10);
    }
    
    .payment-info {
        flex: 1;
    }
    
    .payment-name {
        font-weight: 600;
        color: #1a1a2e;
        font-size: 0.95rem;
    }
    
    .payment-desc {
        font-size: 0.8rem;
        color: #888;
        margin-top: 0.1rem;
    }
    
    .payment-check {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.8rem;
    }
    
    .payment-option input:checked + label .payment-check {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        border-color: #11998e;
    }
    
    /* Order Button */
    .btn-order {
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
        gap: 0.75rem;
    }
    
    .btn-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
    }
    
    /* Order Summary */
    .order-summary {
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
    
    .order-item {
        display: flex;
        gap: 1rem;
        padding: 0.875rem 0;
        border-bottom: 1px solid #f0f0f0;
        align-items: center;
    }
    
    .order-item:last-of-type {
        border-bottom: none;
    }
    
    .order-item-img {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .order-item-info {
        flex: 1;
    }
    
    .order-item-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 0.2rem;
    }
    
    .order-item-qty {
        font-size: 0.8rem;
        color: #888;
    }
    
    .order-item-price {
        font-weight: 700;
        color: #11998e;
        font-size: 0.95rem;
    }
    
    /* Summary Totals */
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
        font-size: 1.2rem;
        font-weight: 700;
    }
    
    .summary-total .amount {
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
    
    @media (max-width: 992px) {
        .checkout-container {
            grid-template-columns: 1fr;
        }
        
        .order-summary {
            position: static;
        }
        
        .checkout-steps {
            flex-wrap: wrap;
            gap: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="checkout-page">
    <div class="container">
        <!-- Header -->
        <div class="checkout-header">
            <h1 class="checkout-title">🛒 Checkout</h1>
            <p class="checkout-subtitle">Lengkapi informasi pengiriman dan pembayaran</p>
        </div>
        
        <!-- Progress Steps -->
        <div class="checkout-steps">
            <div class="step active">
                <div class="step-number">1</div>
                <span class="step-label">Keranjang</span>
            </div>
            <div class="step-connector"></div>
            <div class="step active">
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
        
        @if($errors->any())
            <div class="alert alert-error" style="margin-bottom: 1.5rem;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="checkout-container">
                <!-- Left Column -->
                <div>
                    <!-- Shipping -->
                    <div class="checkout-card">
                        <div class="card-header">
                            <h3 class="card-title"><span>📍</span> Alamat Pengiriman</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
                                <textarea name="shipping_address" class="form-textarea-premium" rows="3" 
                                          placeholder="Masukkan alamat lengkap (Jalan, RT/RW, Kelurahan, Kecamatan)..." required>{{ old('shipping_address') }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Nomor Telepon <span class="required">*</span></label>
                                <input type="tel" name="phone" class="form-input-premium" 
                                       placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" required>
                            </div>
                            
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">Catatan untuk Kurir (Opsional)</label>
                                <textarea name="notes" class="form-textarea-premium" rows="2" 
                                          placeholder="Contoh: Rumah cat biru, sebelah warung...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment -->
                    <div class="checkout-card">
                        <div class="card-header">
                            <h3 class="card-title"><span>💳</span> Metode Pembayaran</h3>
                        </div>
                        <div class="card-body">
                            <div class="payment-options">
                                <div class="payment-option">
                                    <input type="radio" id="cod" name="payment_method" value="cash" checked>
                                    <label for="cod">
                                        <div class="payment-icon"><span>💵</span></div>
                                        <div class="payment-info">
                                            <div class="payment-name">Bayar di Tempat (COD)</div>
                                            <div class="payment-desc">Bayar tunai saat pesanan tiba</div>
                                        </div>
                                        <div class="payment-check">✓</div>
                                    </label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" id="bank" name="payment_method" value="bank_transfer">
                                    <label for="bank">
                                        <div class="payment-icon"><span>🏦</span></div>
                                        <div class="payment-info">
                                            <div class="payment-name">Transfer Bank</div>
                                            <div class="payment-desc">BCA, BNI, Mandiri, BRI</div>
                                        </div>
                                        <div class="payment-check">✓</div>
                                    </label>
                                </div>
                                <div class="payment-option">
                                    <input type="radio" id="ewallet" name="payment_method" value="e_wallet">
                                    <label for="ewallet">
                                        <div class="payment-icon"><span>📱</span></div>
                                        <div class="payment-info">
                                            <div class="payment-name">E-Wallet</div>
                                            <div class="payment-desc">GoPay, OVO, Dana, ShopeePay</div>
                                        </div>
                                        <div class="payment-check">✓</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-order">
                        🛍️ Buat Pesanan Sekarang
                    </button>
                </div>
                
                <!-- Order Summary -->
                <div class="order-summary">
                    <div class="summary-header">
                        <h3 class="summary-title">📋 Ringkasan Pesanan</h3>
                    </div>
                    <div class="summary-body">
                        @foreach($cartItems as $item)
                            <div class="order-item">
                                <img src="{{ $item->product->image ?? 'https://via.placeholder.com/56x56/f5f5f5/999' }}" 
                                     alt="{{ $item->product->name }}" class="order-item-img">
                                <div class="order-item-info">
                                    <div class="order-item-name">{{ Str::limit($item->product->name, 25) }}</div>
                                    <div class="order-item-qty">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                </div>
                                <div class="order-item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                        
                        <div class="summary-divider"></div>
                        
                        <div class="summary-line">
                            <span>Subtotal ({{ $cartItems->sum('quantity') }} item)</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-line subtle">
                            <span>Biaya Admin</span>
                            <span>Rp {{ number_format($adminFee, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-line subtle">
                            <span>🚚 Ongkos Kirim</span>
                            <span>Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="summary-divider"></div>
                        
                        <div class="summary-total">
                            <span>Total Bayar</span>
                            <span class="amount">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- Security Badge -->
                        <div class="security-badge">
                            <span class="security-icon">🔒</span>
                            <span class="security-text">Transaksi aman & terlindungi. Data Anda terenkripsi.</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
