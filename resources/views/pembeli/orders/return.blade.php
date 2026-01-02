@extends('layouts.main')

@section('title', 'Ajukan Pengembalian')

@section('content')
<style>
    .return-container {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 1.5rem;
        max-width: 1100px;
    }
    
    @media (max-width: 900px) {
        .return-container {
            grid-template-columns: 1fr;
        }
    }
    
    .return-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .return-header-icon {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }
    
    .return-header-text h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    .return-header-text p {
        margin: 0.25rem 0 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }
    
    .order-summary-card {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .order-summary-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    
    .order-number {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--primary);
    }
    
    .order-total {
        background: var(--primary);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .product-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .product-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem;
        background: white;
        border-radius: 8px;
    }
    
    .product-image {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        object-fit: cover;
        background: #f0f0f0;
    }
    
    .product-image-placeholder {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        background: linear-gradient(135deg, #e0e0e0, #f5f5f5);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .product-info {
        flex: 1;
    }
    
    .product-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: #333;
    }
    
    .product-meta {
        font-size: 0.8rem;
        color: #666;
    }
    
    .return-type-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .return-type-card {
        position: relative;
        padding: 1.25rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        cursor: pointer;
        text-align: center;
        transition: all 0.3s ease;
        background: white;
    }
    
    .return-type-card:hover {
        border-color: var(--primary);
        background: #f0fdf4;
    }
    
    .return-type-card.selected {
        border-color: var(--primary);
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
    }
    
    .return-type-card input {
        position: absolute;
        opacity: 0;
    }
    
    .return-type-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    .return-type-title {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }
    
    .return-type-desc {
        font-size: 0.8rem;
        color: #666;
    }
    
    .return-type-check {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        width: 20px;
        height: 20px;
        background: var(--primary);
        border-radius: 50%;
        color: white;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
    }
    
    .return-type-card.selected .return-type-check {
        display: flex;
    }
    
    .upload-zone {
        border: 2px dashed #d0d0d0;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: #fafafa;
    }
    
    .upload-zone:hover {
        border-color: var(--primary);
        background: #f0fdf4;
    }
    
    .upload-zone.has-file {
        border-style: solid;
        border-color: var(--primary);
        background: #f0fdf4;
    }
    
    .upload-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
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
    
    .evidence-preview {
        margin-top: 1rem;
        position: relative;
        display: inline-block;
    }
    
    .evidence-preview img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .remove-evidence {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 28px;
        height: 28px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(239,68,68,0.4);
    }
    
    .info-sidebar {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        border: 1px solid #e0e0e0;
    }
    
    .info-card-title {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .process-steps {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .process-step {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }
    
    .step-number {
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, var(--primary), #22c55e);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        flex-shrink: 0;
    }
    
    .step-content {
        flex: 1;
    }
    
    .step-title {
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .step-desc {
        font-size: 0.8rem;
        color: #666;
    }
    
    .tips-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .tips-list li {
        padding: 0.5rem 0;
        font-size: 0.85rem;
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .tips-list li:last-child {
        border-bottom: none;
    }
    
    .tips-list li::before {
        content: "✓";
        color: var(--primary);
        font-weight: 700;
    }
    
    .warning-card {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border: 1px solid #f59e0b;
        border-radius: 12px;
        padding: 1rem;
    }
    
    .warning-card-title {
        font-weight: 700;
        color: #92400e;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .warning-card-text {
        font-size: 0.85rem;
        color: #78350f;
    }
    
    .submit-btn {
        width: 100%;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, var(--primary), #22c55e);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
    }
    
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
    }
    
    .form-textarea {
        min-height: 100px;
        resize: vertical;
    }
</style>

<div class="mb-2">
    <a href="{{ route('pembeli.orders.show', $order) }}" class="text-muted" style="text-decoration: none;">← Kembali ke Detail Pesanan</a>
</div>

<!-- Header -->
<div class="return-header">
    <div class="return-header-icon">🔄</div>
    <div class="return-header-text">
        <h2>Ajukan Pengembalian</h2>
        <p>Isi formulir di bawah untuk mengajukan pengembalian barang</p>
    </div>
</div>

<div class="return-container">
    <!-- Main Form -->
    <div>
        <!-- Order Summary -->
        <div class="order-summary-card">
            <div class="order-summary-header">
                <span class="order-number">📦 Pesanan #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                <span class="order-total">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
            <div class="product-list">
                @foreach($order->items as $item)
                <div class="product-item">
                    @if($item->product && $item->product->image)
                    <img src="{{ $item->product->image_url ?? $item->product->image }}" class="product-image">
                    @else
                    <div class="product-image-placeholder">📦</div>
                    @endif
                    <div class="product-info">
                        <div class="product-name">{{ $item->product_name }}</div>
                        <div class="product-meta">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <form action="{{ route('pembeli.orders.return.store', $order) }}" method="POST" enctype="multipart/form-data" id="returnForm">
            @csrf
            
            <!-- Return Type Selection -->
            <div class="card mb-2">
                <div class="card-header">
                    <h3 class="card-title">1️⃣ Pilih Jenis Pengembalian</h3>
                </div>
                <div class="card-body">
                    <div class="return-type-options">
                        <label class="return-type-card" id="replacementCard">
                            <input type="radio" name="type" value="replacement" {{ old('type') === 'replacement' ? 'checked' : '' }}>
                            <span class="return-type-check">✓</span>
                            <div class="return-type-icon">🔄</div>
                            <div class="return-type-title">Ganti Barang</div>
                            <div class="return-type-desc">Minta dikirimkan barang pengganti yang baru</div>
                        </label>
                        <label class="return-type-card selected" id="refundCard">
                            <input type="radio" name="type" value="refund" checked {{ old('type', 'refund') === 'refund' ? 'checked' : '' }}>
                            <span class="return-type-check">✓</span>
                            <div class="return-type-icon">💰</div>
                            <div class="return-type-title">Refund Dana</div>
                            <div class="return-type-desc">Kembalikan uang ke rekening Anda</div>
                        </label>
                    </div>
                    @error('type') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>
            
            <!-- Reason -->
            <div class="card mb-2">
                <div class="card-header">
                    <h3 class="card-title">2️⃣ Jelaskan Alasan Pengembalian</h3>
                </div>
                <div class="card-body">
                    <textarea name="reason" class="form-textarea" rows="4" required 
                              placeholder="Contoh: Barang yang diterima rusak/busuk, tidak sesuai pesanan, jumlah kurang, dll...">{{ old('reason') }}</textarea>
                    @error('reason') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>
            
            <!-- Evidence Upload -->
            <div class="card mb-2">
                <div class="card-header">
                    <h3 class="card-title">3️⃣ Unggah Bukti Foto</h3>
                </div>
                <div class="card-body">
                    <input type="file" name="evidence" id="evidenceInput" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" 
                           onchange="previewEvidence(this)" style="display: none;">
                    <div class="upload-zone" id="uploadZone" onclick="document.getElementById('evidenceInput').click()">
                        <div class="upload-icon">📷</div>
                        <div class="upload-text">Klik untuk unggah foto bukti</div>
                        <div class="upload-hint">Format: JPEG, PNG, WEBP • Maks: 40MB</div>
                    </div>
                    <div id="evidencePreview"></div>
                    @error('evidence') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>
            
            <!-- Submit -->
            <button type="submit" class="submit-btn">
                📤 Ajukan Pengembalian Sekarang
            </button>
        </form>
    </div>
    
    <!-- Sidebar Info -->
    <div class="info-sidebar">
        <!-- Process Steps -->
        <div class="info-card">
            <div class="info-card-title">📋 Proses Pengembalian</div>
            <div class="process-steps">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <div class="step-title">Ajukan Pengajuan</div>
                        <div class="step-desc">Isi formulir dan kirim bukti</div>
                    </div>
                </div>
                <div class="process-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <div class="step-title">Review Pedagang</div>
                        <div class="step-desc">Pedagang akan meninjau pengajuan</div>
                    </div>
                </div>
                <div class="process-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <div class="step-title">Kurir Jemput</div>
                        <div class="step-desc">Barang akan dijemput kurir</div>
                    </div>
                </div>
                <div class="process-step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <div class="step-title">Proses Selesai</div>
                        <div class="step-desc">Ganti barang atau refund dana</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tips -->
        <div class="info-card">
            <div class="info-card-title">💡 Tips Agar Disetujui</div>
            <ul class="tips-list">
                <li>Foto kondisi barang dengan jelas</li>
                <li>Jelaskan masalah secara detail</li>
                <li>Ajukan dalam waktu 24 jam</li>
                <li>Sertakan foto kemasan jika rusak</li>
            </ul>
        </div>
        
        <!-- Warning -->
        <div class="warning-card">
            <div class="warning-card-title">⚠️ Perhatian</div>
            <div class="warning-card-text">
                Pengajuan akan ditinjau oleh pedagang dalam 1x24 jam. Pastikan informasi yang diberikan akurat dan jelas.
            </div>
        </div>
    </div>
</div>

<script>
// Return type selection
document.querySelectorAll('.return-type-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.return-type-card').forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
    });
});

