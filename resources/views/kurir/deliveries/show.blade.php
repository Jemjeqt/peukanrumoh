@extends('layouts.dashboard')

@section('title', 'Detail Pengiriman #' . $order->id)

@section('content')
<div class="mb-2">
    <a href="{{ route('kurir.deliveries.index') }}" class="text-muted" style="text-decoration: none;">← Kembali ke Pengiriman</a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    <!-- Order Details -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Pengiriman #{{ $order->id }}</h2>
            <span class="badge badge-{{ $order->status_badge }}">{{ $order->status_label }}</span>
        </div>
        <div class="card-body">
            <h4 style="margin-bottom: 1rem;">Produk</h4>
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delivery Info & Actions -->
    <div>
        <div class="card mb-2">
            <div class="card-header">
                <h3 class="card-title">Info Pembeli</h3>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ $order->user->name ?? '-' }}</p>
                <p><strong>Telepon:</strong> {{ $order->phone ?? '-' }}</p>
                <p style="margin-top: 1rem;"><strong>Alamat Pengiriman:</strong></p>
                <p style="background: #f5f5f5; padding: 0.75rem; border-radius: 8px;">{{ $order->shipping_address ?? '-' }}</p>
                @if($order->notes)
                <p><strong>Catatan:</strong> {{ $order->notes }}</p>
                @endif
            </div>
        </div>

        <!-- Actions -->
        @if($order->status === 'ready_pickup')
        <div class="card">
            <div class="card-body">
                <form action="{{ route('kurir.deliveries.pickup', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        📦 Ambil Pesanan Ini
                    </button>
                </form>
                <p class="text-muted text-small text-center mt-1">Klik jika sudah mengambil pesanan dari pedagang</p>
            </div>
        </div>
        @elseif($order->status === 'shipped')
        <div class="card">
            <div class="card-body">
                <p class="text-muted text-small mb-1">Diambil: {{ $order->picked_up_at ? $order->picked_up_at->format('d M Y H:i') : '-' }}</p>
                <form action="{{ route('kurir.deliveries.deliver', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        ✅ Pesanan Sudah Diantar
                    </button>
                </form>
                <p class="text-muted text-small text-center mt-1">Klik jika sudah menyerahkan ke pembeli</p>
            </div>
        </div>
        @elseif($order->status === 'completed')
        <div class="card">
            <div class="card-body">
                <div class="alert alert-success mb-0">
                    ✅ Pengiriman Selesai!<br>
                    <small>Diantar: {{ $order->delivered_at ? $order->delivered_at->format('d M Y H:i') : '-' }}</small>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
