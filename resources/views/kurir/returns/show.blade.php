@extends('layouts.dashboard')

@section('title', 'Detail Return #' . $return->id)

@section('content')
<div class="mb-2">
    <a href="{{ route('kurir.returns.index') }}" class="text-muted" style="text-decoration: none;">← Kembali ke Return</a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    <!-- Return Details -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Return #{{ $return->id }}</h2>
            <span class="badge badge-{{ $return->status_badge }}">{{ $return->status_label }}</span>
        </div>
        <div class="card-body">
            <div style="margin-bottom: 1rem;">
                <strong>Tipe:</strong> 
                <span class="badge badge-{{ $return->type === 'replacement' ? 'info' : 'warning' }}">
                    {{ $return->type_label }}
                </span>
            </div>
            
            <div style="margin-bottom: 1rem;">
                <strong>Alasan:</strong>
                <p style="background: #f5f5f5; padding: 0.75rem; border-radius: 6px; margin-top: 0.5rem;">
                    {{ $return->reason }}
                </p>
            </div>
            
            @if($return->evidence)
            <div>
                <strong>Bukti Foto:</strong>
                <div style="margin-top: 0.5rem;">
                    <img src="{{ $return->evidence_url }}" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Side Info & Actions -->
    <div>
        <div class="card mb-2">
            <div class="card-header">
                <h3 class="card-title">Info Pembeli</h3>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ $return->user->name ?? '-' }}</p>
                <p><strong>Telepon:</strong> {{ $return->user->phone ?? '-' }}</p>
                <p><strong>Alamat:</strong></p>
                <p style="background: #f5f5f5; padding: 0.75rem; border-radius: 6px;">
                    {{ $return->order->shipping_address ?? '-' }}
                </p>
            </div>
        </div>

        @if($return->status === 'pickup')
        <div class="card">
            <div class="card-body">
                <form action="{{ route('kurir.returns.pickup', $return) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        📦 Ambil Barang dari Pembeli
                    </button>
                </form>
                <p class="text-muted text-small text-center mt-1">Klik setelah mengambil barang</p>
            </div>
        </div>
        @elseif($return->status === 'received')
        <div class="card">
            <div class="card-body">
                <div class="alert alert-info mb-1">
                    Barang sudah diambil, kirim ke pedagang
                </div>
                <form action="{{ route('kurir.returns.deliver', $return) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        ✅ Sudah Diantar ke Pedagang
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
