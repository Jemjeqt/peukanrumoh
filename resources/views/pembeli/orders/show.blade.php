@extends('layouts.main')

@section('title', 'Detail Pesanan #' . str_pad($order->id, 6, '0', STR_PAD_LEFT))

@section('content')
<div class="mb-2">
    <a href="{{ route('pembeli.orders.index') }}" class="text-muted" style="text-decoration: none;">← Kembali ke Riwayat</a>
</div>

<div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 1.5rem;">
    <!-- Order Details -->
    <div>
        <div class="card mb-2">
            <div class="card-header">
                <h2 class="card-title">Pesanan #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h2>
                <span class="badge badge-{{ $order->status_badge }}">{{ $order->status_label }}</span>
            </div>
            <div class="card-body" style="padding: 0;">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            @if($order->status === 'completed')
                            <th>Ulasan</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        @php
                            $existingReview = $item->product->reviews->first();
                        @endphp
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    @if($item->product && $item->product->image)
                                    <img src="{{ $item->product->image_url ?? $item->product->image }}" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                    @else
                                    <div style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 6px; display: flex; align-items: center; justify-content: center;">📦</div>
                                    @endif
                                    <div>{{ $item->product_name }}</div>
                                </div>
                            </td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            @if($order->status === 'completed')
                            <td>
                                @if($existingReview)
                                    <div class="text-small">
                                        @for($i = 1; $i <= 5; $i++)
                                            {{ $i <= $existingReview->rating ? '⭐' : '☆' }}
                                        @endfor
                                    </div>
                                @else
                                    <button type="button" class="btn btn-sm btn-outline" 
                                            onclick="showReviewForm({{ $item->product_id }}, '{{ $item->product_name }}')">
                                        ✏️ Ulas
                                    </button>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="{{ $order->status === 'completed' ? 4 : 3 }}" style="text-align: right; font-weight: 600;">Total:</td>
                            <td style="font-weight: 700; color: var(--primary);">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Order Summary Card -->
        <div class="card mb-2">
            <div class="card-header">
                <h3 class="card-title">📋 Ringkasan Pesanan</h3>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <div style="font-size: 0.75rem; color: #888; text-transform: uppercase; margin-bottom: 0.25rem;">No. Pesanan</div>
                        <div style="font-weight: 700; font-size: 1.1rem; color: var(--primary);">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: #888; text-transform: uppercase; margin-bottom: 0.25rem;">Tanggal Pesan</div>
                        <div style="font-weight: 600;">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: #888; text-transform: uppercase; margin-bottom: 0.25rem;">Jumlah Item</div>
                        <div style="font-weight: 600;">{{ $order->items->sum('quantity') }} produk</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: #888; text-transform: uppercase; margin-bottom: 0.25rem;">Metode Pembayaran</div>
                        <div style="font-weight: 600;">{{ ucfirst($order->payment_method ?? 'Transfer Bank') }}</div>
                    </div>
                </div>
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #f0f0f0;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 1rem; font-weight: 600;">Total Pembayaran</span>
                        <span style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <!-- Payment Status Section -->
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #f0f0f0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
                        <div>
                            <div style="font-size: 0.75rem; color: #888; text-transform: uppercase; margin-bottom: 0.25rem;">Status Pembayaran</div>
                            @if($order->status === 'pending')
                                <span style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.4rem 0.75rem; background: #fef3c7; color: #92400e; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                    ⏳ Belum Dibayar
                                </span>
                            @else
                                <span style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.4rem 0.75rem; background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                    ✅ Sudah Lunas
                                </span>
                            @endif
                        </div>
                        @if($order->status === 'pending')
                            <a href="{{ route('checkout.pay-order', $order) }}" 
                               style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border-radius: 12px; font-weight: 700; font-size: 0.9rem; text-decoration: none; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3); transition: all 0.3s ease;">
                                💳 Bayar Sekarang
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Seller/Pedagang Info -->
        @php
            $sellers = $order->items->map(fn($item) => $item->product->user ?? null)->filter()->unique('id');
        @endphp
        @if($sellers->count() > 0)
        <div class="card mb-2">
            <div class="card-header">
                <h3 class="card-title">🏪 Informasi Pedagang</h3>
            </div>
            <div class="card-body" style="padding: 0;">
                @foreach($sellers as $seller)
                <div style="padding: 1rem; {{ !$loop->last ? 'border-bottom: 1px solid #f0f0f0;' : '' }}">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 45px; height: 45px; background: linear-gradient(135deg, var(--primary), #22c55e); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.1rem;">
                            {{ strtoupper(substr($seller->name, 0, 1)) }}
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; font-size: 1rem;">{{ $seller->name }}</div>
                            <div style="font-size: 0.8rem; color: #666;">
                                <span>📞 {{ $seller->phone ?? '-' }}</span>
                                <span style="margin-left: 0.75rem;">📍 {{ Str::limit($seller->address, 30) ?? '-' }}</span>
                            </div>
                        </div>
                        <span style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                            ✓ Terverifikasi
                        </span>
                    </div>
                    @php
                        $sellerProducts = $order->items->filter(fn($item) => $item->product->user_id === $seller->id);
                    @endphp
                    @if($sellerProducts->count() > 0)
                    <div style="margin-top: 0.75rem; padding-left: 3.5rem;">
                        <div style="font-size: 0.75rem; color: #888; margin-bottom: 0.35rem;">Produk dari toko ini:</div>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.35rem;">
                            @foreach($sellerProducts as $item)
                            <span style="background: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; color: #555;">
                                {{ Str::limit($item->product_name, 20) }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Shipping Info in Left Column -->
        <div class="card mb-2">
            <div class="card-header">
                <h3 class="card-title">📍 Informasi Pengiriman</h3>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <div style="font-size: 0.75rem; color: #888; text-transform: uppercase; margin-bottom: 0.25rem;">Penerima</div>
                        <div style="font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="font-size: 1.25rem;">👤</span>
                            {{ auth()->user()->name }}
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: #888; text-transform: uppercase; margin-bottom: 0.25rem;">Telepon</div>
                        <div style="font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="font-size: 1.25rem;">📞</span>
                            {{ $order->phone ?? '-' }}
                        </div>
                    </div>
                </div>
                <div style="margin-bottom: 1rem;">
                    <div style="font-size: 0.75rem; color: #888; text-transform: uppercase; margin-bottom: 0.25rem;">Alamat Lengkap</div>
                    <div style="font-weight: 500; background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 0.75rem; border-radius: 8px; line-height: 1.5; border-left: 3px solid var(--primary);">
                        📍 {{ $order->shipping_address ?? '-' }}
                    </div>
                </div>
                @if($order->kurir)
                <div style="padding-top: 0.75rem; border-top: 1px solid #f0f0f0;">
                    <div style="font-size: 0.75rem; color: #888; text-transform: uppercase; margin-bottom: 0.5rem;">Kurir Pengiriman</div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; background: linear-gradient(135deg, #eff6ff, #dbeafe); padding: 0.75rem; border-radius: 8px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem;">🚚</div>
                        <div>
                            <div style="font-weight: 700;">{{ $order->kurir->name }}</div>
                            <div style="font-size: 0.8rem; color: #666;">{{ $order->kurir->phone ?? 'Kurir Peukan Rumoh' }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Review Form Modal (Hidden by default) -->
        @if($order->status === 'completed')
        <div id="reviewFormContainer" style="display: none; margin-bottom: 1rem;">
            <!-- Review Header -->
            <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1rem; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 45px; height: 45px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">⭐</div>
                    <div>
                        <h3 style="margin: 0; font-size: 1.15rem; font-weight: 700;">Tulis Ulasan Produk</h3>
                        <p style="margin: 0.15rem 0 0; opacity: 0.9; font-size: 0.85rem;" id="reviewProductName"></p>
                    </div>
                </div>
                <button type="button" onclick="hideReviewForm()" style="background: rgba(255,255,255,0.2); border: none; color: white; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; font-size: 1rem;">✕</button>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 320px; gap: 1.25rem;">
                <!-- Form Section -->
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pembeli.orders.review', $order) }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" id="reviewProductId">
                            
                            <!-- Rating Section -->
                            <div style="margin-bottom: 1.25rem;">
                                <label style="font-weight: 600; font-size: 0.95rem; display: block; margin-bottom: 0.5rem;">Berapa rating untuk produk ini? *</label>
                                <div class="star-rating" style="display: flex; gap: 0.5rem; padding: 1rem; background: linear-gradient(135deg, #fffbeb, #fef3c7); border-radius: 12px; justify-content: center;">
                                    @for($i = 1; $i <= 5; $i++)
                                    <label style="cursor: pointer; font-size: 2.5rem; transition: transform 0.2s;" class="star-label" data-rating="{{ $i }}" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                        <input type="radio" name="rating" value="{{ $i }}" style="display: none;" {{ $i === 5 ? 'checked' : '' }}>
                                        <span class="star" style="color: {{ $i <= 5 ? '#ffc107' : '#ddd' }}; transition: color 0.2s; text-shadow: 0 2px 8px rgba(255,193,7,0.4);">★</span>
                                    </label>
                                    @endfor
                                </div>
                                <div id="ratingText" style="text-align: center; margin-top: 0.5rem; font-size: 0.9rem; color: #666;">Sangat Puas</div>
                            </div>
                            
                            <!-- Comment Section -->
                            <div style="margin-bottom: 1.25rem;">
                                <label style="font-weight: 600; font-size: 0.95rem; display: block; margin-bottom: 0.5rem;">Ceritakan pengalaman Anda (Opsional)</label>
                                <textarea name="comment" class="form-textarea" rows="4" placeholder="Contoh: Produk sangat segar, pengiriman cepat, kemasan rapi..." style="border-radius: 10px;"></textarea>
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="submit" style="width: 100%; padding: 0.9rem 1.5rem; background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none; border-radius: 10px; font-weight: 700; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                ⭐ Kirim Ulasan Saya
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Tips Sidebar -->
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <!-- Rating Guide -->
                    <div style="background: white; border-radius: 12px; padding: 1rem; border: 1px solid #e0e0e0;">
                        <div style="font-weight: 700; font-size: 0.95rem; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                            ⭐ Panduan Rating
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="color: #ffc107;">★★★★★</span>
                                <span style="color: #666;">Sangat Puas</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="color: #ffc107;">★★★★</span><span style="color: #ddd;">☆</span>
                                <span style="color: #666;">Puas</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="color: #ffc107;">★★★</span><span style="color: #ddd;">☆☆</span>
                                <span style="color: #666;">Cukup</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="color: #ffc107;">★★</span><span style="color: #ddd;">☆☆☆</span>
                                <span style="color: #666;">Kurang Puas</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="color: #ffc107;">★</span><span style="color: #ddd;">☆☆☆☆</span>
                                <span style="color: #666;">Sangat Kecewa</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tips -->
                    <div style="background: white; border-radius: 12px; padding: 1rem; border: 1px solid #e0e0e0;">
                        <div style="font-weight: 700; font-size: 0.95rem; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                            💡 Tips Ulasan yang Baik
                        </div>
                        <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.85rem;">
                            <li style="padding: 0.4rem 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: flex-start; gap: 0.5rem;">
                                <span style="color: var(--primary);">✓</span>
                                <span>Ceritakan kualitas produk</span>
                            </li>
                            <li style="padding: 0.4rem 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: flex-start; gap: 0.5rem;">
                                <span style="color: var(--primary);">✓</span>
                                <span>Bagaimana kondisi saat diterima</span>
                            </li>
                            <li style="padding: 0.4rem 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: flex-start; gap: 0.5rem;">
                                <span style="color: var(--primary);">✓</span>
                                <span>Kesesuaian dengan deskripsi</span>
                            </li>
                            <li style="padding: 0.4rem 0; display: flex; align-items: flex-start; gap: 0.5rem;">
                                <span style="color: var(--primary);">✓</span>
                                <span>Kecepatan pengiriman</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Info Card -->
                    <div style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1px solid #10b981; border-radius: 12px; padding: 1rem;">
                        <div style="font-weight: 700; color: #065f46; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; font-size: 0.9rem;">
                            🎁 Manfaat Memberikan Ulasan
                        </div>
                        <div style="font-size: 0.8rem; color: #047857;">
                            Ulasan Anda membantu pembeli lain menemukan produk terbaik dan membantu pedagang meningkatkan kualitas layanan.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Side Info -->
    <div>
        <!-- Order Status Timeline -->
        <div class="card mb-2">
            <div class="card-header">
                <h3 class="card-title">📋 Status Pesanan</h3>
            </div>
            <div class="card-body">
                <style>
                    .timeline { position: relative; padding-left: 30px; }
                    .timeline::before {
                        content: '';
                        position: absolute;
                        left: 10px;
                        top: 5px;
                        bottom: 5px;
                        width: 2px;
                        background: #e0e0e0;
                    }
                    .timeline-item {
                        position: relative;
                        padding-bottom: 1rem;
                        margin-bottom: 0.5rem;
                    }
                    .timeline-item:last-child { padding-bottom: 0; margin-bottom: 0; }
                    .timeline-dot {
                        position: absolute;
                        left: -25px;
                        top: 2px;
                        width: 16px;
                        height: 16px;
                        border-radius: 50%;
                        background: #e0e0e0;
                        border: 2px solid #fff;
                        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                    }
                    .timeline-item.completed .timeline-dot { background: var(--primary); }
                    .timeline-item.active .timeline-dot { background: var(--accent); animation: pulse 1.5s infinite; }
                    @keyframes pulse {
                        0%, 100% { transform: scale(1); }
                        50% { transform: scale(1.2); }
                    }
                    .timeline-title { font-weight: 600; font-size: 13px; }
                    .timeline-time { font-size: 11px; color: var(--text-light); }
                    .timeline-item.pending .timeline-title { color: #999; }
                </style>
                
                <div class="timeline">
                    <!-- 1. Pesanan Dibuat -->
                    <div class="timeline-item completed">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">📝 Pesanan Dibuat</div>
                        <div class="timeline-time">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    
                    <!-- 2. Pembayaran -->
                    <div class="timeline-item {{ in_array($order->status, ['paid', 'processing', 'ready_pickup', 'shipped', 'completed']) ? 'completed' : ($order->status === 'pending' ? 'active' : 'pending') }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">💳 Pembayaran {{ in_array($order->status, ['paid', 'processing', 'ready_pickup', 'shipped', 'completed']) ? 'Diterima' : 'Menunggu' }}</div>
                        @if(in_array($order->status, ['paid', 'processing', 'ready_pickup', 'shipped', 'completed']))
                        <div class="timeline-time">{{ $order->updated_at->format('d M Y, H:i') }}</div>
                        @endif
                    </div>
                    
                    <!-- 3. Diproses Pedagang -->
                    <div class="timeline-item {{ in_array($order->status, ['processing', 'ready_pickup', 'shipped', 'completed']) ? 'completed' : 'pending' }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">👨‍🍳 Diproses Pedagang</div>
                        @if(in_array($order->status, ['processing', 'ready_pickup', 'shipped', 'completed']))
                        <div class="timeline-time">Pesanan sedang disiapkan</div>
                        @endif
                    </div>
                    
                    <!-- 4. Siap Diambil Kurir -->
                    <div class="timeline-item {{ in_array($order->status, ['ready_pickup', 'shipped', 'completed']) ? 'completed' : ($order->status === 'processing' ? 'active' : 'pending') }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">📦 Siap Diambil Kurir</div>
                        @if($order->kurir)
                        <div class="timeline-time">Kurir: {{ $order->kurir->name }}</div>
                        @endif
                    </div>
                    
                    <!-- 5. Diambil Kurir -->
                    <div class="timeline-item {{ in_array($order->status, ['shipped', 'completed']) ? 'completed' : ($order->status === 'ready_pickup' ? 'active' : 'pending') }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">🚚 Diambil Kurir</div>
                        @if($order->picked_up_at)
                        <div class="timeline-time">{{ $order->picked_up_at->format('d M Y, H:i') }}</div>
                        @endif
                    </div>
                    
                    <!-- 6. Dalam Pengiriman -->
                    <div class="timeline-item {{ $order->status === 'completed' ? 'completed' : ($order->status === 'shipped' ? 'active' : 'pending') }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">🛵 Dalam Pengiriman</div>
                        @if($order->status === 'shipped')
                        <div class="timeline-time">Sedang diantar ke alamat Anda</div>
                        @endif
                    </div>
                    
                    <!-- 7. Selesai -->
                    <div class="timeline-item {{ $order->status === 'completed' && !$return ? 'completed' : ($order->status === 'completed' ? 'completed' : 'pending') }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">✅ Pesanan Diterima</div>
                        @if($order->delivered_at)
                        <div class="timeline-time">{{ $order->delivered_at->format('d M Y, H:i') }}</div>
                        @endif
                    </div>
                    
                    @if($return)
                    <!-- RETURN PROCESS TIMELINE -->
                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 2px dashed #e0e0e0;"></div>
                    <div class="timeline-title" style="font-size: 12px; color: var(--accent); margin-bottom: 0.5rem;">🔄 PROSES RETURN</div>
                    
                    <!-- R1. Return Diajukan -->
                    <div class="timeline-item completed">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">📝 Return Diajukan</div>
                        <div class="timeline-time">{{ $return->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    
                    <!-- R2. Menunggu Konfirmasi / Disetujui -->
                    <div class="timeline-item {{ in_array($return->status, ['pickup', 'delivering', 'received', 'completed']) ? 'completed' : ($return->status === 'pending' ? 'active' : ($return->status === 'rejected' ? 'completed' : 'pending')) }}">
                        <div class="timeline-dot"></div>
                        @if($return->status === 'rejected')
                        <div class="timeline-title" style="color: #dc3545;">❌ Return Ditolak</div>
                        <div class="timeline-time">{{ $return->admin_notes ?? 'Tidak ada catatan' }}</div>
                        @else
                        <div class="timeline-title">{{ in_array($return->status, ['pickup', 'delivering', 'received', 'completed']) ? '✅ Disetujui Pedagang' : '⏳ Menunggu Konfirmasi' }}</div>
                        @if($return->approved_at)
                        <div class="timeline-time">{{ $return->approved_at->format('d M Y, H:i') }}</div>
                        @endif
                        @endif
                    </div>
                    
                    @if($return->status !== 'rejected')
                    <!-- R3. Diambil Kurir -->
                    <div class="timeline-item {{ in_array($return->status, ['delivering', 'received', 'replacement_shipping', 'replacement_delivered', 'refund_sent', 'completed']) ? 'completed' : ($return->status === 'pickup' ? 'active' : 'pending') }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">📦 Diambil Kurir</div>
                        @if($return->picked_up_at)
                        <div class="timeline-time">{{ $return->picked_up_at->format('d M Y, H:i') }}</div>
                        @elseif($return->kurir)
                        <div class="timeline-time">Kurir: {{ $return->kurir->name }}</div>
                        @endif
                    </div>
                    
                    <!-- R4. Diantar ke Pedagang -->
                    <div class="timeline-item {{ in_array($return->status, ['received', 'replacement_shipping', 'replacement_delivered', 'refund_sent', 'completed']) ? 'completed' : ($return->status === 'delivering' ? 'active' : 'pending') }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">🚚 Diantar ke Pedagang</div>
                        @if($return->received_at)
                        <div class="timeline-time">{{ $return->received_at->format('d M Y, H:i') }}</div>
                        @endif
                    </div>
                    
                    @if($return->type === 'replacement')
                    <!-- REPLACEMENT FLOW -->
                    <!-- R5. Barang Pengganti Dikirim -->
                    <div class="timeline-item {{ in_array($return->status, ['replacement_delivered', 'completed']) ? 'completed' : ($return->status === 'replacement_shipping' ? 'active' : ($return->status === 'received' ? 'active' : 'pending')) }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">🎁 Barang Pengganti Dikirim</div>
                        @if($return->replacement_shipped_at)
                        <div class="timeline-time">{{ $return->replacement_shipped_at->format('d M Y, H:i') }}</div>
                        @if($return->replacementKurir)
                        <div class="timeline-time">Kurir: {{ $return->replacementKurir->name }}</div>
                        @endif
                        @elseif($return->status === 'received')
                        <div class="timeline-time text-muted">Menunggu pedagang kirim barang pengganti</div>
                        @endif
                    </div>
                    
                    <!-- R6. Konfirmasi Pembeli -->
                    <div class="timeline-item {{ $return->status === 'completed' ? 'completed' : ($return->status === 'replacement_delivered' ? 'active' : 'pending') }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">✅ Barang Diterima</div>
                        @if($return->status === 'replacement_delivered')
                        <div style="margin-top: 0.5rem;">
                            <form action="{{ route('pembeli.orders.confirm-replacement', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">✅ Konfirmasi Terima Barang</button>
                            </form>
                        </div>
                        @elseif($return->completed_at)
                        <div class="timeline-time">{{ $return->completed_at->format('d M Y, H:i') }}</div>
                        @endif
                    </div>
                    @else
                    <!-- REFUND FLOW -->
                    <!-- R5. Uang Dikirim -->
                    <div class="timeline-item {{ $return->status === 'completed' ? 'completed' : (in_array($return->status, ['refund_sent']) ? 'active' : ($return->status === 'received' ? 'active' : 'pending')) }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">💰 Uang Dikirim</div>
                        @if($return->refund_sent_at)
                        <div class="timeline-time">{{ $return->refund_sent_at->format('d M Y, H:i') }}</div>
                        @if($return->refund_proof)
                        <a href="{{ $return->refund_proof_url }}" target="_blank" class="text-small" style="color: var(--primary);">📷 Lihat Bukti Transfer</a>
                        @endif
                        @elseif($return->status === 'received')
                        <div class="timeline-time text-muted">Menunggu pedagang transfer uang</div>
                        @endif
                    </div>
                    
                    <!-- R6. Konfirmasi Pembeli -->
                    <div class="timeline-item {{ $return->status === 'completed' ? 'completed' : ($return->status === 'refund_sent' ? 'active' : 'pending') }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-title">✅ Uang Diterima</div>
                        @if($return->status === 'refund_sent')
                        <div style="margin-top: 0.5rem;">
                            <form action="{{ route('pembeli.orders.confirm-refund', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">✅ Konfirmasi Uang Diterima</button>
                            </form>
                        </div>
                        @elseif($return->completed_at)
                        <div class="timeline-time">{{ $return->completed_at->format('d M Y, H:i') }}</div>
                        @endif
                    </div>
                    @endif
                    @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Return Section (Only if order completed) -->
        @if($order->status === 'completed')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">🔄 Pengembalian Barang</h3>
            </div>
            <div class="card-body">
                @if($return)
                    <div class="alert alert-{{ $return->status_badge }} mb-1">
                        <strong>Status:</strong> {{ $return->status_label }}
                    </div>
                    <p class="text-small"><strong>Tipe:</strong> {{ $return->type_label }}</p>
                    <p class="text-small"><strong>Alasan:</strong> {{ $return->reason }}</p>
                    @if($return->evidence)
                    <p class="text-small"><strong>Bukti:</strong></p>
                    <img src="{{ $return->evidence_url }}" style="max-width: 100%; border-radius: 6px;">
                    @endif
                @else
                    <p class="text-muted text-small mb-1">Ada masalah dengan pesanan ini?</p>
                    <a href="{{ route('pembeli.orders.return', $order) }}" class="btn btn-outline" style="width: 100%;">
                        📝 Ajukan Pengembalian
                    </a>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<script>
const ratingLabels = {
    1: 'Sangat Kecewa 😞',
    2: 'Kurang Puas 😕',
    3: 'Cukup 😐',
    4: 'Puas 😊',
    5: 'Sangat Puas 🤩'
};

function showReviewForm(productId, productName) {
    const container = document.getElementById('reviewFormContainer');
    container.style.display = 'block';
    document.getElementById('reviewProductId').value = productId;
    document.getElementById('reviewProductName').textContent = productName;
    // Reset rating to 5 stars
    updateStars(5);
    updateRatingText(5);
    
    // Smooth scroll ke form ulasan
    setTimeout(() => {
        container.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 100);
}

function hideReviewForm() {
    document.getElementById('reviewFormContainer').style.display = 'none';
}

function updateStars(rating) {
    const labels = document.querySelectorAll('.star-label');
    labels.forEach((label, index) => {
        const star = label.querySelector('.star');
        if (index < rating) {
            star.style.color = '#ffc107'; // Gold
        } else {
            star.style.color = '#ddd'; // Gray
        }
    });
}

function updateRatingText(rating) {
    const ratingTextEl = document.getElementById('ratingText');
    if (ratingTextEl) {
        ratingTextEl.textContent = ratingLabels[rating] || '';
    }
}

// Initialize star rating functionality
document.addEventListener('DOMContentLoaded', function() {
    const starLabels = document.querySelectorAll('.star-label');
    
    starLabels.forEach(function(label) {
        // Click handler
        label.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            updateStars(rating);
            updateRatingText(rating);
        });
        
        // Hover handlers
        label.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            updateStars(rating);
            updateRatingText(rating);
        });
    });
    
    // Reset on mouse leave
    const starContainer = document.querySelector('.star-rating');
    if (starContainer) {
        starContainer.addEventListener('mouseleave', function() {
            const checkedRadio = document.querySelector('input[name="rating"]:checked');
            if (checkedRadio) {
                const rating = parseInt(checkedRadio.value);
                updateStars(rating);
                updateRatingText(rating);
            }
        });
    }
});
</script>
@endsection
