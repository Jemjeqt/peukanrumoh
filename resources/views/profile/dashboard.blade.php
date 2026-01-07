@extends('layouts.dashboard')

@section('title', 'Pengaturan Akun')
@section('panel_subtitle', ucfirst(auth()->user()->role) . ' Panel')
@section('page_title', 'Pengaturan Akun')
@section('page_subtitle', 'Kelola informasi profil dan keamanan akun Anda')

@section('content')
@if($errors->any())
<div class="alert alert-error mb-2">
    @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
</div>
@endif

<!-- Profile Header -->
<div class="card mb-2" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border: none; color: white;">
    <div class="card-body">
        <div class="d-flex align-center gap-2">
            @if($user->isPedagang() && $user->store_logo)
            <div style="width: 80px; height: 80px; border: 3px solid rgba(255,255,255,0.3); border-radius: 50%; overflow: hidden;">
                <img src="{{ asset('storage/' . $user->store_logo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            @else
            <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border: 3px solid rgba(255,255,255,0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            @endif
            <div>
                <h2 style="margin: 0; color: white; font-size: 1.5rem;">{{ $user->name }}</h2>
                <p style="margin: 0; opacity: 0.9;">{{ $user->email }}</p>
                <div class="d-flex gap-1" style="margin-top: 0.5rem;">
                    <span style="background: rgba(255,255,255,0.2); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">{{ ucfirst($user->role) }}</span>
                    @if($user->is_approved)
                    <span style="background: rgba(255,255,255,0.2); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">✓ Terverifikasi</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2" style="flex-wrap: wrap;">
    <!-- Edit Profile Card -->
    <div class="card" style="flex: 1; min-width: 300px;">
        <div class="card-header">
            <h3 class="card-title">✏️ Edit Profil</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                
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
                    <textarea name="address" class="form-input" rows="2">{{ old('address', $user->address) }}</textarea>
                </div>
                
                @if($user->isPedagang())
                <hr style="margin: 1rem 0; border: none; border-top: 1px solid var(--border);">
                <h4 style="font-size: 0.9rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-gray);">INFORMASI TOKO</h4>
                
                <div class="form-group">
                    <label class="form-label">Nama Toko</label>
                    <input type="text" name="store_name" class="form-input" value="{{ old('store_name', $user->store_name) }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Deskripsi Toko</label>
                    <textarea name="store_description" class="form-input" rows="2">{{ old('store_description', $user->store_description) }}</textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Logo Toko</label>
                    @if($user->store_logo)
                    <div style="margin-bottom: 0.5rem;">
                        <img src="{{ asset('storage/' . $user->store_logo) }}" alt="Logo" style="max-width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                    </div>
                    @endif
                    <input type="file" name="store_logo" class="form-input" accept="image/*">
                </div>
                @endif
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">💾 Simpan Perubahan</button>
            </form>
        </div>
    </div>
    
    <!-- Change Password Card -->
    <div class="card" style="flex: 1; min-width: 300px;">
        <div class="card-header">
            <h3 class="card-title">🔒 Ubah Password</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf

                
                <div class="form-group">
                    <label class="form-label">Password Lama</label>
                    <input type="password" name="current_password" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-input" required>
                    <small class="text-muted">Minimal 8 karakter</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>
                
                <button type="submit" class="btn btn-outline" style="width: 100%;">🔐 Ubah Password</button>
            </form>
        </div>
        
        <!-- Account Info -->
        <div class="card-header" style="border-top: 1px solid var(--border); border-bottom: none;">
            <h3 class="card-title">ℹ️ Informasi Akun</h3>
        </div>
        <div class="card-body" style="padding-top: 0;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                <div>
                    <div class="text-muted text-small">Role</div>
                    <div style="font-weight: 600;">{{ ucfirst($user->role) }}</div>
                </div>
                <div>
                    <div class="text-muted text-small">Status</div>
                    <div>
                        @if($user->is_approved)
                        <span class="badge badge-success">Aktif</span>
                        @else
                        <span class="badge badge-warning">Pending</span>
                        @endif
                    </div>
                </div>
                <div>
                    <div class="text-muted text-small">Bergabung</div>
                    <div style="font-weight: 600;">{{ $user->created_at->format('d M Y') }}</div>
                </div>
                <div>
                    <div class="text-muted text-small">Update Terakhir</div>
                    <div style="font-weight: 600;">{{ $user->updated_at->format('d M Y') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
