<header>
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('welcome') }}" class="logo">
                <div class="logo-icon">🏪</div>
                Peukan<span>Rumoh</span>
            </a>
            
            @auth
                @if(auth()->user()->isPembeli())
                <form action="{{ route('shop.index') }}" method="GET" class="search-box">
                    <input type="text" name="search" placeholder="Cari produk segar..." value="{{ request('search') }}">
                    <button type="submit">🔍</button>
                </form>
                @endif
            @endauth
            
            <div class="nav-links">
                @auth
                    @php $user = auth()->user(); @endphp
                    
                    @if($user->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            📊 Dashboard
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            👥 Users
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            📦 Produk
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            📋 Pesanan
                        </a>
                        <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            👤 Akun
                        </a>
                    @elseif($user->isPedagang())
                        <a href="{{ route('pedagang.dashboard') }}" class="nav-link {{ request()->routeIs('pedagang.dashboard') ? 'active' : '' }}">
                            📊 Dashboard
                        </a>
                        <a href="{{ route('pedagang.products.index') }}" class="nav-link {{ request()->routeIs('pedagang.products.*') ? 'active' : '' }}">
                            📦 Produk
                        </a>
                        <a href="{{ route('pedagang.orders.index') }}" class="nav-link {{ request()->routeIs('pedagang.orders.*') ? 'active' : '' }}">
                            📋 Pesanan
                            @php
                                $pedagangOrderCount = \App\Models\Order::where('status', 'paid')->count();
                            @endphp
                            @if($pedagangOrderCount > 0)
                                <span class="nav-badge">{{ $pedagangOrderCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('pedagang.returns.index') }}" class="nav-link {{ request()->routeIs('pedagang.returns.*') ? 'active' : '' }}">
                            🔄 Return
                            @php
                                // Count: pending (new) + received (waiting for pedagang action)
                                $pedagangReturnCount = \App\Models\ProductReturn::whereIn('status', ['pending', 'received'])->count();
                            @endphp
                            @if($pedagangReturnCount > 0)
                                <span class="nav-badge">{{ $pedagangReturnCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('pedagang.reviews.index') }}" class="nav-link {{ request()->routeIs('pedagang.reviews.*') ? 'active' : '' }}">
                            ⭐ Ulasan
                        </a>
                        <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            👤 Akun
                        </a>
                    @elseif($user->isKurir())
                        <a href="{{ route('kurir.dashboard') }}" class="nav-link {{ request()->routeIs('kurir.dashboard') ? 'active' : '' }}">
                            📊 Dashboard
                        </a>
                        <a href="{{ route('kurir.deliveries.index') }}" class="nav-link {{ request()->routeIs('kurir.deliveries.index') || request()->routeIs('kurir.deliveries.show') ? 'active' : '' }}">
                            🚚 Pengiriman
                            @php
                                $kurirDeliveryCount = \App\Models\Order::where('kurir_id', auth()->id())->whereIn('status', ['ready_pickup', 'shipped'])->count();
                            @endphp
                            @if($kurirDeliveryCount > 0)
                                <span class="nav-badge">{{ $kurirDeliveryCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('kurir.returns.index') }}" class="nav-link {{ request()->routeIs('kurir.returns.*') ? 'active' : '' }}">
                            🔄 Return
                            @php
                                // Count: pickup/delivering (return flow) + replacement_shipping (replacement flow)
                                $kurirReturnCount = \App\Models\ProductReturn::where(function($q) {
                                    $q->where('kurir_id', auth()->id())->whereIn('status', ['pickup', 'delivering']);
                                })->orWhere(function($q) {
                                    $q->where('replacement_kurir_id', auth()->id())->where('status', 'replacement_shipping');
                                })->count();
                            @endphp
                            @if($kurirReturnCount > 0)
                                <span class="nav-badge">{{ $kurirReturnCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('kurir.deliveries.history') }}" class="nav-link {{ request()->routeIs('kurir.deliveries.history') ? 'active' : '' }}">
                            📜 Riwayat
                        </a>
                        <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            👤 Akun
                        </a>
                    @else
                        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            🏠 Beranda
                        </a>
                        <a href="{{ route('shop.index') }}" class="nav-link {{ request()->routeIs('shop.*') ? 'active' : '' }}">
                            🛍️ Belanja
                        </a>
                        <a href="{{ route('cart.index') }}" class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                            🛒 Keranjang
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                            @endphp
                            @if($cartCount > 0)
                                <span class="nav-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('pembeli.orders.index') }}" class="nav-link {{ request()->routeIs('pembeli.orders.*') ? 'active' : '' }}">
                            📦 Pesanan
                            @php
                                // Count active orders (not completed/cancelled)
                                $orderCount = \App\Models\Order::where('user_id', auth()->id())
                                    ->whereNotIn('status', ['completed', 'cancelled'])
                                    ->count();
                                // Count returns needing buyer confirmation (replacement_delivered or refund_sent)
                                $returnCount = \App\Models\ProductReturn::where('user_id', auth()->id())
                                    ->whereIn('status', ['replacement_delivered', 'refund_sent'])
                                    ->count();
                                $totalNotif = $orderCount + $returnCount;
                            @endphp
                            @if($totalNotif > 0)
                                <span class="nav-badge">{{ $totalNotif }}</span>
                            @endif
                        </a>
                        <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            👤 Akun
                        </a>
                    @endif
                    
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>
</header>
