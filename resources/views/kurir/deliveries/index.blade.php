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
                            <form action="{{ route('kurir.deliveries.pickup', $order) }}" method="POST" class="ajax-action-form">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary ajax-btn">📦 Ambil</button>
                            </form>
                            @elseif($order->status === 'shipped')
                            <form action="{{ route('kurir.deliveries.deliver', $order) }}" method="POST" class="ajax-action-form">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary ajax-btn">✅ Selesai</button>
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

<!-- Toast Notification -->
<div id="toast" style="position: fixed; bottom: 20px; right: 20px; background: linear-gradient(135deg, #11998e, #38ef7d); color: white; padding: 1rem 1.5rem; border-radius: 12px; font-weight: 600; box-shadow: 0 8px 30px rgba(0,0,0,0.2); z-index: 9999; transform: translateY(100px); opacity: 0; transition: all 0.3s ease;">
    <span id="toast-message">Berhasil!</span>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');
    
    document.querySelectorAll('.ajax-action-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = form.querySelector('.ajax-btn');
            const row = form.closest('tr');
            const originalText = btn.innerHTML;
            btn.innerHTML = '⏳';
            btn.disabled = true;
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            })
            .then(() => {
                row.style.transition = 'all 0.3s ease';
                row.style.opacity = '0.5';
                row.style.background = '#d1fae5';
                
                showToast('Status berhasil diupdate!');
                
                setTimeout(() => {
                    location.reload();
                }, 1000);
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerHTML = originalText;
                btn.disabled = false;
                showToast('Gagal update status', true);
            });
        });
    });
    
    function showToast(message, isError = false) {
        toastMessage.textContent = message;
        toast.style.background = isError 
            ? 'linear-gradient(135deg, #dc2626, #ef4444)' 
            : 'linear-gradient(135deg, #11998e, #38ef7d)';
        toast.style.transform = 'translateY(0)';
        toast.style.opacity = '1';
        
        setTimeout(() => {
            toast.style.transform = 'translateY(100px)';
            toast.style.opacity = '0';
        }, 2000);
    }
});
</script>
@endsection

