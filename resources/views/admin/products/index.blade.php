@extends('layouts.dashboard')

@section('title', 'Monitoring Produk')
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Monitoring Produk')
@section('page_subtitle', 'Kelola dan monitor produk di platform')

@section('content')
<!-- Filters -->
<div class="card mb-2">
    <div class="card-body">
        <form method="GET" class="d-flex gap-2 align-center" style="flex-wrap: wrap;">
            <input type="text" name="search" class="form-input" placeholder="Cari produk..." 
                   value="{{ request('search') }}" style="max-width: 250px;">
            <select name="category" class="form-select" style="max-width: 180px;">
                <option value="">Semua Kategori</option>
                @foreach($categories ?? [] as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary">🔍 Filter</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">Gambar</th>
                    <th>Produk</th>
                    <th>Pedagang</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        @if($product->image)
                        <img src="{{ $product->image_url ?? $product->image }}" alt="{{ $product->name }}" 
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                        @else
                        <div style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 6px; display: flex; align-items: center; justify-content: center;">📦</div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 500;">{{ $product->name }}</div>
                    </td>
                    <td>
                        <div class="text-small">{{ $product->pedagang->name ?? '-' }}</div>
                    </td>
                    <td><span class="badge badge-secondary">{{ $product->category }}</span></td>
                    <td style="font-weight: 600;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        @if($product->stock <= 0)
                        <span class="badge badge-danger">Habis</span>
                        @elseif($product->stock <= 5)
                        <span class="badge badge-warning">{{ $product->stock }}</span>
                        @else
                        <span class="badge badge-success">{{ $product->stock }}</span>
                        @endif
                    </td>
                    <td>
                        @if($product->is_active)
                        <span class="badge badge-success">Aktif</span>
                        @else
                        <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-secondary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted" style="padding: 3rem;">
                        Tidak ada produk ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $products->links() }}
@endsection
