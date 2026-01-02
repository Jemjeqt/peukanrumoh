@extends('layouts.dashboard')

@section('title', 'Pesanan Masuk')
@section('panel_subtitle', 'Pedagang Panel')
@section('page_title', 'Pesanan')
@section('page_subtitle', 'Kelola pesanan dari pembeli')

@section('content')
<!-- Filters -->
<div class="card mb-2">
    <div class="card-body">
        <form method="GET" class="d-flex gap-2 align-center" style="flex-wrap: wrap;">
            <select name="status" class="form-select" style="max-width: 180px;">
                <option value="">Semua Status</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Diproses</option>
                <option value="ready_pickup" {{ request('status') === 'ready_pickup' ? 'selected' : '' }}>Siap Diambil</option>
                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Dalam Pengiriman</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
            </select>
            <button type="submit" class="btn btn-secondary">🔍 Filter</button>
            <a href="{{ route('pedagang.orders.index') }}" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<!-- Orders Table -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pembeli</th>
                    <th>Produk</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>
                        <div style="font-weight: 500;">{{ $order->user->name ?? '-' }}</div>
                        <div class="text-muted text-small">{{ $order->phone ?? '-' }}</div>
                    </td>
                    <td>
                        @foreach($order->items->take(2) as $item)
                            <div class="text-small">{{ Str::limit($item->product_name, 20) }} x{{ $item->quantity }}</div>
                        @endforeach
                        @if($order->items->count() > 2)
                            <div class="text-muted text-small">+{{ $order->items->count() - 2 }} lainnya</div>
                        @endif
                    </td>
                    <td style="font-weight: 600; color: var(--primary);">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                    </td>
                    <td class="text-small">{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <a href="{{ route('pedagang.orders.show', $order) }}" class="btn btn-sm btn-secondary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted" style="padding: 3rem;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">📋</div>
                        <p>Belum ada pesanan masuk</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $orders->links() }}
@endsection
