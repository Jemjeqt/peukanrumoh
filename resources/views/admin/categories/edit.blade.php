@extends('layouts.dashboard')

@section('title', 'Edit Kategori')
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Edit Kategori')
@section('page_subtitle', 'Ubah informasi kategori')

@section('header_actions')
<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">← Kembali</a>
@endsection

@section('styles')
<style>
    .form-container {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 1.5rem;
        max-width: 900px;
    }
    
    .form-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 25px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    
    .form-card-header {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        padding: 1.5rem;
    }
    
    .form-card-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-card-header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
        font-size: 0.85rem;
    }
    
    .form-card-body {
        padding: 1.75rem;
    }
    
    .form-section {
        margin-bottom: 1.5rem;
    }
    
    .form-label-modern {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .form-label-modern .required {
        color: #f5576c;
    }
    
    .form-input-modern {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #fafafa;
    }
    
    .form-input-modern:focus {
        outline: none;
        border-color: #11998e;
        background: white;
        box-shadow: 0 0 0 4px rgba(17, 153, 142, 0.1);
    }
    
    .form-hint {
        font-size: 0.8rem;
        color: #888;
        margin-top: 0.5rem;
    }
    
    /* Icon Input */
    .icon-input-wrapper {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .icon-preview {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        flex-shrink: 0;
    }
    
    .icon-input-field {
        flex: 1;
    }
    
    /* Toggle Switch */
    .toggle-container {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 12px;
        border: 2px solid #bbf7d0;
    }
    
    .toggle-switch {
        position: relative;
        width: 52px;
        height: 28px;
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
        background-color: #ccc;
        transition: 0.3s;
        border-radius: 28px;
    }
    
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
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
        color: #166534;
    }
    
    /* Buttons */
    .form-actions {
        display: flex;
        gap: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
        margin-top: 1.5rem;
    }
    
    .btn-save {
        padding: 0.875rem 2rem;
        background: linear-gradient(135deg, #11998e, #38ef7d);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(17, 153, 142, 0.3);
    }
    
    .btn-cancel {
        padding: 0.875rem 2rem;
        background: #f1f5f9;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        color: #64748b;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: #e2e8f0;
        color: #475569;
    }
    
    /* Info Card */
    .info-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 25px rgba(0,0,0,0.06);
        overflow: hidden;
        height: fit-content;
    }
    
    .info-header {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 1rem 1.25rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .info-body {
        padding: 1.25rem;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        color: #666;
        font-size: 0.85rem;
    }
    
    .info-value {
        font-weight: 600;
        color: #333;
    }
    
    /* Emoji Picker */
    .emoji-suggestions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.75rem;
    }
    
    .emoji-btn {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        background: white;
        font-size: 1.25rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .emoji-btn:hover {
        border-color: #11998e;
        background: #f0fdf4;
        transform: scale(1.1);
    }
    
    @media (max-width: 768px) {
        .form-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="form-container">
    <!-- Main Form -->
    <div class="form-card">
        <div class="form-card-header">
            <h2>✏️ Edit: {{ $category->name }}</h2>
            <p>Perbarui informasi kategori ini</p>
        </div>
        <div class="form-card-body">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf @method('PUT')
                
                <div class="form-section">
                    <label class="form-label-modern">Nama Kategori <span class="required">*</span></label>
                    <input type="text" name="name" class="form-input-modern" value="{{ old('name', $category->name) }}" required>
                    @error('name') <div class="form-error" style="color: #f5576c; font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</div> @enderror
                </div>
                
                <div class="form-section">
                    <label class="form-label-modern">Icon (Emoji)</label>
                    <div class="icon-input-wrapper">
                        <div class="icon-preview" id="iconPreview">{{ $category->icon ?? '📦' }}</div>
                        <div class="icon-input-field">
                            <input type="text" name="icon" id="iconInput" class="form-input-modern" value="{{ old('icon', $category->icon) }}" placeholder="🍹" maxlength="10">
                            <div class="form-hint">Klik emoji di bawah atau ketik sendiri</div>
                        </div>
                    </div>
                    <div class="emoji-suggestions">
                        <button type="button" class="emoji-btn" onclick="setEmoji('🥬')">🥬</button>
                        <button type="button" class="emoji-btn" onclick="setEmoji('🍎')">🍎</button>
                        <button type="button" class="emoji-btn" onclick="setEmoji('🧄')">🧄</button>
                        <button type="button" class="emoji-btn" onclick="setEmoji('🥚')">🥚</button>
                        <button type="button" class="emoji-btn" onclick="setEmoji('🍚')">🍚</button>
                        <button type="button" class="emoji-btn" onclick="setEmoji('🥩')">🥩</button>
                        <button type="button" class="emoji-btn" onclick="setEmoji('🐟')">🐟</button>
                        <button type="button" class="emoji-btn" onclick="setEmoji('🧴')">🧴</button>
                        <button type="button" class="emoji-btn" onclick="setEmoji('🍹')">🍹</button>
                        <button type="button" class="emoji-btn" onclick="setEmoji('🧊')">🧊</button>
                        <button type="button" class="emoji-btn" onclick="setEmoji('🍪')">🍪</button>
                        <button type="button" class="emoji-btn" onclick="setEmoji('🥛')">🥛</button>
                    </div>
                    @error('icon') <div class="form-error" style="color: #f5576c; font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</div> @enderror
                </div>
                
                <div class="form-section">
                    <div class="toggle-container">
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <div>
                            <div class="toggle-label">✅ Kategori Aktif</div>
                            <div style="font-size: 0.8rem; color: #666;">Kategori aktif akan muncul di pilihan produk</div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-save">💾 Update Kategori</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Info Sidebar -->
    <div class="info-card">
        <div class="info-header">📊 Info Kategori</div>
        <div class="info-body">
            <div class="info-item">
                <span class="info-label">ID Kategori</span>
                <span class="info-value">#{{ $category->id }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jumlah Produk</span>
                <span class="info-value">{{ $category->products()->count() }} produk</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status</span>
                <span class="info-value" style="color: {{ $category->is_active ? '#22c55e' : '#ef4444' }}">
                    {{ $category->is_active ? '✓ Aktif' : '✗ Nonaktif' }}
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Dibuat</span>
                <span class="info-value">{{ $category->created_at->format('d M Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Diupdate</span>
                <span class="info-value">{{ $category->updated_at->format('d M Y, H:i') }}</span>
            </div>
        </div>
    </div>
</div>

<script>
function setEmoji(emoji) {
    document.getElementById('iconInput').value = emoji;
    document.getElementById('iconPreview').textContent = emoji;
}

document.getElementById('iconInput').addEventListener('input', function() {
    const emoji = this.value || '📦';
    document.getElementById('iconPreview').textContent = emoji;
});
</script>
@endsection
