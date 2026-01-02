{{-- Admin Sidebar Menu --}}
<li>
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="sidebar-link-icon">📊</span>
        <span>Dashboard</span>
    </a>
</li>
<li>
    <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <span class="sidebar-link-icon">📦</span>
        <span>Produk</span>
    </a>
</li>
<li>
    <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <span class="sidebar-link-icon">📋</span>
        <span>Pesanan</span>
    </a>
</li>
<li>
    <a href="{{ route('admin.returns.index') }}" class="sidebar-link {{ request()->routeIs('admin.returns.*') ? 'active' : '' }}">
        <span class="sidebar-link-icon">↩️</span>
        <span>Return</span>
    </a>
</li>
<li>
    <a href="{{ route('admin.reviews.index') }}" class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
        <span class="sidebar-link-icon">⭐</span>
        <span>Ulasan</span>
    </a>
</li>
<li>
    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <span class="sidebar-link-icon">👥</span>
        <span>Users</span>
    </a>
</li>
<li>
    <a href="{{ route('profile.index') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <span class="sidebar-link-icon">⚙️</span>
        <span>Akun</span>
    </a>
</li>

