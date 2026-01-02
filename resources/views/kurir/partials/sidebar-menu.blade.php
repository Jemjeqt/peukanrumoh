{{-- Kurir Sidebar Menu --}}
<li>
    <a href="{{ route('kurir.dashboard') }}" class="sidebar-link {{ request()->routeIs('kurir.dashboard') ? 'active' : '' }}">
        <span class="sidebar-link-icon">📊</span>
        <span>Dashboard</span>
    </a>
</li>
<li>
    <a href="{{ route('kurir.deliveries.index') }}" class="sidebar-link {{ request()->routeIs('kurir.deliveries.index') ? 'active' : '' }}">
        <span class="sidebar-link-icon">🚚</span>
        <span>Pengiriman</span>
    </a>
</li>
<li>
    <a href="{{ route('kurir.returns.index') }}" class="sidebar-link {{ request()->routeIs('kurir.returns.*') ? 'active' : '' }}">
        <span class="sidebar-link-icon">↩️</span>
        <span>Return</span>
    </a>
</li>
<li>
    <a href="{{ route('kurir.deliveries.history') }}" class="sidebar-link {{ request()->routeIs('kurir.deliveries.history') ? 'active' : '' }}">
        <span class="sidebar-link-icon">📜</span>
        <span>Riwayat</span>
    </a>
</li>
<li>
    <a href="{{ route('profile.index') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <span class="sidebar-link-icon">👤</span>
        <span>Akun</span>
    </a>
</li>
