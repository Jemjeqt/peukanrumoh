@extends('layouts.dashboard')

@section('title', 'Detail Return #' . $return->id)
@section('panel_subtitle', 'Pedagang Panel')
@section('page_title', 'Detail Return')
@section('page_subtitle', 'Return #' . $return->id)

@section('header_actions')
<a href="{{ route('pedagang.returns.index') }}" class="btn btn-secondary">← Kembali</a>
@endsection

@section('styles')
<style>
    .return-container {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 1.5rem;
    }
    
    /* Status Header */
    .status-header {
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .status-header.pending { background: linear-gradient(135deg, #f093fb, #f5576c); }
    .status-header.pickup { background: linear-gradient(135deg, #ff9966, #ff5e62); }
    .status-header.received { background: linear-gradient(135deg, #667eea, #764ba2); }
    .status-header.sending_replacement { background: linear-gradient(135deg, #4facfe, #00f2fe); }
    .status-header.completed { background: linear-gradient(135deg, #11998e, #38ef7d); }
    .status-header.rejected { background: linear-gradient(135deg, #636e72, #2d3436); }
    
    .return-id-big {
        font-size: 1.5rem;
        font-weight: 800;
    }
    
    .return-type-badge {
        padding: 0.5rem 1rem;
        background: rgba(255,255,255,0.2);
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: inline-block;
    }
    
    .status-badge-large {
        padding: 0.5rem 1.25rem;
        background: rgba(255,255,255,0.2);
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    /* Cards */
    .return-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 1rem;
    }
    
    .return-card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .return-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .return-card-body {
        padding: 1.5rem;
    }
    
    /* Reason Box */
    .reason-box {
        background: linear-gradient(135deg, #fff5f5, #ffe3e3);
        border-left: 4px solid #f5576c;
        padding: 1rem 1.25rem;
        border-radius: 0 12px 12px 0;
        color: #b91c1c;
    }
    
    .reason-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        color: #dc2626;
    }
    
    .reason-text {
        font-size: 0.95rem;
        line-height: 1.6;
    }
    
    /* Product Table */
    .product-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .product-table th {
        background: #f8f9fa;
        padding: 0.75rem 1rem;
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
    
    /* Info Items */
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
        font-size: 0.7rem;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.1rem;
    }
    
    .info-value {
        font-weight: 600;
        color: #1a1a2e;
        font-size: 0.9rem;
    }
    
    /* Action Cards */
    .action-card {
        border: 2px solid;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 1rem;
    }
    
    .action-card.approve {
        border-color: #22c55e;
    }
    
    .action-card.reject {
        border-color: #ef4444;
    }
    
    .action-card.process {
        border-color: #667eea;
    }
    
    .action-header {
        padding: 0.875rem 1.25rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .action-card.approve .action-header {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        color: #166534;
    }
    
    .action-card.reject .action-header {
        background: linear-gradient(135deg, #fef2f2, #fecaca);
        color: #991b1b;
    }
    
    .action-card.process .action-header {
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #3730a3;
    }
    
    .action-body {
        padding: 1.25rem;
        background: white;
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
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-approve {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;
    }
    
    .btn-approve:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
    }
    
    .btn-reject {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
    
    .btn-reject:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }
    
    .btn-process {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }
    
    .btn-process:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    
    /* Timeline */
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
        font-size: 0.9rem;
    }
    
    .timeline-time {
        font-size: 0.75rem;
        color: #888;
    }
    
    /* Refund Total */
    .refund-total {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .refund-label {
        font-weight: 600;
        color: #92400e;
    }
    
    .refund-amount {
        font-size: 1.25rem;
        font-weight: 800;
        color: #b45309;
    }
    
    /* Notes Card */
    .notes-card {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        border-left: 4px solid #94a3b8;
    }
    
    .notes-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 0.35rem;
    }
    
    .notes-text {
        color: #334155;
        font-size: 0.9rem;
    }
    
    @media (max-width: 992px) {
        .return-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Status Header -->
<div class="status-header {{ $return->status }}">
    <div>
        <div class="return-id-big">Return #{{ $return->id }}</div>
        <div class="return-type-badge">
            {{ $return->type === 'replacement' ? '🔄 Tukar Barang' : '💰 Pengembalian Uang' }}
        </div>
    </div>
    <div class="status-badge-large">{{ $return->status_label }}</div>
</div>

<div class="return-container">
    <!-- Left Column -->
    <div>
        <!-- Reason Card -->
        <div class="return-card">
            <div class="return-card-header">
                <h3 class="return-card-title"><span>📋</span> Detail Return</h3>
                <span style="font-size: 0.85rem; color: #888;">Pesanan #{{ str_pad($return->order_id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="return-card-body">
                <div class="reason-box">
                    <div class="reason-label">⚠️ Alasan Return</div>
                    <div class="reason-text">{{ $return->reason }}</div>
                </div>
                
                @if($return->evidence)
                <div style="margin-top: 1.5rem;">
                    <div style="font-weight: 600; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <span>📷</span> Bukti Foto
                    </div>
                    <img src="{{ $return->evidence_url }}" style="max-width: 100%; max-height: 300px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                </div>
                @endif
            </div>
        </div>
        
        <!-- Products Card -->
        <div class="return-card">
            <div class="return-card-header">
                <h3 class="return-card-title"><span>📦</span> Produk dalam Pesanan</h3>
            </div>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($return->order->items as $item)
                    <tr>
                        <td style="font-weight: 500;">{{ $item->product_name }}</td>
                        <td><span class="badge badge-secondary">{{ $item->quantity }}</span></td>
                        <td style="font-weight: 600; color: #11998e;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Right Column -->
    <div>
        <!-- Buyer Info -->
        <div class="return-card">
            <div class="return-card-header">
                <h3 class="return-card-title"><span>👤</span> Info Pembeli</h3>
            </div>
            <div class="return-card-body">
                <div class="info-item">
                    <div class="info-icon">👤</div>
                    <div class="info-content">
                        <div class="info-label">Nama</div>
                        <div class="info-value">{{ $return->user->name ?? '-' }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">📧</div>
                    <div class="info-content">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $return->user->email ?? '-' }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">📱</div>
                    <div class="info-content">
                        <div class="info-label">Telepon</div>
                        <div class="info-value">{{ $return->user->phone ?? '-' }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">📍</div>
                    <div class="info-content">
                        <div class="info-label">Alamat</div>
                        <div class="info-value">{{ $return->order->shipping_address ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions for Pending Status -->
        @if($return->status === 'pending')
        <div class="action-card approve">
            <div class="action-header">✅ Setujui Return</div>
            <div class="action-body">
                <form action="{{ route('pedagang.returns.approve', $return) }}" method="POST">
                    @csrf
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label class="form-label" style="font-size: 0.85rem;">Pilih Kurir Pengambil</label>
                        <select name="kurir_id" class="form-select" required>
                            <option value="">-- Pilih Kurir --</option>
                            @foreach($kurirs ?? [] as $kurir)
                            <option value="{{ $kurir->id }}">{{ $kurir->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-action btn-approve">✅ Setujui Return</button>
                </form>
            </div>
        </div>

        <div class="action-card reject">
            <div class="action-header">❌ Tolak Return</div>
            <div class="action-body">
                <form action="{{ route('pedagang.returns.reject', $return) }}" method="POST">
                    @csrf
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label class="form-label" style="font-size: 0.85rem;">Alasan Penolakan</label>
                        <textarea name="admin_notes" class="form-textarea" rows="2" required 
                                  placeholder="Berikan alasan penolakan..."></textarea>
                    </div>
                    <button type="submit" class="btn-action btn-reject">❌ Tolak Return</button>
                </form>
            </div>
        </div>
        @endif
        
        <!-- Actions for Received Status -->
        @if($return->status === 'received')
        <div class="action-card process">
            <div class="action-header">📦 Proses {{ $return->type_label }}</div>
            <div class="action-body">
                @if($return->type === 'replacement')
                <p style="font-size: 0.85rem; color: #666; margin-bottom: 1rem;">
                    Barang return sudah diterima. Pilih kurir untuk mengirim barang pengganti.
                </p>
                <form action="{{ route('pedagang.returns.send-replacement', $return) }}" method="POST">
                    @csrf
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label class="form-label" style="font-size: 0.85rem;">Pilih Kurir Pengantar</label>
                        <select name="replacement_kurir_id" class="form-select" required>
                            <option value="">-- Pilih Kurir --</option>
                            @foreach($kurirs ?? [] as $kurir)
                            <option value="{{ $kurir->id }}">{{ $kurir->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-action btn-process">🎁 Kirim Barang Pengganti</button>
                </form>
                @else
                <div class="refund-total">
                    <span class="refund-label">💰 Total Refund</span>
                    <span class="refund-amount">Rp {{ number_format($return->order->total, 0, ',', '.') }}</span>
                </div>
                <p style="font-size: 0.85rem; color: #666; margin-bottom: 1rem;">
                    Kirim uang ke rekening pembeli dan upload bukti transfer.
                </p>
                <form action="{{ route('pedagang.returns.send-refund', $return) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label class="form-label" style="font-size: 0.85rem;">Upload Bukti Transfer</label>
                        <input type="file" name="refund_proof" class="form-input" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn-action btn-process">💰 Konfirmasi Transfer</button>
                </form>
                @endif
            </div>
        </div>
        @endif
        
        <!-- Kurir Timeline -->
        @if($return->kurir)
        <div class="return-card">
            <div class="return-card-header">
                <h3 class="return-card-title"><span>🚚</span> Info Kurir</h3>
            </div>
            <div class="return-card-body">
                <div class="info-item" style="margin-bottom: 1.25rem;">
                    <div class="info-icon" style="background: linear-gradient(135deg, #11998e, #38ef7d);">🧑</div>
                    <div class="info-content">
                        <div class="info-label">Kurir</div>
                        <div class="info-value">{{ $return->kurir->name }}</div>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-dot {{ $return->picked_up_at ? 'done' : 'pending' }}">📦</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Diambil dari Pembeli</div>
                        <div class="timeline-time">{{ $return->picked_up_at ? $return->picked_up_at->format('d M Y H:i') : 'Menunggu...' }}</div>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-dot {{ $return->received_at ? 'done' : 'pending' }}">✅</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Diterima Pedagang</div>
                        <div class="timeline-time">{{ $return->received_at ? $return->received_at->format('d M Y H:i') : 'Menunggu...' }}</div>
                    </div>
                </div>
                
                @if($return->type === 'replacement' && $return->replacement_kurir_id)
                <div class="timeline-item">
                    <div class="timeline-dot {{ $return->completed_at ? 'done' : 'pending' }}">🎁</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Pengganti Dikirim</div>
                        <div class="timeline-time">{{ $return->completed_at ? $return->completed_at->format('d M Y H:i') : 'Menunggu...' }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
        
        <!-- Notes -->
        @if($return->admin_notes)
        <div class="notes-card">
            <div class="notes-label">📝 Catatan</div>
            <div class="notes-text">{{ $return->admin_notes }}</div>
        </div>
        @endif
    </div>
</div>
@endsection
