@extends('layouts.dashboard')

@section('title', 'Detail Pesanan #' . $order->id)
@section('panel_subtitle', 'Pedagang Panel')
@section('page_title', 'Detail Pesanan')
@section('page_subtitle', 'Pesanan #' . $order->id)

@section('header_actions')
<a href="{{ route('pedagang.orders.index') }}" class="btn btn-secondary">← Kembali</a>
@endsection

@section('styles')
<style>
    .order-detail-container {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 1.5rem;
    }
    
    .order-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    
    .order-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .order-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .order-card-body {
        padding: 1.5rem;
    }
    
    /* Status Header */
    .status-header {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .status-header.pending { background: linear-gradient(135deg, #f093fb, #f5576c); }
    .status-header.processing { background: linear-gradient(135deg, #667eea, #764ba2); }
    .status-header.ready { background: linear-gradient(135deg, #ff9966, #ff5e62); }
    .status-header.shipped { background: linear-gradient(135deg, #4facfe, #00f2fe); }
    .status-header.completed { background: linear-gradient(135deg, #11998e, #38ef7d); }
    
    .order-id-big {
        font-size: 1.5rem;
        font-weight: 800;
    }
    
    .status-badge-large {
        padding: 0.5rem 1.25rem;
        background: rgba(255,255,255,0.2);
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    /* Product Table */
    .product-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .product-table th {
        background: #f8f9fa;
        padding: 0.875rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .product-table td {
        padding: 1rem;
        border-bottom: 1px solid #f5f5f5;
    }
    
    .product-table tr:last-child td {
        border-bottom: none;
    }
    
    .product-table tfoot td {
        background: #f8f9fa;
        font-weight: 700;
    }
    
    .total-price {
        font-size: 1.25rem;
        color: #11998e;
    }
    
    /* Info Card */
    .info-item {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1rem;
        align-items: flex-start;
    }
    
    .info-item:last-child {
        margin-bottom: 0;
    }
    
    .info-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    
    .info-content {
        flex: 1;
    }
    
    .info-label {
        font-size: 0.75rem;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.1rem;
    }
    
    .info-value {
        font-weight: 600;
        color: #1a1a2e;
    }
    
    /* Action Card */
    .action-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 1rem;
    }
    
    .action-header {
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-bottom: 1px solid #e2e8f0;
    }
    
    .action-title {
        font-size: 0.9rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .action-body {
        padding: 1.25rem;
    }
    
    .btn-action {
        width: 100%;
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .btn-process {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
    }
    
    .btn-process:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    
    .btn-ship {
        background: linear-gradient(135deg, #ff9966, #ff5e62);
        border: none;
        color: white;
    }
    
    .btn-ship:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 153, 102, 0.4);
    }
    
    /* Delivery Timeline */
    .timeline-item {
        display: flex;
        gap: 1rem;
        position: relative;
        padding-bottom: 1rem;
    }
    
    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 18px;
        top: 36px;
        width: 2px;
        height: calc(100% - 36px);
        background: #e0e0e0;
    }
    
    .timeline-dot {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
        z-index: 1;
    }
    
    .timeline-dot.done {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
    }
    
    .timeline-dot.pending {
        background: #e0e0e0;
        color: #888;
    }
    
    .timeline-content {
        flex: 1;
        padding-top: 0.25rem;
    }
    
    .timeline-title {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 0.1rem;
    }
    
    .timeline-time {
        font-size: 0.8rem;
        color: #888;
    }
    
    @media (max-width: 992px) {
        .order-detail-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Status Header -->
<div class="status-header {{ $order->status }}">
    <div>
        <div class="order-id-big">Pesanan #{{ $order->id }}</div>
        <div style="opacity: 0.9; margin-top: 0.25rem;">{{ $order->created_at->format('d M Y, H:i') }}</div>
    </div>
    <div class="status-badge-large">{{ $order->status_label }}</div>
</div>

<div class="order-detail-container">
    <!-- Left Column: Products -->
    <div>
        <div class="order-card">
            <div class="order-card-header">
                <h3 class="order-card-title"><span>📦</span> Produk Pesanan</h3>
            </div>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div style="font-weight: 500;">{{ $item->product_name }}</div>
                        </td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td><span class="badge badge-secondary">{{ $item->quantity }}</span></td>
                        <td style="font-weight: 600;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;">Total Pembayaran</td>
                        <td class="total-price">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Right Column: Info & Actions -->
    <div>
        <!-- Buyer Info -->
        <div class="order-card" style="margin-bottom: 1rem;">
            <div class="order-card-header">
                <h3 class="order-card-title"><span>👤</span> Info Pembeli</h3>
            </div>
            <div class="order-card-body">
                <div class="info-item">
                    <div class="info-icon">👤</div>
                    <div class="info-content">
                        <div class="info-label">Nama</div>
                        <div class="info-value">{{ $order->user->name ?? '-' }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">📱</div>
                    <div class="info-content">
                        <div class="info-label">Telepon</div>
                        <div class="info-value">{{ $order->phone ?? '-' }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">📍</div>
                    <div class="info-content">
                        <div class="info-label">Alamat</div>
                        <div class="info-value">{{ $order->shipping_address ?? '-' }}</div>
                    </div>
                </div>
                @if($order->notes)
                <div class="info-item">
                    <div class="info-icon">📝</div>
                    <div class="info-content">
                        <div class="info-label">Catatan</div>
                        <div class="info-value">{{ $order->notes }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions based on status -->
        @if($order->status === 'paid')
        <div class="action-card">
            <div class="action-header">
                <h4 class="action-title">🔄 Proses Pesanan</h4>
            </div>
            <div class="action-body">
                <p style="font-size: 0.85rem; color: #666; margin-bottom: 1rem;">Pesanan sudah dibayar. Mulai proses pengemasan produk.</p>
                <form action="{{ route('pedagang.orders.process', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-action btn-process">
                        🔄 Mulai Proses Pesanan
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if(in_array($order->status, ['paid', 'processing']))
        <div class="action-card">
            <div class="action-header">
                <h4 class="action-title">🚚 Kirim ke Kurir</h4>
            </div>
            <div class="action-body">
                <form action="{{ route('pedagang.orders.ready-pickup', $order) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Pilih Kurir</label>
                        <select name="kurir_id" class="form-select" required>
                            <option value="">-- Pilih Kurir --</option>
                            @foreach($kurirs ?? [] as $kurir)
                            <option value="{{ $kurir->id }}">{{ $kurir->name }} ({{ $kurir->phone ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-action btn-ship">
                        📦 Siap Diambil Kurir
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if(in_array($order->status, ['ready_pickup', 'shipped', 'completed']))
        <!-- Delivery Timeline -->
        <div class="order-card">
            <div class="order-card-header">
                <h3 class="order-card-title"><span>🚚</span> Info Pengiriman</h3>
            </div>
            <div class="order-card-body">
                <div class="info-item" style="margin-bottom: 1.5rem;">
                    <div class="info-icon" style="background: linear-gradient(135deg, #11998e, #38ef7d);">🧑</div>
                    <div class="info-content">
                        <div class="info-label">Kurir</div>
                        <div class="info-value">{{ $order->kurir->name ?? '-' }}</div>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-dot {{ $order->picked_up_at ? 'done' : 'pending' }}">📦</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Diambil Kurir</div>
                        <div class="timeline-time">{{ $order->picked_up_at ? $order->picked_up_at->format('d M Y H:i') : 'Menunggu...' }}</div>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-dot {{ $order->delivered_at ? 'done' : 'pending' }}">✅</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Diterima Pembeli</div>
                        <div class="timeline-time">{{ $order->delivered_at ? $order->delivered_at->format('d M Y H:i') : 'Menunggu...' }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
