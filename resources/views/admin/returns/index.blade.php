@extends('layouts.dashboard')

@section('title', 'Return')
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Return')
@section('page_subtitle', 'Monitoring permintaan return')

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
            <a href="{{ route('admin.returns.index') }}" class="btn btn-outline">Reset</a>
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
                        <span class="badge badge-{{ $return->type === 'refund' ? 'warning' : 'info' }}">
                            {{ $return->type === 'refund' ? '💰 Refund' : '🔄 Tukar' }}
                        </span>
                    </td>
                    <td>
                        @php
                            $statusColors = [
                                'pending' => 'warning',
                                'pickup' => 'info',
                                'received' => 'primary',
                                'completed' => 'success',
                                'rejected' => 'danger'
                            ];
                            $statusLabels = [
                                'pending' => 'Menunggu',
                                'pickup' => 'Siap Diambil',
                                'received' => 'Diterima',
                                'completed' => 'Selesai',
                                'rejected' => 'Ditolak'
                            ];
                        @endphp
                        <span class="badge badge-{{ $statusColors[$return->status] ?? 'secondary' }}">
                            {{ $statusLabels[$return->status] ?? $return->status }}
                        </span>
                    </td>
                    <td>{{ $return->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.returns.show', $return) }}" class="btn btn-sm btn-secondary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 3rem;">
                        <div style="font-size: 3rem; margin-bottom: 0.5rem;">↩️</div>
                        <p class="text-muted">Belum ada data return</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($returns->hasPages())
<div style="margin-top: 1rem;">
    {{ $returns->withQueryString()->links() }}
</div>
@endif
@endsection
