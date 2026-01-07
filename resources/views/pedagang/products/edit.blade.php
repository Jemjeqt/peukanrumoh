@extends('layouts.dashboard')

@section('title', 'Edit Produk')
@section('panel_subtitle', 'Pedagang Panel')
@section('page_title', 'Edit Produk')
@section('page_subtitle', 'Ubah informasi produk Anda')

@section('header_actions')
<a href="{{ route('pedagang.products.index') }}" class="btn btn-secondary">← Kembali</a>
@endsection

@section('styles')
<style>
    .edit-container {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 1.5rem;
    }
    
    .edit-main-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    
    .edit-card-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 1.5rem;
    }
    
    .edit-card-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }
    
    .edit-card-header p {
        margin: 0.25rem 0 0;
        opacity: 0.9;
        font-size: 0.85rem;
    }
    
    .edit-card-body {
        padding: 1.5rem;
    }
    
    .form-section {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
    }
    
    .form-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .form-section-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-gray);
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
        gap: 1rem;
    }
    
    /* Sidebar Preview */
    .preview-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    
    .sidebar-column {
        position: sticky;
        top: 80px;
        height: fit-content;
    }
    
    .preview-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border);
        font-weight: 600;
        color: var(--text-dark);
    }
    
    .preview-body {
        padding: 1.25rem;
    }
    
    .preview-image {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
        border-radius: 12px;
        background: #f5f5f5;
        margin-bottom: 1rem;
    }
    
    .preview-placeholder {
        width: 100%;
        aspect-ratio: 1;
        background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        margin-bottom: 1rem;
    }
    
    .preview-name {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .preview-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.75rem;
    }
    
    .preview-meta {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .toggle-switch {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        cursor: pointer;
    }
    
    .toggle-switch input {
        width: 44px;
        height: 24px;
        appearance: none;
        background: #ccc;
        border-radius: 12px;
        position: relative;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .toggle-switch input:checked {
        background: var(--primary);
    }
    
    .toggle-switch input::before {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background: white;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: all 0.3s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .toggle-switch input:checked::before {
        left: 22px;
    }
    
    .submit-section {
        display: flex;
        gap: 1rem;
        padding-top: 1rem;
    }
    
    .submit-section .btn {
        flex: 1;
        padding: 0.875rem 1.5rem;
        font-size: 0.95rem;
    }
    
    @media (max-width: 992px) {
        .edit-container {
            grid-template-columns: 1fr;
        }
        
        .sidebar-column {
            position: static;
        }
    }
</style>
@endsection

@section('content')
<div class="edit-container">
    <!-- Main Form -->
    <div class="edit-main-card">
        <div class="edit-card-header">
            <h2>✏️ Edit Produk</h2>
            <p>Ubah informasi produk Anda</p>
        </div>
        <div class="edit-card-body">
            <form method="POST" action="{{ route('pedagang.products.update', $product) }}" enctype="multipart/form-data" id="editForm">
                @csrf @method('PUT')
                
                <!-- Basic Info Section -->
                <div class="form-section">
                    <div class="form-section-title">📦 Informasi Dasar</div>
                    
                    <div class="form-group">
                        <label class="form-label">Nama Produk *</label>
                        <input type="text" name="name" id="nameInput" class="form-input" value="{{ old('name', $product->name) }}" required>
                        @error('name') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Deskripsi *</label>
                        <textarea name="description" id="descInput" class="form-textarea" rows="3" required>{{ old('description', $product->description) }}</textarea>
                        @error('description') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                
                <!-- Pricing Section -->
                <div class="form-section">
                    <div class="form-section-title">💰 Harga & Stok</div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Harga (Rp) *</label>
                            <input type="number" name="price" id="priceInput" class="form-input" 
                                   value="{{ old('price', $product->price) }}" required min="0" step="100">
                            @error('price') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Stok *</label>
                            <input type="number" name="stock" id="stockInput" class="form-input" 
                                   value="{{ old('stock', $product->stock) }}" required min="0">
                            @error('stock') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Kategori *</label>
                        <select name="category" id="categoryInput" class="form-select" required>
                            @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $product->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Image Section -->
                <div class="form-section">
                    <div class="form-section-title">🖼️ Gambar Produk</div>
                    
                    @if($product->image)
                    <div style="margin-bottom: 1rem; display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 10px;">
                        <img src="{{ $product->image_url ?? asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;" id="currentImage">
                        <div>
                            <div style="font-weight: 500;">Gambar saat ini</div>
                            <div class="text-muted text-small">Upload gambar baru untuk mengganti</div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="form-group">
                        <input type="file" name="image" class="form-input" accept="image/*" onchange="previewImage(this)" id="imageInput">
                        <div class="text-muted text-small mt-1">Format: JPG, PNG, GIF. Maksimal 10MB</div>
                        @error('image') <div class="form-error">{{ $message }}</div> @enderror
                    </div>
                    <div id="imagePreview"></div>
                </div>
                
                <!-- Status Section -->
                <div class="form-section">
                    <div class="form-section-title">⚙️ Status Produk</div>
                    
                    <label class="toggle-switch">
                        <input type="checkbox" name="is_active" value="1" id="activeInput" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <div>
                            <div style="font-weight: 500;">Aktifkan Produk</div>
                            <div class="text-muted text-small">Produk aktif akan tampil di katalog</div>
                        </div>
                    </label>
                </div>
                
                <!-- Submit -->
                <div class="submit-section">
                    <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                    <a href="{{ route('pedagang.products.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Sidebar Column -->
    <div class="sidebar-column" style="display: flex; flex-direction: column; gap: 1rem;">
        <!-- Preview Card -->
        <div class="preview-card">
            <div class="preview-header">👁️ Preview Produk</div>
            <div class="preview-body">
                @if($product->image)
                <img src="{{ $product->image_url ?? asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="preview-image" id="previewImg">
                @else
                <div class="preview-placeholder" id="previewPlaceholder">📦</div>
                @endif
                
                <div class="preview-name" id="previewName">{{ $product->name }}</div>
                <div class="preview-price" id="previewPrice">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                
                <div class="preview-desc" id="previewDesc" style="font-size: 0.85rem; color: #666; margin: 0.75rem 0; line-height: 1.5; max-height: 60px; overflow: hidden;">{{ Str::limit($product->description, 100) }}</div>
                
                <div class="preview-meta">
                    <span class="badge badge-secondary" id="previewCategory">{{ $product->category }}</span>
                    <span class="badge badge-success" id="previewStock">Stok: {{ $product->stock }}</span>
                    <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-secondary' }}" id="previewStatus">
                        {{ $product->is_active ? '✓ Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Tips Card -->
        <div class="preview-card">
            <div class="preview-header" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">💡 Tips Produk Laris</div>
            <div class="preview-body" style="padding: 1rem;">
                <div style="display: flex; gap: 0.75rem; margin-bottom: 0.875rem; align-items: flex-start;">
                    <span style="font-size: 1.25rem;">📸</span>
                    <span style="font-size: 0.85rem; color: #555; line-height: 1.5;"><strong style="color: #333;">Foto Menarik:</strong> Gunakan foto yang jelas dan terang.</span>
                </div>
                <div style="display: flex; gap: 0.75rem; margin-bottom: 0.875rem; align-items: flex-start;">
                    <span style="font-size: 1.25rem;">📝</span>
                    <span style="font-size: 0.85rem; color: #555; line-height: 1.5;"><strong style="color: #333;">Deskripsi Lengkap:</strong> Jelaskan keunggulan produk.</span>
                </div>
                <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                    <span style="font-size: 1.25rem;">💰</span>
                    <span style="font-size: 0.85rem; color: #555; line-height: 1.5;"><strong style="color: #333;">Harga Kompetitif:</strong> Bandingkan dengan penjual lain.</span>
                </div>
            </div>
        </div>
        
        <!-- Kategori Card -->
        <div class="preview-card">
            <div class="preview-header" style="background: linear-gradient(135deg, #4facfe, #00f2fe); color: white;">🏷️ Kategori Tersedia</div>
            <div class="preview-body" style="padding: 1rem;">
                <p style="font-size: 0.85rem; color: #666; margin-bottom: 0.75rem;">Pilih kategori yang tepat agar produk mudah ditemukan:</p>
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                    @foreach($categories ?? [] as $cat)
                    <span style="padding: 0.35rem 0.75rem; background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-radius: 20px; font-size: 0.75rem; color: #166534; font-weight: 500;">{{ $cat }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Warning Card -->
        <div class="preview-card">
            <div class="preview-header" style="background: linear-gradient(135deg, #ff9966, #ff5e62); color: white;">⚠️ Perhatian</div>
            <div class="preview-body" style="padding: 1rem;">
                <div style="display: flex; gap: 0.75rem; margin-bottom: 0.875rem; align-items: flex-start;">
                    <span style="font-size: 1.25rem;">📦</span>
                    <span style="font-size: 0.85rem; color: #555; line-height: 1.5;">Pastikan stok selalu diperbarui agar pelanggan tidak kecewa.</span>
                </div>
                <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                    <span style="font-size: 1.25rem;">🕒</span>
                    <span style="font-size: 0.85rem; color: #555; line-height: 1.5;">Produk tidak aktif tidak akan muncul di toko.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Live preview updates
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('nameInput');
    const descInput = document.getElementById('descInput');
    const priceInput = document.getElementById('priceInput');
    const stockInput = document.getElementById('stockInput');
    const categoryInput = document.getElementById('categoryInput');
    const activeInput = document.getElementById('activeInput');
    
    const previewName = document.getElementById('previewName');
    const previewDesc = document.getElementById('previewDesc');
    const previewPrice = document.getElementById('previewPrice');
    const previewCategory = document.getElementById('previewCategory');
    const previewStock = document.getElementById('previewStock');
    const previewStatus = document.getElementById('previewStatus');
    
    if (nameInput && previewName) {
        nameInput.addEventListener('input', () => previewName.textContent = nameInput.value || 'Nama Produk');
    }
    
    if (descInput && previewDesc) {
        descInput.addEventListener('input', () => {
            const text = descInput.value || 'Deskripsi produk...';
            previewDesc.textContent = text.length > 100 ? text.substring(0, 100) + '...' : text;
        });
    }
    
    if (priceInput && previewPrice) {
        priceInput.addEventListener('input', () => {
            const price = parseInt(priceInput.value) || 0;
            previewPrice.textContent = 'Rp ' + price.toLocaleString('id-ID');
        });
    }
    
    if (categoryInput && previewCategory) {
        categoryInput.addEventListener('change', () => previewCategory.textContent = categoryInput.value);
    }
    
    if (stockInput && previewStock) {
        stockInput.addEventListener('input', () => previewStock.textContent = 'Stok: ' + (stockInput.value || 0));
    }
    
    if (activeInput && previewStatus) {
        activeInput.addEventListener('change', () => {
            if (activeInput.checked) {
                previewStatus.textContent = '✓ Aktif';
                previewStatus.className = 'badge badge-success';
            } else {
                previewStatus.textContent = 'Nonaktif';
                previewStatus.className = 'badge badge-secondary';
            }
        });
    }
});

function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const previewPlaceholder = document.getElementById('previewPlaceholder');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<div style="margin-top: 0.75rem; padding: 1rem; background: #e8f5e9; border-radius: 10px; display: flex; align-items: center; gap: 1rem;"><img src="' + e.target.result + '" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;"><div><div style="font-weight: 500; color: var(--primary);">Gambar baru dipilih</div><div class="text-muted text-small">Akan tersimpan saat Anda klik Simpan</div></div></div>';
            
            // Update preview sidebar
            if (previewImg) {
                previewImg.src = e.target.result;
            } else if (previewPlaceholder) {
                previewPlaceholder.outerHTML = '<img src="' + e.target.result + '" class="preview-image" id="previewImg">';
            }
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.innerHTML = '';
    }
}
</script>
@endsection
