@extends('layouts.dashboard')

@section('title', 'Permintaan Return')
@section('panel_subtitle', 'Pedagang Panel')
@section('page_title', 'Return')
@section('page_subtitle', 'Kelola permintaan return dari pembeli')

@section('content')
<!-- Filters -->
<div class="card mb-2">
    <div class="card-body">
        <form method="GET" class="d-flex gap-2 align-center" style="flex-wrap: wrap;">
            <select name="status" class="form-select" style="max-width: 180px;">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="pickup" {{ request('status') === 'pickup' ? 'selected' : '' }}>Siap Diambil</option>
                <option value="received" {{ request('status') === 'received' ? 'selected' : '' }}>Diterima</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <button type="submit" class="btn btn-secondary">🔍 Filter</button>
            <a href="{{ route('pedagang.returns.index') }}" class="btn btn-outline">Reset</a>
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
                    <th>Pesanan</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Tanggal</th>
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
                    <td>#{{ str_pad($return->order_id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <span class="badge badge-{{ $return->type === 'replacement' ? 'info' : 'warning' }}">
                            {{ $return->type_label }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $return->status_badge }}">{{ $return->status_label }}</span>
                    </td>
                    <td class="text-small">{{ $return->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('pedagang.returns.show', $return) }}" class="btn btn-sm btn-secondary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted" style="padding: 3rem;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🔄</div>
                        <p>Belum ada permintaan return</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $returns->links() }}
@endsection
