@extends('layouts.dashboard')

@section('title', 'Tambah User Baru')
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Tambah User')
@section('page_subtitle', 'Buat akun user baru')

@section('header_actions')
<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">← Kembali</a>
@endsection

@section('styles')
<style>
    /* Hero Header */
    .create-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .create-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 50%;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(30deg);
    }
    
    .create-hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .hero-icon {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 3px solid rgba(255,255,255,0.4);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
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
    
    /* Main Grid */
    .create-grid {
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
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
    
    /* Toggle Switch */
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
    
    /* Role Options */
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
        border-color: #667eea;
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
        background: linear-gradient(135deg, #667eea, #764ba2);
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
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.35);
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
    
    /* Role Info */
    .role-info-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        background: #f9fafb;
        border-radius: 12px;
        margin-bottom: 0.75rem;
    }
    
    .role-info-item:last-child { margin-bottom: 0; }
    
    .role-info-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .role-info-content { flex: 1; }
    
    .role-info-name {
        font-weight: 700;
        color: #1a1a2e;
        font-size: 0.95rem;
    }
    
    .role-info-desc {
        font-size: 0.8rem;
        color: #6b7280;
    }
    
    /* Tips Box */
    .tips-box {
        background: linear-gradient(135deg, #ede9fe, #ddd6fe);
        border-radius: 12px;
        padding: 1.25rem;
        margin-top: 1rem;
    }
    
    .tips-title {
        font-weight: 700;
        color: #6d28d9;
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
        color: #5b21b6;
        padding: 0.35rem 0;
        padding-left: 1.25rem;
        position: relative;
    }
    
    .tips-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #22c55e;
    }

    @media (max-width: 768px) {
        .create-grid { grid-template-columns: 1fr; }
        .form-row { grid-template-columns: 1fr; }
        .role-options { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<!-- Hero Header -->
<div class="create-hero">
    <div class="create-hero-content">
        <div class="hero-icon">👤</div>
        <div class="hero-info">
            <div class="hero-title">➕ Tambah User Baru</div>
            <div class="hero-subtitle">Buat akun baru untuk admin, pedagang, kurir, atau pembeli</div>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf
    
    <div class="create-grid">
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
                            <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                            @error('name') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="email@example.com" required>
                            @error('email') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" name="phone" class="form-input" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" name="address" class="form-input" value="{{ old('address') }}" placeholder="Alamat lengkap">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Security -->
            <div class="form-card" style="margin-bottom: 1rem;">
                <div class="form-card-header">
                    <div class="form-icon security">🔐</div>
                    <h3>Password</h3>
                </div>
                <div class="form-card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Password *</label>
                            <input type="password" name="password" class="form-input" placeholder="Minimal 8 karakter" required>
                            @error('password') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password *</label>
                            <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password" required>
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
                                <input type="radio" name="role" value="pembeli" id="role_pembeli" {{ old('role', 'pembeli') === 'pembeli' ? 'checked' : '' }}>
                                <label for="role_pembeli">
                                    <div class="role-icon pembeli">🛒</div>
                                    <span class="role-name">Pembeli</span>
                                </label>
                            </div>
                            <div class="role-option">
                                <input type="radio" name="role" value="pedagang" id="role_pedagang" {{ old('role') === 'pedagang' ? 'checked' : '' }}>
                                <label for="role_pedagang">
                                    <div class="role-icon pedagang">🏪</div>
                                    <span class="role-name">Pedagang</span>
                                </label>
                            </div>
                            <div class="role-option">
                                <input type="radio" name="role" value="kurir" id="role_kurir" {{ old('role') === 'kurir' ? 'checked' : '' }}>
                                <label for="role_kurir">
                                    <div class="role-icon kurir">🚚</div>
                                    <span class="role-name">Kurir</span>
                                </label>
                            </div>
                            <div class="role-option">
                                <input type="radio" name="role" value="admin" id="role_admin" {{ old('role') === 'admin' ? 'checked' : '' }}>
                                <label for="role_admin">
                                    <div class="role-icon admin">👑</div>
                                    <span class="role-name">Admin</span>
                                </label>
                            </div>
                        </div>
                        @error('role') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="margin-bottom: 0.75rem;">Status Verifikasi</label>
                        <div class="toggle-group">
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_approved" value="1" {{ old('is_approved', true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <div>
                                <div class="toggle-label">Langsung Disetujui</div>
                                <div class="toggle-hint">User dapat langsung login setelah dibuat</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="button-group">
                        <button type="submit" class="btn-submit">
                            ➕ Tambah User
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
                    <span>📋</span>
                    <h3>Panduan Role</h3>
                </div>
                <div class="sidebar-body">
                    <div class="role-info-item">
                        <div class="role-info-icon" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0);">🛒</div>
                        <div class="role-info-content">
                            <div class="role-info-name">Pembeli</div>
                            <div class="role-info-desc">Dapat berbelanja dan melakukan pesanan</div>
                        </div>
                    </div>
                    <div class="role-info-item">
                        <div class="role-info-icon" style="background: linear-gradient(135deg, #fef3c7, #fde68a);">🏪</div>
                        <div class="role-info-content">
                            <div class="role-info-name">Pedagang</div>
                            <div class="role-info-desc">Dapat mengelola produk dan menerima pesanan</div>
                        </div>
                    </div>
                    <div class="role-info-item">
                        <div class="role-info-icon" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe);">🚚</div>
                        <div class="role-info-content">
                            <div class="role-info-name">Kurir</div>
                            <div class="role-info-desc">Dapat mengambil dan mengantarkan pesanan</div>
                        </div>
                    </div>
                    <div class="role-info-item">
                        <div class="role-info-icon" style="background: linear-gradient(135deg, #fce7f3, #fbcfe8);">👑</div>
                        <div class="role-info-content">
                            <div class="role-info-name">Admin</div>
                            <div class="role-info-desc">Akses penuh ke seluruh sistem</div>
                        </div>
                    </div>
                    
                    <div class="tips-box">
                        <div class="tips-title">💡 Tips</div>
                        <ul class="tips-list">
                            <li>Password minimal 8 karakter</li>
                            <li>Email harus unik untuk setiap user</li>
                            <li>Aktifkan "Langsung Disetujui" agar user bisa login</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
