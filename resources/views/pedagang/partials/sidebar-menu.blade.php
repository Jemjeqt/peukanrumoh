{{-- Pedagang Sidebar Menu --}}
<li>
    <a href="{{ route('pedagang.dashboard') }}" class="sidebar-link {{ request()->routeIs('pedagang.dashboard') ? 'active' : '' }}">
        <span class="sidebar-link-icon">📊</span>
        <span>Dashboard</span>
    </a>
</li>
<li>
    <a href="{{ route('pedagang.products.index') }}" class="sidebar-link {{ request()->routeIs('pedagang.products.*') ? 'active' : '' }}">
        <span class="sidebar-link-icon">📦</span>
        <span>Produk</span>
    </a>
</li>
<li>
    <a href="{{ route('pedagang.orders.index') }}" class="sidebar-link {{ request()->routeIs('pedagang.orders.*') ? 'active' : '' }}">
        <span class="sidebar-link-icon">📋</span>
        <span>Pesanan</span>
    </a>
</li>
<li>
    <a href="{{ route('pedagang.returns.index') }}" class="sidebar-link {{ request()->routeIs('pedagang.returns.*') ? 'active' : '' }}">
        <span class="sidebar-link-icon">↩️</span>
        <span>Return</span>
    </a>
</li>
<li>
    <a href="{{ route('pedagang.reviews.index') }}" class="sidebar-link {{ request()->routeIs('pedagang.reviews.*') ? 'active' : '' }}">
        <span class="sidebar-link-icon">⭐</span>
        <span>Ulasan</span>
    </a>
</li>
<li>
    <a href="{{ route('profile.index') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <span class="sidebar-link-icon">👤</span>
        <span>Akun</span>
    </a>
</li>
