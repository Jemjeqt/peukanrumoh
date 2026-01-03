@extends('layouts.main')

@section('title', 'Profil Saya')

@section('styles')
<style>
    .profile-page {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    /* Hero Section */
    .profile-hero {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .profile-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .profile-hero-content {
        display: flex;
        align-items: center;
        gap: 2rem;
        position: relative;
        z-index: 1;
    }
    
    .profile-avatar-large {
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,0.2);
        border: 4px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    
    .profile-info h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .profile-info .email {
        opacity: 0.9;
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
    }
    
    .profile-badges {
        display: flex;
        gap: 0.5rem;
    }
    
    .profile-badge {
        background: rgba(255,255,255,0.2);
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    /* Stats Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.25rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        text-align: center;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #11998e;
    }
    
    .stat-label {
        color: var(--text-gray);
        font-size: 0.85rem;
    }
    
    /* Main Grid */
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 1.5rem;
        align-items: stretch;
    }
    
    .profile-grid.single-column {
        grid-template-columns: 1fr;
    }
    
    .profile-grid.two-column {
        grid-template-columns: 1fr 1fr;
    }
    
    .full-width {
        grid-column: 1 / -1;
    }
    
    /* Cards */
    .profile-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    
    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .card-header h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    /* Store Section for Pedagang */
    .store-preview {
        background: linear-gradient(135deg, #f8faff 0%, #ffffff 100%);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px dashed var(--border);
    }
    
    .store-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }
    
    .store-logo {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .store-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
    }
    
    .store-name {
        font-size: 1.1rem;
        font-weight: 700;
    }
    
    .store-desc {
        color: var(--text-gray);
        font-size: 0.9rem;
    }
    
    /* Form Styling */
    .form-section {
        margin-bottom: 1.5rem;
    }
    
    .form-section:last-child {
        margin-bottom: 0;
    }
    
    .section-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1rem;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    /* Order Cards */
    .order-item {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    
    .order-item:hover {
        border-color: var(--primary);
        background: white;
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    
    .order-id {
        font-weight: 600;
        color: var(--primary);
    }
    
    .order-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        color: var(--text-gray);
    }
    
    .order-total {
        font-weight: 700;
        color: var(--secondary);
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-gray);
    }
    
    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    @media (max-width: 900px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
        
        .profile-hero-content {
            flex-direction: column;
            text-align: center;
        }
        
        .profile-badges {
            justify-content: center;
        }
        
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="container profile-page">
    @if($errors->any())
        <div class="alert alert-error mb-2">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    
    <!-- Hero Section -->
    <div class="profile-hero">
        <div class="profile-hero-content">
            <div class="profile-avatar-large">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="profile-info">
                <h1>{{ $user->name }}</h1>
                <div class="email">{{ $user->email }}</div>
                <div class="profile-badges">
                    <span class="profile-badge">{{ ucfirst($user->role) }}</span>
                    @if($user->is_approved)
                        <span class="profile-badge">✓ Terverifikasi</span>
                    @endif
                    <span class="profile-badge">Bergabung {{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Stats Row -->
    @if($user->isPembeli() && !empty($stats))
    @php
        $totalSpent = $stats['total_spent'] ?? 0;
        // Member Tier Logic
        if ($totalSpent >= 5000000) {
            $memberTier = 'Diamond';
            $tierIcon = '💎';
            $tierColor = '#a78bfa';
            $tierGradient = 'linear-gradient(135deg, #a78bfa, #8b5cf6)';
            $tierBg = 'linear-gradient(135deg, #ede9fe, #ddd6fe)';
            $nextTier = null;
            $progress = 100;
        } elseif ($totalSpent >= 2000000) {
            $memberTier = 'Platinum';
            $tierIcon = '🏆';
            $tierColor = '#64748b';
            $tierGradient = 'linear-gradient(135deg, #94a3b8, #64748b)';
            $tierBg = 'linear-gradient(135deg, #f1f5f9, #e2e8f0)';
            $nextTier = 'Diamond';
            $nextAmount = 5000000;
            $progress = ($totalSpent / $nextAmount) * 100;
        } elseif ($totalSpent >= 1000000) {
            $memberTier = 'Gold';
            $tierIcon = '🥇';
            $tierColor = '#f59e0b';
            $tierGradient = 'linear-gradient(135deg, #fbbf24, #f59e0b)';
            $tierBg = 'linear-gradient(135deg, #fef3c7, #fde68a)';
            $nextTier = 'Platinum';
            $nextAmount = 2000000;
            $progress = ($totalSpent / $nextAmount) * 100;
        } elseif ($totalSpent >= 500000) {
            $memberTier = 'Silver';
            $tierIcon = '🥈';
            $tierColor = '#6b7280';
            $tierGradient = 'linear-gradient(135deg, #9ca3af, #6b7280)';
            $tierBg = 'linear-gradient(135deg, #f3f4f6, #e5e7eb)';
            $nextTier = 'Gold';
            $nextAmount = 1000000;
            $progress = ($totalSpent / $nextAmount) * 100;
        } else {
            $memberTier = 'Bronze';
            $tierIcon = '🥉';
            $tierColor = '#b45309';
            $tierGradient = 'linear-gradient(135deg, #d97706, #b45309)';
            $tierBg = 'linear-gradient(135deg, #fef3c7, #fde68a)';
            $nextTier = 'Silver';
            $nextAmount = 500000;
            $progress = ($totalSpent / $nextAmount) * 100;
        }
    @endphp
    
    <div class="stats-row" style="margin-bottom: 1.5rem;">
        <!-- Total Pesanan -->
        <div class="stat-card" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1px solid #a7f3d0;">
            <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">📦</div>
            <div class="stat-value" style="color: #059669;">{{ $stats['total_orders'] ?? 0 }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>
        
        <!-- Total Belanja -->
        <div class="stat-card" style="background: linear-gradient(135deg, #eff6ff, #dbeafe); border: 1px solid #93c5fd;">
            <div class="stat-icon">💰</div>
            <div class="stat-value" style="color: #2563eb; font-size: 1.25rem;">Rp {{ number_format($stats['total_spent'] ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Total Belanja</div>
        </div>
        
        <!-- Member Tier -->
        <div class="stat-card" style="background: {{ $tierBg }}; border: 1px solid {{ $tierColor }}40; position: relative; overflow: hidden;">
            <div style="position: absolute; top: -20px; right: -20px; font-size: 4rem; opacity: 0.15;">{{ $tierIcon }}</div>
            <div class="stat-icon" style="font-size: 2.5rem;">{{ $tierIcon }}</div>
            <div class="stat-value" style="background: {{ $tierGradient }}; -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 800;">{{ $memberTier }}</div>
            <div class="stat-label">Member Status</div>
            @if($nextTier)
            <div style="margin-top: 0.75rem;">
                <div style="display: flex; justify-content: space-between; font-size: 0.7rem; color: #666; margin-bottom: 0.25rem;">
                    <span>Progress ke {{ $nextTier }}</span>
                    <span>{{ number_format($progress, 0) }}%</span>
                </div>
                <div style="height: 6px; background: #e5e7eb; border-radius: 3px; overflow: hidden;">
                    <div style="height: 100%; width: {{ min($progress, 100) }}%; background: {{ $tierGradient }}; border-radius: 3px; transition: width 0.5s ease;"></div>
                </div>
                <div style="font-size: 0.7rem; color: #888; margin-top: 0.25rem;">
                    Belanja Rp {{ number_format($nextAmount - $totalSpent, 0, ',', '.') }} lagi
                </div>
            </div>
            @else
            <div style="margin-top: 0.5rem; font-size: 0.75rem; color: {{ $tierColor }}; font-weight: 600;">
                🎉 Tier Tertinggi!
            </div>
            @endif
        </div>
    </div>
    
    <!-- Member Benefits Info -->
    <div style="background: linear-gradient(135deg, #faf5ff, #f3e8ff); border: 1px solid #c4b5fd; border-radius: 16px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div style="font-size: 2rem;">🎁</div>
        <div style="flex: 1;">
            <div style="font-weight: 700; color: #7c3aed; font-size: 0.95rem;">Keuntungan Member {{ $memberTier }}</div>
            <div style="font-size: 0.8rem; color: #6b7280;">
                @if($memberTier === 'Diamond')
                    Free ongkir semua transaksi • Prioritas pengiriman • Cashback 5%
                @elseif($memberTier === 'Platinum')
                    Free ongkir minimal Rp 100rb • Cashback 3%
                @elseif($memberTier === 'Gold')
                    Free ongkir minimal Rp 150rb • Cashback 2%
                @elseif($memberTier === 'Silver')
                    Free ongkir minimal Rp 200rb • Cashback 1%
                @else
                    Tingkatkan belanja untuk unlock benefits lebih banyak!
                @endif
            </div>
        </div>
        <a href="{{ route('shop.index') }}" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; white-space: nowrap;">
            Belanja Sekarang
        </a>
    </div>
    @endif
    
    @if($user->isPedagang())
    <!-- Pedagang Layout: Store Left, Edit Right, Password Below -->
    <div class="profile-grid two-column">
        <!-- Left Column - Toko Saya -->
        <div class="profile-card">
            <div class="card-header">
                <span>🏪</span>
                <h3>Toko Saya</h3>
            </div>
            <div class="card-body">
                <div class="store-preview">
                    <div class="store-header">
                        <div class="store-logo">
                            @if($user->store_logo)
                                <img src="{{ asset('storage/' . $user->store_logo) }}" alt="Logo Toko">
                            @else
                                {{ strtoupper(substr($user->store_name ?? $user->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <div class="store-name">{{ $user->store_name ?? 'Belum diatur' }}</div>
                            <div class="store-desc">{{ $user->store_description ?? 'Tambahkan deskripsi toko Anda' }}</div>
                        </div>
                    </div>
                    <p class="text-small text-muted mb-0">
                        💡 Nama toko akan ditampilkan pada produk Anda di halaman belanja
                    </p>
                </div>
                
                <div class="form-section" style="margin-top: 1rem;">
                    <div class="section-title">Edit Informasi Toko</div>
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <div class="form-group">
                            <label class="form-label">Nama Toko <span class="text-danger">*</span></label>
                            <input type="text" name="store_name" class="form-input" value="{{ old('store_name', $user->store_name) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Deskripsi Toko</label>
                            <textarea name="store_description" class="form-input" rows="3">{{ old('store_description', $user->store_description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Logo Toko</label>
                            <input type="file" name="store_logo" class="form-input" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">💾 Simpan Toko</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Edit Profil -->
        <div class="profile-card">
            <div class="card-header">
                <span>✏️</span>
                <h3>Edit Profil</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="store_name" value="{{ $user->store_name }}">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-input" rows="3" placeholder="Alamat lengkap">{{ old('address', $user->address) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">💾 Simpan Profil</button>
                </form>
            </div>
        </div>
        
        <!-- Full Width - Password -->
        <div class="profile-card full-width">
            <div class="card-header">
                <span>🔒</span>
                <h3>Ubah Password</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf

                    <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Password Lama</label>
                            <input type="password" name="current_password" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-input" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline">🔐 Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
    @elseif($user->isKurir())
    <!-- Kurir Layout: Single Column -->
    <div class="profile-grid single-column">
        <div class="profile-card mb-2">
            <div class="card-header">
                <span>✏️</span>
                <h3>Edit Profil</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="address" class="form-input" value="{{ old('address', $user->address) }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">💾 Simpan Perubahan</button>
                </form>
            </div>
        </div>
        
        <div class="profile-card">
            <div class="card-header">
                <span>🔒</span>
                <h3>Ubah Password</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Password Lama</label>
                        <input type="password" name="current_password" class="form-input" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-input" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline" style="width: 100%;">🔐 Ubah Password</button>
                </form>
    </div>
    @elseif($user->isAdmin())
    <!-- Admin Layout: Simple Profile Management -->
    <div class="profile-grid two-column">
        <div class="profile-card">
            <div class="card-header">
                <span>✏️</span>
                <h3>Edit Profil Admin</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="address" class="form-input" value="{{ old('address', $user->address) }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">💾 Simpan</button>
                </form>
            </div>
        </div>
        
        <div class="profile-card">
            <div class="card-header">
                <span>🔒</span>
                <h3>Ubah Password</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Password Lama</label>
                        <input type="password" name="current_password" class="form-input" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi</label>
                            <input type="password" name="password_confirmation" class="form-input" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline" style="width: 100%;">🔐 Ubah</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Admin Quick Links -->
    <div class="profile-card" style="margin-top: 1rem;">
        <div class="card-header">
            <span>⚡</span>
            <h3>Menu Admin</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline" style="padding: 1rem; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; text-decoration: none;">
                    <span style="font-size: 1.5rem;">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline" style="padding: 1rem; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; text-decoration: none;">
                    <span style="font-size: 1.5rem;">👥</span>
                    <span>Users</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline" style="padding: 1rem; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; text-decoration: none;">
                    <span style="font-size: 1.5rem;">📦</span>
                    <span>Produk</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline" style="padding: 1rem; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; text-decoration: none;">
                    <span style="font-size: 1.5rem;">📋</span>
                    <span>Pesanan</span>
                </a>
            </div>
        </div>
    </div>
    @else
    <!-- Pembeli Layout: Premium Redesign -->
    
    <!-- Quick Actions Bar -->
    <div style="display: flex; gap: 0.75rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
        <a href="{{ route('shop.index') }}" style="flex: 1; min-width: 150px; background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 1rem; border-radius: 12px; text-decoration: none; display: flex; align-items: center; gap: 0.75rem; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(16,185,129,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <span style="font-size: 1.5rem;">🛒</span>
            <div>
                <div style="font-weight: 700; font-size: 0.95rem;">Mulai Belanja</div>
                <div style="font-size: 0.75rem; opacity: 0.9;">Jelajahi produk segar</div>
            </div>
        </a>
        <a href="{{ route('cart.index') }}" style="flex: 1; min-width: 150px; background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 1rem; border-radius: 12px; text-decoration: none; display: flex; align-items: center; gap: 0.75rem; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(245,158,11,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <span style="font-size: 1.5rem;">🧺</span>
            <div>
                <div style="font-weight: 700; font-size: 0.95rem;">Keranjang</div>
                <div style="font-size: 0.75rem; opacity: 0.9;">Lihat item tersimpan</div>
            </div>
        </a>
        <a href="{{ route('pembeli.orders.index') }}" style="flex: 1; min-width: 150px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 1rem; border-radius: 12px; text-decoration: none; display: flex; align-items: center; gap: 0.75rem; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 25px rgba(139,92,246,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <span style="font-size: 1.5rem;">📋</span>
            <div>
                <div style="font-weight: 700; font-size: 0.95rem;">Semua Pesanan</div>
                <div style="font-size: 0.75rem; opacity: 0.9;">Lihat riwayat lengkap</div>
            </div>
        </a>
    </div>
    
    <!-- Two Column Layout: Edit Left, Orders Right -->
    <div class="profile-grid">
        <div>
            <div class="profile-card mb-2">
                <div class="card-header">
                    <span>✏️</span>
                    <h3>Edit Profil</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="address" class="form-input" value="{{ old('address', $user->address) }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">💾 Simpan</button>
                    </form>
                </div>
            </div>
            
            <div class="profile-card">
                <div class="card-header">
                    <span>🔒</span>
                    <h3>Ubah Password</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Password Lama</label>
                            <input type="password" name="current_password" class="form-input" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Konfirmasi</label>
                                <input type="password" name="password_confirmation" class="form-input" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline" style="width: 100%;">🔐 Ubah</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="profile-card">
            <div class="card-header">
                <span>📦</span>
                <h3>Riwayat Pesanan</h3>
            </div>
            <div class="card-body">
                @if($orders->count() > 0)
                    @foreach($orders as $order)
                    <div class="order-item">
                        <div class="order-header">
                            <span class="order-id">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                            <span class="badge badge-{{ $order->status_badge }}">{{ $order->status_label }}</span>
                        </div>
                        <div class="order-meta">
                            <span>{{ $order->items->count() }} produk • {{ $order->created_at->format('d M Y') }}</span>
                            <span class="order-total">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                    {{ $orders->links() }}
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">📦</div>
                        <p>Belum ada pesanan</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-primary btn-sm">Mulai Belanja</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

