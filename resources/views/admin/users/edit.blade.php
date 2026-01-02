@extends('layouts.dashboard')

@section('title', 'Edit User - ' . $user->name)
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Edit User')
@section('page_subtitle', $user->name)

@section('header_actions')
<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">← Kembali</a>
@endsection

@section('styles')
<style>
    /* Hero Header */
    .edit-hero {
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .edit-hero.admin { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .edit-hero.pedagang { background: linear-gradient(135deg, #f97316, #ea580c); }
    .edit-hero.pembeli { background: linear-gradient(135deg, #22c55e, #16a34a); }
    .edit-hero.kurir { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    
    .edit-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 50%;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(30deg);
    }
    
    .edit-hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .hero-avatar {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 3px solid rgba(255,255,255,0.4);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    
    .hero-info { flex: 1; }
    
    .hero-title {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
    }
    
    .hero-subtitle {
        opacity: 0.9;
        font-size: 0.95rem;
    }
    
    .hero-badge {
        padding: 0.4rem 1rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
    }
    
    /* Main Grid */
    .edit-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 1.5rem;
    }
    
    /* Form Card */
    .form-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    
    .form-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .form-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .form-icon.personal { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
    .form-icon.security { background: linear-gradient(135deg, #fef3c7, #fde68a); }
    .form-icon.role { background: linear-gradient(135deg, #d1fae5, #a7f3d0); }
    
    .form-card-header h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        color: #1a1a2e;
    }
    
    .form-card-body {
        padding: 1.5rem;
    }
    
    /* Form Styles */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-group label {
        display: block;
        font-weight: 600;
        font-size: 0.9rem;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .label-hint {
        font-weight: 400;
        color: #9ca3af;
        font-size: 0.8rem;
    }
    
    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 0.85rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.2s;
        background: white;
    }
    
    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 80px;
    }
    
    .form-error {
        color: #dc2626;
        font-size: 0.8rem;
        margin-top: 0.35rem;
    }
    
    /* Checkbox Toggle */
    .toggle-group {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: linear-gradient(135deg, #f8fafc, #ffffff);
        border: 2px solid #e5e7eb;
        border-radius: 12px;
    }
    
    .toggle-switch {
        position: relative;
        width: 50px;
        height: 26px;
    }
    
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #d1d5db;
        transition: 0.4s;
        border-radius: 26px;
    }
    
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .toggle-switch input:checked + .toggle-slider {
        background: linear-gradient(135deg, #22c55e, #16a34a);
    }
    
    .toggle-switch input:checked + .toggle-slider:before {
        transform: translateX(24px);
    }
    
    .toggle-label {
        font-weight: 600;
        color: #374151;
    }
    
    .toggle-hint {
        font-size: 0.8rem;
        color: #9ca3af;
    }
    
    /* Role Select */
    .role-options {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }
    
    .role-option {
        position: relative;
    }
    
    .role-option input {
        position: absolute;
        opacity: 0;
    }
    
    .role-option label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        margin: 0 !important;
    }
    
    .role-option input:checked + label {
        border-color: #3b82f6;
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
    }
    
    .role-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .role-icon.pembeli { background: linear-gradient(135deg, #d1fae5, #a7f3d0); }
    .role-icon.pedagang { background: linear-gradient(135deg, #fef3c7, #fde68a); }
    .role-icon.kurir { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
    .role-icon.admin { background: linear-gradient(135deg, #fce7f3, #fbcfe8); }
    
    .role-name {
        font-weight: 600;
        color: #1a1a2e;
    }
    
    /* Buttons */
    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
    }
    
    .btn-submit {
        flex: 1;
        padding: 1rem;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.35);
    }
    
    .btn-cancel {
        padding: 1rem 2rem;
        background: #f3f4f6;
        color: #374151;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-cancel:hover {
        background: #e5e7eb;
    }
    
    /* Info Sidebar */
    .info-sidebar {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        height: fit-content;
    }
    
    .sidebar-header {
        padding: 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .sidebar-header h3 {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
    }
    
    .sidebar-body {
        padding: 1.5rem;
    }
    
    .info-item {
        display: flex;
        align-items: center;
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
    }
    
    .info-item-content { flex: 1; }
    
    .info-item-label {
        font-size: 0.75rem;
        color: #9ca3af;
        text-transform: uppercase;
    }
    
    .info-item-value {
        font-weight: 600;
        color: #1a1a2e;
    }
    
    /* Tips Box */
    .tips-box {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-radius: 12px;
        padding: 1.25rem;
        margin-top: 1rem;
    }
    
    .tips-title {
        font-weight: 700;
        color: #b45309;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .tips-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .tips-list li {
        font-size: 0.85rem;
        color: #92400e;
        padding: 0.35rem 0;
        padding-left: 1.25rem;
        position: relative;
    }
    
    .tips-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #16a34a;
    }

    @media (max-width: 768px) {
        .edit-grid { grid-template-columns: 1fr; }
        .form-row { grid-template-columns: 1fr; }
        .role-options { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<!-- Hero Header -->
<div class="edit-hero {{ $user->role }}">
    <div class="edit-hero-content">
        <div class="hero-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
        <div class="hero-info">
            <div class="hero-title">✏️ Edit User</div>
            <div class="hero-subtitle">{{ $user->name }} • {{ $user->email }}</div>
        </div>
        <span class="hero-badge">
            @switch($user->role)
                @case('admin') 👑 Admin @break
                @case('pedagang') 🏪 Pedagang @break
                @case('pembeli') 🛒 Pembeli @break
                @case('kurir') 🚚 Kurir @break
            @endswitch
        </span>
    </div>
</div>

<form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf @method('PUT')
    
    <div class="edit-grid">
        <!-- Main Form -->
        <div>
            <!-- Personal Info -->
            <div class="form-card" style="margin-bottom: 1rem;">
                <div class="form-card-header">
                    <div class="form-icon personal">👤</div>
                    <h3>Informasi Personal</h3>
                </div>
                <div class="form-card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Lengkap *</label>
                            <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" name="address" class="form-input" value="{{ old('address', $user->address) }}" placeholder="Alamat lengkap">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Security -->
            <div class="form-card" style="margin-bottom: 1rem;">
                <div class="form-card-header">
                    <div class="form-icon security">🔐</div>
                    <h3>Keamanan</h3>
                </div>
                <div class="form-card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Password Baru <span class="label-hint">(kosongkan jika tidak diubah)</span></label>
                            <input type="password" name="password" class="form-input" placeholder="••••••••">
                            @error('password') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-input" placeholder="••••••••">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Role & Status -->
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-icon role">🏷️</div>
                    <h3>Role & Status</h3>
                </div>
                <div class="form-card-body">
                    <div class="form-group">
                        <label style="margin-bottom: 1rem;">Pilih Role *</label>
                        <div class="role-options">
                            <div class="role-option">
                                <input type="radio" name="role" value="pembeli" id="role_pembeli" {{ old('role', $user->role) === 'pembeli' ? 'checked' : '' }}>
                                <label for="role_pembeli">
                                    <div class="role-icon pembeli">🛒</div>
                                    <span class="role-name">Pembeli</span>
                                </label>
                            </div>
                            <div class="role-option">
                                <input type="radio" name="role" value="pedagang" id="role_pedagang" {{ old('role', $user->role) === 'pedagang' ? 'checked' : '' }}>
                                <label for="role_pedagang">
                                    <div class="role-icon pedagang">🏪</div>
                                    <span class="role-name">Pedagang</span>
                                </label>
                            </div>
                            <div class="role-option">
                                <input type="radio" name="role" value="kurir" id="role_kurir" {{ old('role', $user->role) === 'kurir' ? 'checked' : '' }}>
                                <label for="role_kurir">
                                    <div class="role-icon kurir">🚚</div>
                                    <span class="role-name">Kurir</span>
                                </label>
                            </div>
                            <div class="role-option">
                                <input type="radio" name="role" value="admin" id="role_admin" {{ old('role', $user->role) === 'admin' ? 'checked' : '' }}>
                                <label for="role_admin">
                                    <div class="role-icon admin">👑</div>
                                    <span class="role-name">Admin</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="margin-bottom: 0.75rem;">Status Verifikasi</label>
                        <div class="toggle-group">
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_approved" value="1" {{ old('is_approved', $user->is_approved) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <div>
                                <div class="toggle-label">Disetujui / Terverifikasi</div>
                                <div class="toggle-hint">User dapat mengakses fitur sesuai role-nya</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="button-group">
                        <button type="submit" class="btn-submit">
                            💾 Update User
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn-cancel">Batal</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div>
            <div class="info-sidebar">
                <div class="sidebar-header">
                    <span>ℹ️</span>
                    <h3>Informasi Akun</h3>
                </div>
                <div class="sidebar-body">
                    <div class="info-item">
                        <div class="info-item-icon">🆔</div>
                        <div class="info-item-content">
                            <div class="info-item-label">ID User</div>
                            <div class="info-item-value">#{{ $user->id }}</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-icon">📅</div>
                        <div class="info-item-content">
                            <div class="info-item-label">Bergabung</div>
                            <div class="info-item-value">{{ $user->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-icon">🔄</div>
                        <div class="info-item-content">
                            <div class="info-item-label">Update Terakhir</div>
                            <div class="info-item-value">{{ $user->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-icon">✅</div>
                        <div class="info-item-content">
                            <div class="info-item-label">Status</div>
                            <div class="info-item-value">
                                @if($user->is_approved)
                                    <span style="color: #16a34a;">✓ Terverifikasi</span>
                                @else
                                    <span style="color: #ea580c;">⏳ Menunggu</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="tips-box">
                        <div class="tips-title">💡 Tips</div>
                        <ul class="tips-list">
                            <li>Kosongkan password jika tidak ingin mengubah</li>
                            <li>Email harus unik untuk setiap user</li>
                            <li>User yang disetujui dapat langsung login</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
