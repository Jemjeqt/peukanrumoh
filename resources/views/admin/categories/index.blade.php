@extends('layouts.dashboard')

@section('title', 'Kelola Kategori')
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Kelola Kategori')
@section('page_subtitle', 'Tambah, edit, atau hapus kategori produk')

@section('header_actions')
<a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
@endsection

@section('styles')
<style>
    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
    }
    
    .category-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.2s;
    }
    
    .category-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .category-card.inactive {
        opacity: 0.6;
        background: #f8f8f8;
    }
    
    .category-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .category-info {
        flex: 1;
        min-width: 0;
    }
    
    .category-name {
        font-weight: 600;
        font-size: 1rem;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }
    
    .category-meta {
        font-size: 0.8rem;
        color: var(--text-gray);
    }
    
    .category-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-icon.edit {
        background: #e3f2fd;
        color: #1976d2;
    }
    
    .btn-icon.edit:hover {
        background: #1976d2;
        color: white;
    }
    
    .btn-icon.toggle {
        background: #fff3e0;
        color: #f57c00;
    }
    
    .btn-icon.toggle:hover {
        background: #f57c00;
        color: white;
    }
    
    .btn-icon.delete {
        background: #ffebee;
        color: #d32f2f;
    }
    
    .btn-icon.delete:hover {
        background: #d32f2f;
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--text-gray);
    }
    
    .empty-state .icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
@if($categories->count() > 0)
<div class="category-grid">
    @foreach($categories as $category)
    <div class="category-card {{ !$category->is_active ? 'inactive' : '' }}">
        <div class="category-icon">{{ $category->icon ?? '📦' }}</div>
        <div class="category-info">
            <div class="category-name">{{ $category->name }}</div>
            <div class="category-meta">
                {{ $category->products_count }} produk
                @if(!$category->is_active)
                    • <span style="color: #f57c00;">Nonaktif</span>
                @endif
            </div>
        </div>
        <div class="category-actions">
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn-icon edit" title="Edit">✏️</a>
            <form action="{{ route('admin.categories.toggle', $category) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-icon toggle" title="{{ $category->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                    {{ $category->is_active ? '🔒' : '🔓' }}
                </button>
            </form>
            @if($category->products_count == 0)
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus kategori ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-icon delete" title="Hapus">🗑️</button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@else
<div class="card">
    <div class="empty-state">
        <div class="icon">🏷️</div>
        <h3>Belum ada kategori</h3>
        <p>Tambahkan kategori pertama untuk produk</p>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-2">+ Tambah Kategori</a>
    </div>
</div>
@endif
@endsection