// Check initial state from old input
document.addEventListener('DOMContentLoaded', function() {
    const checked = document.querySelector('input[name="type"]:checked');
    if (checked) {
        document.querySelectorAll('.return-type-card').forEach(c => c.classList.remove('selected'));
        checked.closest('.return-type-card').classList.add('selected');
    }
});

function previewEvidence(input) {
    const preview = document.getElementById('evidencePreview');
    const uploadZone = document.getElementById('uploadZone');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="evidence-preview">
                    <img src="${e.target.result}">
                    <button type="button" class="remove-evidence" onclick="removeEvidence()">✕</button>
                </div>
            `;
            uploadZone.classList.add('has-file');
            uploadZone.innerHTML = `
                <div class="upload-icon">✅</div>
                <div class="upload-text">Foto berhasil diunggah</div>
                <div class="upload-hint">Klik untuk mengganti foto</div>
            `;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeEvidence() {
    const input = document.getElementById('evidenceInput');
    const preview = document.getElementById('evidencePreview');
    const uploadZone = document.getElementById('uploadZone');
    
    input.value = '';
    preview.innerHTML = '';
    uploadZone.classList.remove('has-file');
    uploadZone.innerHTML = `
        <div class="upload-icon">📷</div>
        <div class="upload-text">Klik untuk unggah foto bukti</div>
        <div class="upload-hint">Format: JPEG, PNG, WEBP • Maks: 40MB</div>
    `;
}
</script>
@endsection
