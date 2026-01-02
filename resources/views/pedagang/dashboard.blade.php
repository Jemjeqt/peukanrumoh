@extends('layouts.dashboard')

@section('title', 'Dashboard Pedagang')
@section('panel_subtitle', 'Pedagang Panel')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Selamat datang kembali!')

@section('header_actions')
<a href="{{ route('pedagang.report.export') }}" class="btn btn-outline" style="margin-right: 0.5rem;" download="laporan_penjualan_{{ now()->format('Y-m') }}.pdf">📥 Unduh Laporan</a>
<a href="{{ route('pedagang.products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
@endsection

@section('styles')
<style>
    /* Dashboard Container */
    .pedagang-dashboard {
        min-height: calc(100vh - 200px);
    }
    
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border-radius: 24px;
        padding: 2rem 2.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
        color: white;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 350px;
        height: 350px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .hero-content {
        position: relative;
        z-index: 1;
    }
    
    .hero-greeting {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .hero-subtitle {
        opacity: 0.9;
        font-size: 1rem;
    }
    
    .hero-icon {
        position: absolute;
        right: 2.5rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 6rem;
        opacity: 0.2;
    }
    
    /* Revenue Cards */
    .revenue-section {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    .revenue-card {
        border-radius: 20px;
        padding: 1.75rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }
    
    .revenue-card::before {
        content: '';
        position: absolute;
        top: -40%;
        right: -25%;
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .revenue-card.total {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .revenue-card.monthly {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .revenue-card.today {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    .revenue-card-content {
        position: relative;
        z-index: 1;
    }
    
    .revenue-icon {
        width: 52px;
        height: 52px;
        background: rgba(255,255,255,0.2);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .revenue-value {
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
    }
    
    .revenue-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    /* Stats Grid */
    .stats-overview {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-card-modern {
        background: white;
        border-radius: 18px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 35px rgba(0,0,0,0.1);
    }
    
    .stat-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }
    
    .stat-card-modern.green::before { background: linear-gradient(90deg, #11998e, #38ef7d); }
    .stat-card-modern.blue::before { background: linear-gradient(90deg, #4facfe, #00f2fe); }
    .stat-card-modern.orange::before { background: linear-gradient(90deg, #ff9966, #ff5e62); }
    .stat-card-modern.red::before { background: linear-gradient(90deg, #f093fb, #f5576c); }
    
    .stat-icon-modern {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .stat-icon-modern.green { background: linear-gradient(135deg, #11998e, #38ef7d); }
    .stat-icon-modern.blue { background: linear-gradient(135deg, #4facfe, #00f2fe); }
    .stat-icon-modern.orange { background: linear-gradient(135deg, #ff9966, #ff5e62); }
    .stat-icon-modern.red { background: linear-gradient(135deg, #f093fb, #f5576c); }
    
    .stat-value-large {
        font-size: 2rem;
        font-weight: 800;
        color: #1a1a2e;
        line-height: 1;
    }
    
    .stat-label-modern {
        font-size: 0.85rem;
        color: #888;
        margin-top: 0.5rem;
        font-weight: 500;
    }
    
    /* Charts Section */
    .charts-section {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .chart-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    
    .chart-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .chart-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }
    
    .chart-card-body {
        padding: 1.5rem;
    }
    
    /* Tables Section */
    .tables-section {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .table-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    
    .table-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .table-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .modern-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .modern-table th {
        background: #f8f9fa;
        padding: 0.875rem 1.25rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .modern-table td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f5f5f5;
    }
    
    .modern-table tr:last-child td {
        border-bottom: none;
    }
    
    .modern-table tr:hover {
        background: #fafafa;
    }
    
    /* Status Badge */
    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    /* Low Stock Warning */
    .low-stock-section {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
        border-left: 4px solid #f5576c;
    }
    
    .low-stock-header {
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #fff5f5, #fff);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .low-stock-title {
        font-size: 1rem;
        font-weight: 700;
        color: #f5576c;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .revenue-section { grid-template-columns: repeat(2, 1fr); }
        .stats-overview { grid-template-columns: repeat(2, 1fr); }
        .charts-section { grid-template-columns: 1fr; }
        .tables-section { grid-template-columns: 1fr; }
    }
    
    @media (max-width: 768px) {
        .revenue-section { grid-template-columns: 1fr; }
        .stats-overview { grid-template-columns: 1fr; }
        .hero-icon { display: none; }
    }
</style>
@endsection

@section('content')
<div class="pedagang-dashboard">
    @if(!auth()->user()->is_approved)
    <div class="alert alert-warning">
        ⚠️ Akun Anda sedang menunggu persetujuan dari Admin. Anda belum dapat menjual produk.
    </div>
    @endif

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <div class="hero-greeting">Halo, {{ auth()->user()->name }}! 👋</div>
            <div class="hero-subtitle">Kelola toko Anda dan pantau penjualan hari ini</div>
        </div>
        <div class="hero-icon">🏪</div>
    </div>

    <!-- Revenue Cards -->
    <div class="revenue-section">
        <div class="revenue-card total">
            <div class="revenue-card-content">
                <div class="revenue-icon">💰</div>
                <div class="revenue-value">Rp {{ number_format($revenue['total'] ?? 0, 0, ',', '.') }}</div>
                <div class="revenue-label">Total Pendapatan</div>
            </div>
        </div>
        <div class="revenue-card monthly">
            <div class="revenue-card-content">
                <div class="revenue-icon">📅</div>
                <div class="revenue-value">Rp {{ number_format($revenue['this_month'] ?? 0, 0, ',', '.') }}</div>
                <div class="revenue-label">Bulan Ini</div>
            </div>
        </div>
        <div class="revenue-card today">
            <div class="revenue-card-content">
                <div class="revenue-icon">📆</div>
                <div class="revenue-value">Rp {{ number_format($revenue['today'] ?? 0, 0, ',', '.') }}</div>
                <div class="revenue-label">Hari Ini</div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="stats-overview">
        <div class="stat-card-modern green">
            <div class="stat-icon-modern green">📦</div>
            <div class="stat-value-large">{{ $stats['total_products'] ?? 0 }}</div>
            <div class="stat-label-modern">Total Produk</div>
        </div>
        <div class="stat-card-modern blue">
            <div class="stat-icon-modern blue">📋</div>
            <div class="stat-value-large">{{ $stats['total_orders'] ?? 0 }}</div>
            <div class="stat-label-modern">Total Pesanan</div>
        </div>
        <div class="stat-card-modern orange">
            <div class="stat-icon-modern orange">⏳</div>
            <div class="stat-value-large">{{ $stats['pending_orders'] ?? 0 }}</div>
            <div class="stat-label-modern">Pesanan Aktif</div>
        </div>
        <div class="stat-card-modern red">
            <div class="stat-icon-modern red">⚠️</div>
            <div class="stat-value-large">{{ $stats['low_stock'] ?? 0 }}</div>
            <div class="stat-label-modern">Stok Menipis</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-section">
        <div class="chart-card">
            <div class="chart-card-header">
                <span>📈</span>
                <h3 class="chart-card-title">Pendapatan 7 Hari Terakhir</h3>
            </div>
            <div class="chart-card-body">
                <canvas id="revenueChart" style="max-height: 280px;"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <div class="chart-card-header">
                <span>📊</span>
                <h3 class="chart-card-title">Pendapatan Bulanan</h3>
            </div>
            <div class="chart-card-body">
                <canvas id="monthlyChart" style="max-height: 280px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="tables-section">
        <!-- Recent Orders -->
        <div class="table-card">
            <div class="table-card-header">
                <h3 class="table-card-title"><span>📋</span> Pesanan Terbaru</h3>
                <a href="{{ route('pedagang.orders.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
            </div>
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Pembeli</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders ?? [] as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ $order->user->name ?? '-' }}</td>
                        <td style="font-weight: 600;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td><span class="badge badge-{{ $order->status_badge }}">{{ $order->status_label }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted" style="padding: 2rem;">Belum ada pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Top Products -->
        <div class="table-card">
            <div class="table-card-header">
                <h3 class="table-card-title"><span>🏆</span> Produk Terlaris</h3>
            </div>
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topProducts ?? [] as $item)
                    <tr>
                        <td>{{ $item->product->name ?? '-' }}</td>
                        <td style="font-weight: 700; color: #11998e;">Rp {{ number_format($item->total_revenue ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center text-muted" style="padding: 2rem;">Belum ada penjualan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Low Stock Warning -->
    @if(count($lowStockProducts ?? []) > 0)
    <div class="low-stock-section">
        <div class="low-stock-header">
            <h3 class="low-stock-title">⚠️ Stok Menipis - Segera Restock!</h3>
        </div>
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStockProducts as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td><span class="badge badge-danger">{{ $product->stock }}</span></td>
                    <td><a href="{{ route('pedagang.products.edit', $product) }}" class="btn btn-sm btn-primary">Edit Stok</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
// Daily Revenue Chart
const dailyRevenue = @json($dailyRevenue ?? []);

new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: dailyRevenue.map(item => item.date),
        datasets: [{
            label: 'Pendapatan',
            data: dailyRevenue.map(item => item.amount),
            borderColor: '#11998e',
            backgroundColor: 'rgba(17, 153, 142, 0.1)',
            fill: true,
            tension: 0.4,
            borderWidth: 3,
            pointBackgroundColor: '#11998e',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.05)' },
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            },
            x: {
                grid: { display: false }
            }
        },
        plugins: { 
            legend: { display: false }
        }
    }
});

// Monthly Revenue Chart
const monthlyRevenue = @json($monthlyRevenue ?? []);

new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: monthlyRevenue.map(item => item.month),
        datasets: [{
            label: 'Pendapatan',
            data: monthlyRevenue.map(item => item.amount),
            backgroundColor: 'rgba(17, 153, 142, 0.8)',
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.05)' },
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            },
            x: {
                grid: { display: false }
            }
        },
        plugins: { 
            legend: { display: false }
        }
    }
});
</script>
@endsection
