@extends('layouts.dashboard')

@section('title', 'Tambah Produk')
@section('panel_subtitle', 'Pedagang Panel')
@section('page_title', 'Tambah Produk')
@section('page_subtitle', 'Buat produk baru untuk toko Anda')

@section('header_actions')
<a href="{{ route('pedagang.products.index') }}" class="btn btn-secondary">← Kembali</a>
@endsection

@section('styles')
<style>
    .form-page-container {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 1.5rem;
    }
    
    .form-container {
        min-width: 0;
    }
    
    .form-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 25px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .form-card-header {
        padding: 1.25rem 1.75rem;
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }
    
    .form-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-card-body {
        padding: 1.75rem;
    }
    
    .form-section {
        margin-bottom: 1.5rem;
    }
    
    .form-section:last-child {
        margin-bottom: 0;
    }
    
    .form-section-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #11998e;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
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
    
    .form-input-modern::placeholder {
        color: #aaa;
    }
    
    .form-textarea-modern {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #fafafa;
        resize: vertical;
        min-height: 120px;
    }
    
    .form-textarea-modern:focus {
        outline: none;
        border-color: #11998e;
        background: white;
        box-shadow: 0 0 0 4px rgba(17, 153, 142, 0.1);
    }
    
    .form-select-modern {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #fafafa;
        cursor: pointer;
    }
    
    .form-select-modern:focus {
        outline: none;
        border-color: #11998e;
        background: white;
        box-shadow: 0 0 0 4px rgba(17, 153, 142, 0.1);
    }
    
    /* Image Upload */
    .image-upload-zone {
        border: 2px dashed #d0d0d0;
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        background: #fafafa;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .image-upload-zone:hover {
        border-color: #11998e;
        background: #f0faf9;
    }
    
    .image-upload-zone.has-image {
        border-style: solid;
        border-color: #11998e;
    }
    
    .upload-icon {
        font-size: 3rem;
        margin-bottom: 0.75rem;
    }
    
    .upload-text {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }
    
    .upload-hint {
        font-size: 0.8rem;
        color: #888;
    }
    
    #imagePreview img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 12px;
        margin-top: 1rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    /* Checkbox */
    .checkbox-modern {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 12px;
        cursor: pointer;
        border: 2px solid #bbf7d0;
        transition: all 0.3s ease;
    }
    
    .checkbox-modern:hover {
        border-color: #22c55e;
    }
    
    .checkbox-modern input {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }
    
    .checkbox-modern span {
        font-weight: 500;
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
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-cancel:hover {
        background: #e2e8f0;
        color: #475569;
    }
    
    .form-error {
        color: #f5576c;
        font-size: 0.8rem;
        margin-top: 0.5rem;
    }
    
    @media (max-width: 992px) {
        .form-page-container {
            grid-template-columns: 1fr;
        }
        .tips-sidebar {
            order: -1;
        }
    }
    
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
    
    /* Tips Sidebar */
    .tips-sidebar {
        position: sticky;
        top: 1rem;
        height: fit-content;
    }
    
    .tip-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 1rem;
    }
    
    .tip-card-header {
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }
    
    .tip-card-header.info {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
    }
    
    .tip-card-header.warning {
        background: linear-gradient(135deg, #ff9966, #ff5e62);
    }
    
    .tip-card-title {
        font-size: 0.9rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .tip-card-body {
        padding: 1.25rem;
    }
    
    .tip-item {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 0.875rem;
        align-items: flex-start;
    }
    
    .tip-item:last-child {
        margin-bottom: 0;
    }
    
    .tip-icon {
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .tip-text {
        font-size: 0.85rem;
        color: #555;
        line-height: 1.5;
    }
    
    .tip-text strong {
        color: #333;
    }
    
    .category-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .category-tag {
        padding: 0.35rem 0.75rem;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 20px;
        font-size: 0.75rem;
        color: #166534;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
<div class="form-page-container">
    <!-- Form Column -->
    <div class="form-container">
        <form method="POST" action="{{ route('pedagang.products.store') }}" enctype="multipart/form-data">
            @csrf
            
            <!-- Main Form Card -->
            <div class="form-card">
                <div class="form-card-header">
                    <h2 class="form-card-title"><span>📦</span> Informasi Produk</h2>
                </div>
                <div class="form-card-body">
                    <!-- Basic Info Section -->
                    <div class="form-section">
                        <div class="form-section-title"><span>📝</span> Informasi Dasar</div>
                        
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label class="form-label-modern">Nama Produk <span class="required">*</span></label>
                            <input type="text" name="name" class="form-input-modern" value="{{ old('name') }}" required 
                                   placeholder="Contoh: Bayam Segar (500g)">
                            @error('name') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label class="form-label-modern">Deskripsi <span class="required">*</span></label>
                            <textarea name="description" class="form-textarea-modern" rows="4" required 
                                      placeholder="Jelaskan produk Anda secara detail...">{{ old('description') }}</textarea>
                            @error('description') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <!-- Price & Stock Section -->
                    <div class="form-section">
                        <div class="form-section-title"><span>💰</span> Harga & Stok</div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label-modern">Harga (Rp) <span class="required">*</span></label>
                                <input type="number" name="price" class="form-input-modern" value="{{ old('price') }}" 
                                       required min="0" step="100" placeholder="15000">
                                @error('price') <div class="form-error">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label-modern">Stok <span class="required">*</span></label>
                                <input type="number" name="stock" class="form-input-modern" value="{{ old('stock', 0) }}" 
                                       required min="0" placeholder="50">
                                @error('stock') <div class="form-error">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Category Section -->
                    <div class="form-section">
                        <div class="form-section-title"><span>🏷️</span> Kategori</div>
                        
                        <div class="form-group">
                            <label class="form-label-modern">Pilih Kategori <span class="required">*</span></label>
                            <select name="category" class="form-select-modern" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories ?? [] as $cat)
                                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <!-- Image Upload Section -->
                    <div class="form-section">
                        <div class="form-section-title"><span>🖼️</span> Gambar Produk</div>
                        
                        <div class="image-upload-zone" onclick="document.getElementById('imageInput').click()">
                            <div class="upload-icon">📷</div>
                            <div class="upload-text">Klik untuk upload gambar</div>
                            <div class="upload-hint">Format: JPEG, PNG, JPG, GIF. Maks: 2MB</div>
                            <div id="imagePreview"></div>
                        </div>
                        <input type="file" id="imageInput" name="image" accept="image/*" 
                               onchange="previewImage(this)" style="display: none;">
                        @error('image') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                    
                    <!-- Status Section -->
                    <div class="form-section">
                        <label class="checkbox-modern">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span>✅ Aktifkan produk (tampilkan di toko)</span>
                        </label>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="form-actions">
                        <button type="submit" class="btn-save">
                            💾 Simpan Produk
                        </button>
                        <a href="{{ route('pedagang.products.index') }}" class="btn-cancel">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Tips Sidebar -->
    <div class="tips-sidebar">
        <!-- Tips Card -->
        <div class="tip-card">
            <div class="tip-card-header">
                <h3 class="tip-card-title">💡 Tips Produk Laris</h3>
            </div>
            <div class="tip-card-body">
                <div class="tip-item">
                    <span class="tip-icon">📸</span>
                    <span class="tip-text"><strong>Foto Menarik:</strong> Gunakan foto yang jelas dan terang. Produk dengan foto bagus lebih menarik pembeli.</span>
                </div>
                <div class="tip-item">
                    <span class="tip-icon">📝</span>
                    <span class="tip-text"><strong>Deskripsi Lengkap:</strong> Jelaskan keunggulan, berat, dan cara penyimpanan produk.</span>
                </div>
                <div class="tip-item">
                    <span class="tip-icon">💰</span>
                    <span class="tip-text"><strong>Harga Kompetitif:</strong> Bandingkan harga dengan penjual lain untuk harga yang tepat.</span>
                </div>
            </div>
        </div>
        
        <!-- Kategori Card -->
        <div class="tip-card">
            <div class="tip-card-header info">
                <h3 class="tip-card-title">🏷️ Kategori Tersedia</h3>
            </div>
            <div class="tip-card-body">
                <p style="font-size: 0.85rem; color: #666; margin-bottom: 0.75rem;">Pilih kategori yang tepat agar produk mudah ditemukan:</p>
                <div class="category-preview">
                    @foreach($categories ?? ['Sayuran', 'Buah', 'Daging', 'Bumbu', 'Lainnya'] as $cat)
                    <span class="category-tag">{{ $cat }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Warning Card -->
        <div class="tip-card">
            <div class="tip-card-header warning">
                <h3 class="tip-card-title">⚠️ Perhatian</h3>
            </div>
            <div class="tip-card-body">
                <div class="tip-item">
                    <span class="tip-icon">📦</span>
                    <span class="tip-text">Pastikan stok selalu diperbarui agar pelanggan tidak kecewa.</span>
                </div>
                <div class="tip-item">
                    <span class="tip-icon">🕒</span>
                    <span class="tip-text">Produk tidak aktif tidak akan muncul di toko.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const zone = document.querySelector('.image-upload-zone');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '">';
            zone.classList.add('has-image');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.innerHTML = '';
        zone.classList.remove('has-image');
    }
}
</script>
@endsection
