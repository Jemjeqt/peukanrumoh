@extends('layouts.dashboard')

@section('title', 'Pengiriman')
@section('panel_subtitle', 'Kurir Panel')
@section('page_title', 'Pengiriman')
@section('page_subtitle', 'Kelola pesanan yang perlu dikirim')

@section('header_actions')
<a href="{{ route('kurir.deliveries.history') }}" class="btn btn-secondary">📜 Riwayat</a>
@endsection

@section('content')
<!-- Filters -->
<div class="card mb-2">
    <div class="card-body">
        <form method="GET" class="d-flex gap-2 align-center" style="flex-wrap: wrap;">
            <select name="status" class="form-select" style="max-width: 200px;">
                <option value="">Pengiriman Aktif</option>
                <option value="ready_pickup" {{ request('status') === 'ready_pickup' ? 'selected' : '' }}>Siap Diambil</option>
                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Dalam Pengiriman</option>
            </select>
            <button type="submit" class="btn btn-secondary">🔍 Filter</button>
            <a href="{{ route('kurir.deliveries.index') }}" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<!-- Deliveries Table -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pembeli</th>
                    <th>Alamat</th>
                    <th>Status</th>
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
                        <div class="text-small">{{ Str::limit($order->shipping_address, 50) }}</div>
                    </td>
                    <td>
                        <span class="badge badge-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @if($order->status === 'ready_pickup')
                            <form action="{{ route('kurir.deliveries.pickup', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">📦 Ambil</button>
                            </form>
                            @elseif($order->status === 'shipped')
                            <form action="{{ route('kurir.deliveries.deliver', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">✅ Selesai</button>
                            </form>
                            @endif
                            <a href="{{ route('kurir.deliveries.show', $order) }}" class="btn btn-sm btn-secondary">Detail</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted" style="padding: 3rem;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                        <p>Tidak ada pengiriman aktif</p>
                        <p class="text-small">Pesanan yang siap diambil akan muncul di sini</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $orders->links() }}
@endsection
