@extends('layouts.dashboard')

@section('title', 'Kelola Pesanan')
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Kelola Pesanan')
@section('page_subtitle', 'Monitor dan kelola semua pesanan platform')

@section('content')
<!-- Filters -->
<div class="card mb-2">
    <div class="card-body">
        <form method="GET" class="d-flex gap-2 align-center" style="flex-wrap: wrap;">
            <input type="text" name="search" class="form-input" placeholder="Cari ID pesanan atau pembeli..." 
                   value="{{ request('search') }}" style="max-width: 250px;">
            <select name="status" class="form-select" style="max-width: 180px;">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Bayar</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Diproses</option>
                <option value="ready_pickup" {{ request('status') === 'ready_pickup' ? 'selected' : '' }}>Siap Diambil</option>
                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Dalam Pengiriman</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="btn btn-secondary">🔍 Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">Reset</a>
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
                    <th>Total</th>
                    <th>Status</th>
                    <th>Kurir</th>
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
                    <td style="font-weight: 600; color: var(--primary);">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                    </td>
                    <td>{{ $order->kurir->name ?? '-' }}</td>
                    <td class="text-small">{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-secondary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted" style="padding: 3rem;">
                        Tidak ada pesanan ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $orders->links() }}
@endsection
