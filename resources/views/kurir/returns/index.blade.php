@extends('layouts.dashboard')

@section('title', 'Return Barang')
@section('panel_subtitle', 'Kurir Panel')
@section('page_title', 'Return')
@section('page_subtitle', 'Kelola pengambilan dan pengantaran barang return')

@section('content')
<!-- Filters -->
<div class="card mb-2">
    <div class="card-body">
        <form method="GET" class="d-flex gap-2 align-center" style="flex-wrap: wrap;">
            <select name="status" class="form-select" style="max-width: 200px;">
                <option value="">Return Aktif</option>
                <option value="pickup" {{ request('status') === 'pickup' ? 'selected' : '' }}>Siap Diambil</option>
                <option value="received" {{ request('status') === 'received' ? 'selected' : '' }}>Sudah Diambil</option>
            </select>
            <button type="submit" class="btn btn-secondary">🔍 Filter</button>
            <a href="{{ route('kurir.returns.index') }}" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pembeli</th>
                    <th>Alamat</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returns as $return)
                <tr>
                    <td><strong>#{{ $return->id }}</strong></td>
                    <td>
                        <div style="font-weight: 500;">{{ $return->user->name ?? '-' }}</div>
                        <div class="text-muted text-small">{{ $return->user->phone ?? '-' }}</div>
                    </td>
                    <td class="text-small">{{ Str::limit($return->order->shipping_address ?? '-', 40) }}</td>
                    <td>
                        <span class="badge badge-{{ $return->type === 'replacement' ? 'info' : 'warning' }}">
                            {{ $return->type_label }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $return->status_badge }}">{{ $return->status_label }}</span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @if($return->status === 'pickup')
                            <form action="{{ route('kurir.returns.pickup', $return) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">📦 Ambil</button>
                            </form>
                            @elseif($return->status === 'delivering')
                            <form action="{{ route('kurir.returns.deliver', $return) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">✅ Antar ke Pedagang</button>
                            </form>
                            @elseif($return->status === 'replacement_shipping')
                            <form action="{{ route('kurir.returns.deliver-replacement', $return) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning">🎁 Antar ke Pembeli</button>
                            </form>
                            @endif
                            <a href="{{ route('kurir.returns.show', $return) }}" class="btn btn-sm btn-secondary">Detail</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted" style="padding: 3rem;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🔄</div>
                        <p>Tidak ada return aktif</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $returns->links() }}
@endsection
