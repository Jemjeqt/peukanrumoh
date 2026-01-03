@extends('layouts.dashboard')

@section('title', 'Detail User - ' . $user->name)
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Detail User')
@section('page_subtitle', $user->name)

@section('header_actions')
<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">← Kembali</a>
@endsection

@section('styles')
<style>
    /* Hero Header */
    .user-hero {
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .user-hero.admin { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .user-hero.pedagang { background: linear-gradient(135deg, #f97316, #ea580c); }
    .user-hero.pembeli { background: linear-gradient(135deg, #22c55e, #16a34a); }
    .user-hero.kurir { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    
    .user-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 50%;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(30deg);
    }
    
    .user-hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 2rem;
    }
    
    .hero-avatar {
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 4px solid rgba(255,255,255,0.4);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    
    .hero-info { flex: 1; }
    
    .hero-name {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
    }
    
    .hero-email {
        opacity: 0.9;
        font-size: 1rem;
        margin-bottom: 1rem;
    }
    
    .hero-badges {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .hero-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
    }
    
    /* Stats Cards */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        text-align: center;
        transition: all 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 0.75rem;
    }
    
    .stat-icon.orders { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
    .stat-icon.spent { background: linear-gradient(135deg, #d1fae5, #a7f3d0); }
    .stat-icon.products { background: linear-gradient(135deg, #fef3c7, #fde68a); }
    .stat-icon.date { background: linear-gradient(135deg, #ede9fe, #ddd6fe); }
    
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a2e;
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
    
    /* Main Grid */
    .user-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    
    /* Info Cards */
    .info-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        margin-bottom: 1rem;
    }
    
    .info-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
    
    .info-icon.user { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
    .info-icon.contact { background: linear-gradient(135deg, #d1fae5, #a7f3d0); }
    .info-icon.account { background: linear-gradient(135deg, #fef3c7, #fde68a); }
    .info-icon.actions { background: linear-gradient(135deg, #ede9fe, #ddd6fe); }
    
    .info-card-header h3 {
        font-size: 1.05rem;
        font-weight: 700;
        margin: 0;
        color: #1a1a2e;
    }
    
    .info-card-body { padding: 1.5rem; }
    
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .info-item:last-child { border-bottom: none; }
    
    .info-item-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    
    .info-item-content { flex: 1; }
    
    .info-item-label {
        font-size: 0.75rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .info-item-value {
        font-size: 1rem;
        color: #1a1a2e;
        font-weight: 500;
    }
    
    /* Status Badge */
    .status-approved {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        color: #16a34a;
        font-weight: 600;
    }
    
    .status-pending {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        color: #ea580c;
        font-weight: 600;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .btn-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 1rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }
    
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    }
    
    .btn-approve {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;
    }
    
    .btn-approve:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(22, 163, 74, 0.3);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
    
    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3);
    }
    
    .btn-disabled {
        background: #e5e7eb;
        color: #9ca3af;
        cursor: not-allowed;
    }
    
    /* Activity Timeline */
    .activity-item {
        display: flex;
        gap: 1rem;
        padding: 0.75rem 0;
    }
    
    .activity-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #22c55e;
        margin-top: 0.35rem;
        flex-shrink: 0;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-title {
        font-weight: 600;
        color: #1a1a2e;
        font-size: 0.95rem;
    }
    
    .activity-time {
        font-size: 0.8rem;
        color: #9ca3af;
    }

    @media (max-width: 768px) {
        .user-hero-content { flex-direction: column; text-align: center; }
        .hero-badges { justify-content: center; }
        .stats-row { grid-template-columns: repeat(2, 1fr); }
        .user-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
@php
    $totalOrders = $user->orders_count ?? ($user->orders ? $user->orders->count() : 0);
    $totalSpent = $user->total_spent ?? ($user->orders ? $user->orders->sum('total') : 0);
    $totalProducts = $user->products_count ?? ($user->products ? $user->products->count() : 0);
@endphp

<!-- Hero Header -->
<div class="user-hero {{ $user->role }}">
    <div class="user-hero-content">
        <div class="hero-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
        <div class="hero-info">
            <div class="hero-name">{{ $user->name }}</div>
            <div class="hero-email">📧 {{ $user->email }}</div>
            <div class="hero-badges">
                <span class="hero-badge">
                    @switch($user->role)
                        @case('admin') 👑 Administrator @break
                        @case('pedagang') 🏪 Pedagang @break
                        @case('pembeli') 🛒 Pembeli @break
                        @case('kurir') 🚚 Kurir @break
                        @default {{ ucfirst($user->role) }}
                    @endswitch
                </span>
                @if($user->is_approved)
                    <span class="hero-badge">✓ Terverifikasi</span>
                @else
                    <span class="hero-badge">⏳ Menunggu Verifikasi</span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="stats-row">
    @if($user->role === 'pembeli')
    <div class="stat-card">
        <div class="stat-icon orders">📦</div>
        <div class="stat-value">{{ $totalOrders }}</div>
        <div class="stat-label">Total Pesanan</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon spent">💰</div>
        <div class="stat-value">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
        <div class="stat-label">Total Belanja</div>
    </div>
    @elseif($user->role === 'pedagang')
    <div class="stat-card">
        <div class="stat-icon products">📦</div>
        <div class="stat-value">{{ $totalProducts }}</div>
        <div class="stat-label">Total Produk</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orders">🛒</div>
        <div class="stat-value">-</div>
        <div class="stat-label">Pesanan Diterima</div>
    </div>
    @else
    <div class="stat-card">
        <div class="stat-icon orders">📊</div>
        <div class="stat-value">-</div>
        <div class="stat-label">Aktivitas</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon spent">📈</div>
        <div class="stat-value">-</div>
        <div class="stat-label">Statistik</div>
    </div>
    @endif
    <div class="stat-card">
        <div class="stat-icon date">📅</div>
        <div class="stat-value">{{ $user->created_at->format('d M Y') }}</div>
        <div class="stat-label">Bergabung</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #fce7f3, #fbcfe8);">🕐</div>
        <div class="stat-value">{{ $user->updated_at->diffForHumans() }}</div>
        <div class="stat-label">Update Terakhir</div>
    </div>
</div>

<!-- Main Grid -->
<div class="user-grid">
    <!-- Left Column -->
    <div>
        <!-- Personal Info -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon user">👤</div>
                <h3>Informasi Personal</h3>
            </div>
            <div class="info-card-body">
                <div class="info-item">
                    <div class="info-item-icon">🆔</div>
                    <div class="info-item-content">
                        <div class="info-item-label">ID User</div>
                        <div class="info-item-value">#{{ $user->id }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">👤</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Nama Lengkap</div>
                        <div class="info-item-value">{{ $user->name }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">📧</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Email</div>
                        <div class="info-item-value">{{ $user->email }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">🏷️</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Role</div>
                        <div class="info-item-value">{{ ucfirst($user->role) }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Info -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon contact">📞</div>
                <h3>Informasi Kontak</h3>
            </div>
            <div class="info-card-body">
                <div class="info-item">
                    <div class="info-item-icon">📱</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Telepon</div>
                        <div class="info-item-value">{{ $user->phone ?? '-' }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">📍</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Alamat</div>
                        <div class="info-item-value">{{ $user->address ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Column -->
    <div>
        <!-- Account Info -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon account">⚙️</div>
                <h3>Informasi Akun</h3>
            </div>
            <div class="info-card-body">
                <div class="info-item">
                    <div class="info-item-icon">✅</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Status Verifikasi</div>
                        <div class="info-item-value">
                            @if($user->is_approved)
                                <span class="status-approved">✓ Terverifikasi</span>
                            @else
                                <span class="status-pending">⏳ Menunggu Verifikasi</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">📅</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Tanggal Bergabung</div>
                        <div class="info-item-value">{{ $user->created_at->format('d F Y, H:i') }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">🔄</div>
                    <div class="info-item-content">
                        <div class="info-item-label">Update Terakhir</div>
                        <div class="info-item-value">{{ $user->updated_at->format('d F Y, H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-icon actions">🎯</div>
                <h3>Aksi</h3>
            </div>
            <div class="info-card-body">
                <div class="action-buttons">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn-action btn-edit">
                        ✏️ Edit User
                    </a>
                    
                    @if(!$user->is_approved)
                    <form action="{{ route('admin.users.approve', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-action btn-approve" style="width: 100%;">
                            ✓ Approve User
                        </button>
                    </form>
                    @endif
                    
                    @if($user->id !== auth()->id())
                    <form id="deleteUserForm" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: none;">
                        @csrf @method('DELETE')
                    </form>
                    <button type="button" class="btn-action btn-delete" id="btnHapusUser">
                        🗑 Hapus User
                    </button>
                    @else
                    <button class="btn-action btn-disabled" disabled>
                        🚫 Tidak dapat menghapus akun sendiri
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var btnHapus = document.getElementById('btnHapusUser');
    if (btnHapus) {
        btnHapus.addEventListener('click', function() {
            Swal.fire({
                title: 'Hapus User?',
                text: 'Apakah Anda yakin ingin menghapus user {{ $user->name }}?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('deleteUserForm').submit();
                }
            });
        });
    }
});
</script>
@endsection
