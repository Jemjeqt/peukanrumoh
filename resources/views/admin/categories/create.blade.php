@extends('layouts.dashboard')

@section('title', 'Tambah Kategori')
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Tambah Kategori')
@section('page_subtitle', 'Buat kategori baru untuk produk')

@section('header_actions')
<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">← Kembali</a>
@endsection

@section('styles')
<style>
    .form-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 25px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    
    .form-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .form-card-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    .form-card-header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }
    
    .form-card-body {
        padding: 2rem;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
    
    .form-section {
        margin-bottom: 1.5rem;
    }
    
    .form-section.full-width {
        grid-column: span 2;
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
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
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
        width: 70px;
        height: 70px;
        border-radius: 16px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .icon-input-field {
        flex: 1;
    }
    
    /* Emoji Grid */
    .emoji-section {
        background: linear-gradient(135deg, #f8f9ff, #f0f4ff);
        border-radius: 16px;
        padding: 1.5rem;
        border: 2px solid #e8ecff;
    }
    
    .emoji-section-title {
        font-weight: 600;
        color: #4c4f69;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }
    
    .emoji-grid {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 0.75rem;
    }
    
    .emoji-btn {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        background: white;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .emoji-btn:hover {
        border-color: #667eea;
        background: #f5f3ff;
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
    }
    
    .emoji-btn.selected {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea, #764ba2);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    /* Toggle Switch */
    .toggle-container {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 16px;
        border: 2px solid #bbf7d0;
    }
    
    .toggle-switch {
        position: relative;
        width: 56px;
        height: 30px;
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
        border-radius: 30px;
    }
    
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 24px;
        width: 24px;
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
        transform: translateX(26px);
    }
    
    .toggle-label {
        font-weight: 700;
        font-size: 1rem;
        color: #166534;
    }
    
    /* Tips Box */
    .tips-box {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        border: 2px solid #fcd34d;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .tips-icon {
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .tips-content h4 {
        margin: 0 0 0.5rem;
        color: #92400e;
        font-size: 0.95rem;
    }
    
    .tips-content ul {
        margin: 0;
        padding-left: 1.25rem;
        color: #a16207;
        font-size: 0.85rem;
        line-height: 1.6;
    }
    
    /* Buttons */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        padding-top: 1.5rem;
        border-top: 2px solid #f0f0f0;
        margin-top: 2rem;
    }
    
    .btn-save {
        padding: 1rem 3rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        border-radius: 14px;
        color: white;
        font-weight: 700;
        font-size: 1.05rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.35);
    }
    
    .btn-cancel {
        padding: 1rem 2.5rem;
        background: #f1f5f9;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        color: #64748b;
        font-weight: 600;
        font-size: 1.05rem;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: #e2e8f0;
        color: #475569;
    }
    
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-section.full-width {
            grid-column: span 1;
        }
        
        .emoji-grid {
            grid-template-columns: repeat(6, 1fr);
        }
    }
</style>
@endsection

@section('content')
<div class="form-card">
    <div class="form-card-header">
        <h2>🏷️ Tambah Kategori Baru</h2>
        <p>Kategori membantu mengelompokkan produk agar mudah ditemukan</p>
    </div>
    <div class="form-card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="form-grid">
                <!-- Left Column: Name & Icon -->
                <div>
                    <div class="form-section">
                        <label class="form-label-modern">Nama Kategori <span class="required">*</span></label>
                        <input type="text" name="name" class="form-input-modern" value="{{ old('name') }}" required placeholder="Contoh: Minuman, Frozen Food, Snack, dll">
                        @error('name') <div class="form-error" style="color: #f5576c; font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</div> @enderror
                        <div class="form-hint">Gunakan nama yang singkat dan mudah dipahami</div>
                    </div>
                    
                    <div class="form-section">
                        <label class="form-label-modern">Icon Kategori</label>
                        <div class="icon-input-wrapper">
                            <div class="icon-preview" id="iconPreview">📦</div>
                            <div class="icon-input-field">
                                <input type="text" name="icon" id="iconInput" class="form-input-modern" value="{{ old('icon', '📦') }}" placeholder="🍹" maxlength="10">
                                <div class="form-hint">Icon akan ditampilkan di sidebar dan daftar kategori</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <div class="toggle-container">
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <div>
                                <div class="toggle-label">✅ Aktifkan Kategori</div>
                                <div style="font-size: 0.85rem; color: #666; margin-top: 0.25rem;">Kategori aktif akan muncul di form tambah produk</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Emoji Picker & Tips -->
                <div>
                <div class="emoji-section">
                        <div class="emoji-section-title">🎨 Pilih Icon Emoji</div>
                        <div class="emoji-grid">
                            <!-- Sayuran -->
                            <button type="button" class="emoji-btn" onclick="setEmoji('🥬')">🥬</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🥦')">🥦</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🥕')">🥕</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🌽')">🌽</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍆')">🍆</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🧅')">🧅</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🧄')">🧄</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🥒')">🥒</button>
                            <!-- Buah -->
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍎')">🍎</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍊')">🍊</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍋')">🍋</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍌')">🍌</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍇')">🍇</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍓')">🍓</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🥭')">🥭</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍉')">🍉</button>
                            <!-- Protein & Daging -->
                            <button type="button" class="emoji-btn" onclick="setEmoji('🥚')">🥚</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🥩')">🥩</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍗')">🍗</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍖')">🍖</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🐟')">🐟</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🦐')">🦐</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🦀')">🦀</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🐔')">🐔</button>
                            <!-- Sembako & Dairy -->
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍚')">🍚</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍞')">🍞</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🥛')">🥛</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🧈')">🧈</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🧀')">🧀</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🥜')">🥜</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🌾')">🌾</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🫘')">🫘</button>
                            <!-- Minuman -->
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍹')">🍹</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🥤')">🥤</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('☕')">☕</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍵')">🍵</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🧃')">🧃</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍺')">🍺</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🧋')">🧋</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('💧')">💧</button>
                            <!-- Snack & Lainnya -->
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍪')">🍪</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍩')">🍩</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🍫')">🍫</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🧊')">🧊</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🧴')">🧴</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🧹')">🧹</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('🛒')">🛒</button>
                            <button type="button" class="emoji-btn" onclick="setEmoji('📦')">📦</button>
                        </div>
                    </div>
                    
                    <div class="tips-box" style="margin-top: 1.5rem;">
                        <span class="tips-icon">💡</span>
                        <div class="tips-content">
                            <h4>Tips Membuat Kategori</h4>
                            <ul>
                                <li>Nama singkat dan jelas (maks 20 karakter)</li>
                                <li>Pilih emoji yang merepresentasikan kategori</li>
                                <li>Hindari kategori yang terlalu spesifik</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-save">💾 Simpan Kategori</button>
                <a href="{{ route('admin.categories.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function setEmoji(emoji) {
    document.getElementById('iconInput').value = emoji;
    document.getElementById('iconPreview').textContent = emoji;
    
    // Remove selected class from all buttons
    document.querySelectorAll('.emoji-btn').forEach(btn => btn.classList.remove('selected'));
    // Add selected class to clicked button
    event.target.classList.add('selected');
}

document.getElementById('iconInput').addEventListener('input', function() {
    const emoji = this.value || '📦';
    document.getElementById('iconPreview').textContent = emoji;
});
</script>
@endsection
