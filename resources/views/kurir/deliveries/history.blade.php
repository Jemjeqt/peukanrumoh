@extends('layouts.dashboard')

@section('title', 'Riwayat Pengiriman')
@section('panel_subtitle', 'Kurir Panel')
@section('page_title', 'Riwayat')
@section('page_subtitle', 'Semua pengiriman dan return yang telah selesai')

@section('styles')
<style>
    /* Header */
    .history-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 16px;
        padding: 1.5rem 2rem;
        color: white;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .history-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }
    
    .history-header p {
        opacity: 0.9;
        margin: 0.25rem 0 0;
        font-size: 0.9rem;
    }
    
    .history-stats {
        display: flex;
        gap: 2rem;
    }
    
    .history-stat {
        text-align: center;
    }
    
    .history-stat .value {
        font-size: 1.75rem;
        font-weight: 700;
    }
    
    .history-stat .label {
        font-size: 0.8rem;
        opacity: 0.85;
    }
    
    /* History Cards */
    .history-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .history-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.2s;
    }
    
    .history-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    
    .history-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .history-info {
        flex: 1;
        min-width: 0;
    }
    
    .history-info .order-id {
        font-weight: 700;
        color: var(--primary);
        font-size: 1rem;
    }
    
    .history-info .buyer {
        color: var(--text-dark);
        font-weight: 500;
    }
    
    .history-info .address {
        color: var(--text-gray);
        font-size: 0.85rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .history-times {
        display: flex;
        gap: 1.5rem;
        flex-shrink: 0;
    }
    
    .time-item {
        text-align: center;
    }
    
    .time-item .icon {
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
    }
    
    .time-item .time {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-dark);
    }
    
    .time-item .label {
        font-size: 0.7rem;
        color: var(--text-gray);
    }
    
    .history-badge {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .empty-history {
        background: white;
        border-radius: 16px;
        padding: 4rem 2rem;
        text-align: center;
    }
    
    .empty-history .icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .empty-history p {
        color: var(--text-gray);
        margin-bottom: 1rem;
    }
    
    @media (max-width: 768px) {
        .history-header {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
        
        .history-card {
            flex-wrap: wrap;
        }
        
        .history-times {
            width: 100%;
            justify-content: center;
            margin-top: 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Header -->
<div class="history-header">
    <div>
        <h1>📜 Riwayat Pengiriman</h1>
        <p>Semua pengiriman yang telah selesai</p>
    </div>
    <div class="history-stats">
        <div class="history-stat">
            <div class="value">{{ $orders->total() }}</div>
            <div class="label">Total Selesai</div>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="d-flex justify-between align-center mb-2">
    <a href="{{ route('kurir.dashboard') }}" class="btn btn-outline btn-sm">← Kembali ke Dashboard</a>
    <a href="{{ route('kurir.deliveries.index') }}" class="btn btn-primary btn-sm">📦 Pengiriman Aktif</a>
</div>

<!-- History List -->
@if($orders->count() > 0)
<div class="history-list">
    @foreach($orders as $order)
    <div class="history-card">
        <div class="history-icon">✅</div>
        <div class="history-info">
            <div class="order-id">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="buyer">{{ $order->user->name ?? 'Pembeli' }}</div>
            <div class="address">📍 {{ Str::limit($order->shipping_address, 50) }}</div>
        </div>
        <div class="history-times">
            <div class="time-item">
                <div class="icon">📦</div>
                <div class="time">{{ $order->picked_up_at ? $order->picked_up_at->format('H:i') : '-' }}</div>
                <div class="label">Diambil</div>
            </div>
            <div class="time-item">
                <div class="icon">🏠</div>
                <div class="time">{{ $order->delivered_at ? $order->delivered_at->format('H:i') : '-' }}</div>
                <div class="label">Diantar</div>
            </div>
        </div>
        <div class="history-badge">
            ✅ {{ $order->delivered_at ? $order->delivered_at->format('d M Y') : '-' }}
        </div>
    </div>
    @endforeach
</div>

<div class="mt-2">
    {{ $orders->links() }}
</div>
@else
<div class="empty-history">
    <div class="icon">📜</div>
    <p>Belum ada riwayat pengiriman</p>
    <a href="{{ route('kurir.deliveries.index') }}" class="btn btn-primary">Lihat Pengiriman Aktif</a>
</div>
@endif

<!-- Return History Section -->
@if(isset($returns) && $returns->count() > 0)
<div class="history-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); margin-top: 2rem;">
    <div>
        <h1>🔄 Riwayat Return</h1>
        <p>Return yang telah selesai diproses</p>
    </div>
    <div class="history-stats">
        <div class="history-stat">
            <div class="value">{{ $returns->count() }}</div>
            <div class="label">Total Return</div>
        </div>
    </div>
</div>

<div class="history-list">
    @foreach($returns as $return)
    <div class="history-card">
        <div class="history-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">🔄</div>
        <div class="history-info">
            <div class="order-id">Return #{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="buyer">{{ $return->order->user->name ?? 'Pembeli' }}</div>
            <div class="address">📍 {{ Str::limit($return->order->shipping_address ?? '-', 50) }}</div>
        </div>
        <div class="history-times">
            <div class="time-item">
                <div class="icon">📅</div>
                <div class="time">{{ $return->created_at->format('d M Y') }}</div>
                <div class="label">Dibuat</div>
            </div>
            <div class="time-item">
                <div class="icon">{{ $return->type === 'replacement' ? '📦' : '💵' }}</div>
                <div class="time">{{ ucfirst($return->type) }}</div>
                <div class="label">Tipe</div>
            </div>
        </div>
        <div class="history-badge" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            ✅ {{ $return->updated_at->format('d M Y H:i') }}
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
