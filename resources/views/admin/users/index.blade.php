@extends('layouts.dashboard')

@section('title', 'Kelola Users')
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Kelola Users')
@section('page_subtitle', 'Manajemen pengguna platform')

@section('header_actions')
<a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Tambah User</a>
@endsection

@section('content')
<!-- Filters -->
<div class="card mb-2">
    <div class="card-body">
        <form method="GET" class="d-flex gap-2 align-center" style="flex-wrap: wrap;">
            <input type="text" name="search" class="form-input" placeholder="Cari nama atau email..." 
                   value="{{ request('search') }}" style="max-width: 250px;">
            <select name="role" class="form-select" style="max-width: 150px;">
                <option value="">Semua Role</option>
                <option value="pembeli" {{ request('role') === 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                <option value="pedagang" {{ request('role') === 'pedagang' ? 'selected' : '' }}>Pedagang</option>
                <option value="kurir" {{ request('role') === 'kurir' ? 'selected' : '' }}>Kurir</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <select name="approved" class="form-select" style="max-width: 150px;">
                <option value="">Semua Status</option>
                <option value="yes" {{ request('approved') === 'yes' ? 'selected' : '' }}>Disetujui</option>
                <option value="no" {{ request('approved') === 'no' ? 'selected' : '' }}>Menunggu</option>
            </select>
            <button type="submit" class="btn btn-secondary">🔍 Filter</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Telepon</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="font-weight: 500;">{{ $user->name }}</div>
                        <div class="text-muted text-small">{{ $user->email }}</div>
                    </td>
                    <td>
                        <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'pedagang' ? 'warning' : ($user->role === 'kurir' ? 'info' : 'primary')) }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        @if($user->is_approved)
                            <span class="badge badge-success">✓ Disetujui</span>
                        @else
                            <span class="badge badge-warning">⏳ Menunggu</span>
                        @endif
                    </td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td class="text-small">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                            @if(!$user->is_approved)
                            <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="ajax-approve-form">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success ajax-btn" title="Setujui">✓</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Tidak ada user ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $users->links() }}

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
    
    document.querySelectorAll('.ajax-approve-form').forEach(form => {
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
                row.style.background = '#d1fae5';
                
                const statusCell = row.querySelector('td:nth-child(3)');
                if (statusCell) {
                    statusCell.innerHTML = '<span class="badge badge-success">✓ Disetujui</span>';
                }
                
                form.remove();
                showToast('User berhasil disetujui!');
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerHTML = originalText;
                btn.disabled = false;
                showToast('Gagal menyetujui', true);
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

