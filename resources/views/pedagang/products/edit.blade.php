@extends('layouts.dashboard')

@section('title', 'Edit Produk')

@section('content')
<div class="mb-2">
    <a href="{{ route('pedagang.products.index') }}" class="text-muted" style="text-decoration: none;">← Kembali ke Produk</a>
</div>

<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <h2 class="card-title">Edit Produk: {{ $product->name }}</h2>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('pedagang.products.update', $product) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Nama Produk *</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $product->name) }}" required>
                @error('name') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Deskripsi *</label>
                <textarea name="description" class="form-textarea" rows="3" required>{{ old('description', $product->description) }}</textarea>
                @error('description') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Harga (Rp) *</label>
                    <input type="number" name="price" class="form-input" value="{{ old('price', $product->price) }}" 
                           required min="0" step="100">
                    @error('price') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Stok *</label>
                    <input type="number" name="stock" class="form-input" value="{{ old('stock', $product->stock) }}" 
                           required min="0">
                    @error('stock') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Kategori *</label>
                <select name="category" class="form-select" required>
                    @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat }}" {{ old('category', $product->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Gambar Produk</label>
                @if($product->image)
                <div style="margin-bottom: 0.5rem;">
                    <img src="{{ $product->image_url ?? $product->image }}" alt="{{ $product->name }}" 
                         style="max-width: 150px; max-height: 150px; border-radius: 8px;">
                    <div class="text-muted text-small">Gambar saat ini</div>
                </div>
                @endif
                <input type="file" name="image" class="form-input" accept="image/*" onchange="previewImage(this)">
                <div class="text-muted text-small mt-1">Kosongkan jika tidak ingin mengubah gambar</div>
                <div id="imagePreview"></div>
                @error('image') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                    <span>Aktifkan produk</span>
                </label>
            </div>
            
            <div class="d-flex gap-1">
                <button type="submit" class="btn btn-primary">💾 Update Produk</button>
                <a href="{{ route('pedagang.products.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" style="max-width: 200px; max-height: 200px; border-radius: 8px; margin-top: 0.5rem;"><div class="text-muted text-small">Gambar baru</div>';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.innerHTML = '';
    }
}
</script>
@endsection
