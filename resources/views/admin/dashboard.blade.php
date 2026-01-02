@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('panel_subtitle', 'Admin Panel')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Selamat datang kembali, Admin!')

@section('styles')
<style>
    /* Export Button for Header */
    .btn-export {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        color: white;
        padding: 0.6rem 1.25rem;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        border: none;
        box-shadow: 0 4px 15px rgba(26,26,46,0.3);
    }
    
    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(26,26,46,0.4);
    }
    
    .btn-export svg {
        width: 18px;
        height: 18px;
    }
    
    /* Premium Revenue Cards */
    .revenue-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .revenue-card {
        border-radius: 20px;
        padding: 1.75rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    }
    
    .revenue-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    
    .revenue-card::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -20%;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    
    .revenue-card.purple {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .revenue-card.teal {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    
    .revenue-card-content {
        position: relative;
        z-index: 1;
        color: white;
    }
    
    .revenue-card-icon {
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        backdrop-filter: blur(10px);
    }
    
    .revenue-card-value {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .revenue-card-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    /* Mini Stats Cards */
    .mini-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .mini-stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.04);
    }
    
    .mini-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }
    
    .mini-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }
    
    .mini-stat-icon.green { background: linear-gradient(135deg, #a8e063, #56ab2f); }
    .mini-stat-icon.orange { background: linear-gradient(135deg, #ff9966, #ff5e62); }
    .mini-stat-icon.blue { background: linear-gradient(135deg, #4facfe, #00f2fe); }
    .mini-stat-icon.pink { background: linear-gradient(135deg, #f093fb, #f5576c); }
    
    .mini-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a2e;
        line-height: 1;
    }
    
    .mini-stat-label {
        font-size: 0.8rem;
        color: #666;
        margin-top: 0.25rem;
    }
    
    /* Charts Section */
    .charts-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .chart-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        height: 420px;
        display: flex;
        flex-direction: column;
    }
    
    .chart-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .chart-card-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .chart-card-title-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .chart-card-title-icon.purple { background: linear-gradient(135deg, #667eea, #764ba2); }
    .chart-card-title-icon.green { background: linear-gradient(135deg, #11998e, #38ef7d); }
    
    .chart-card-title h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }
    
    .chart-card-title p {
        font-size: 0.8rem;
        color: #888;
        margin: 0;
    }
    
    .chart-stats-row {
        display: flex;
        gap: 0.75rem;
    }
    
    .chart-stat-pill {
        background: #f8f9fa;
        border-radius: 25px;
        padding: 0.5rem 1rem;
        text-align: center;
    }
    
    .chart-stat-pill.accent {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
    }
    
    .chart-stat-pill-value {
        font-size: 0.9rem;
        font-weight: 700;
    }
    
    .chart-stat-pill-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.8;
    }
    
    .chart-card-body {
        padding: 1.5rem;
        flex: 1;
        position: relative;
    }
    
    /* Donut Chart Container - Exact Reference Layout */
    .donut-section {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 2rem;
        height: 100%;
        padding: 1rem;
    }
    
    .donut-wrapper {
        position: relative;
        width: 130px;
        height: 130px;
        flex-shrink: 0;
    }
    
    .donut-center-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }
    
    .donut-center-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a1a2e;
        line-height: 1;
    }
    
    .donut-center-label {
        font-size: 0.55rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #888;
        margin-top: 0.15rem;
    }
    
    .status-legend {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.3rem 0;
    }
    
    .legend-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .legend-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
    
    .legend-text {
        font-size: 0.8rem;
        color: #444;
    }
    
    .legend-count {
        font-weight: 600;
        color: #555;
        font-size: 0.8rem;
    }
    
    /* Tables Section */
    .tables-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 1.5rem;
    }
    
    .table-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .table-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .table-card-header h3 {
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
        padding: 0.875rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .modern-table td {
        padding: 0.875rem 1rem;
        border-bottom: 1px solid #f5f5f5;
        font-size: 0.875rem;
    }
    
    .modern-table tr:last-child td {
        border-bottom: none;
    }
    
    .modern-table tr:hover td {
        background: #fafafa;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .charts-grid, .tables-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 900px) {
        .revenue-grid {
            grid-template-columns: 1fr;
        }
        .mini-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 600px) {
        .mini-stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('header_actions')
<a href="{{ route('admin.report.export') }}" class="btn-export" download="laporan_peukan_rumoh_{{ now()->format('Y-m') }}.pdf">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
    </svg>
    Unduh Laporan
</a>
@endsection

@section('content')
<!-- Revenue Cards -->
<div class="revenue-grid">
    <div class="revenue-card purple">
        <div class="revenue-card-content">
            <div class="revenue-card-icon">💵</div>
            <div class="revenue-card-value">Rp {{ number_format($stats['admin_revenue'] ?? 0, 0, ',', '.') }}</div>
            <div class="revenue-card-label">Pendapatan Admin</div>
        </div>
    </div>
    <div class="revenue-card teal">
        <div class="revenue-card-content">
            <div class="revenue-card-icon">💰</div>
            <div class="revenue-card-value">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</div>
            <div class="revenue-card-label">Total Transaksi Platform</div>
        </div>
    </div>
</div>

<!-- Mini Stats -->
<div class="mini-stats-grid">
    <div class="mini-stat-card">
        <div class="mini-stat-icon green">👥</div>
        <div>
            <div class="mini-stat-value">{{ $stats['total_pembeli'] ?? 0 }}</div>
            <div class="mini-stat-label">Pembeli</div>
        </div>
    </div>
    <div class="mini-stat-card">
        <div class="mini-stat-icon orange">🏪</div>
        <div>
            <div class="mini-stat-value">{{ $stats['total_pedagang'] ?? 0 }}</div>
            <div class="mini-stat-label">Pedagang</div>
        </div>
    </div>
    <div class="mini-stat-card">
        <div class="mini-stat-icon blue">🚚</div>
        <div>
            <div class="mini-stat-value">{{ $stats['total_kurir'] ?? 0 }}</div>
            <div class="mini-stat-label">Kurir</div>
        </div>
    </div>
    <div class="mini-stat-card">
        <div class="mini-stat-icon pink">📦</div>
        <div>
            <div class="mini-stat-value">{{ $stats['total_products'] ?? 0 }}</div>
            <div class="mini-stat-label">Produk</div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="charts-grid">
    <!-- Sales Chart -->
    <div class="chart-card">
        <div class="chart-card-header">
            <div class="chart-card-title">
                <div class="chart-card-title-icon purple">📊</div>
                <div>
                    <h3>Transaksi 7 Hari Terakhir</h3>
                    <p>Grafik penjualan harian</p>
                </div>
            </div>
            <div class="chart-stats-row">
                <div class="chart-stat-pill">
                    <div class="chart-stat-pill-value">{{ count($dailySales ?? []) }}</div>
                    <div class="chart-stat-pill-label">Hari Aktif</div>
                </div>
                <div class="chart-stat-pill accent">
                    <div class="chart-stat-pill-value">Rp {{ number_format(collect($dailySales ?? [])->sum('total'), 0, ',', '.') }}</div>
                    <div class="chart-stat-pill-label">Total 7 Hari</div>
                </div>
            </div>
        </div>
        <div class="chart-card-body">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
    
    <!-- Status Chart -->
    <div class="chart-card">
        <div class="chart-card-header">
            <div class="chart-card-title">
                <div class="chart-card-title-icon green">📦</div>
                <div>
                    <h3>Status Pesanan</h3>
                    <p>Distribusi status</p>
                </div>
            </div>
        </div>
        <div class="chart-card-body">
            <div class="donut-section">
                <div class="donut-wrapper">
                    <canvas id="ordersChart"></canvas>
                    <div class="donut-center-text">
                        <div class="donut-center-value">{{ $stats['total_orders'] ?? 0 }}</div>
                        <div class="donut-center-label">Pesanan</div>
                    </div>
                </div>
                <div class="status-legend" id="statusLegend"></div>
            </div>
        </div>
    </div>
</div>

<!-- Tables Section -->
<div class="tables-grid">
    <!-- Recent Orders -->
    <div class="table-card">
        <div class="table-card-header">
            <h3>📋 Pesanan Terbaru</h3>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline">Lihat Semua →</a>
        </div>
        <table class="modern-table">
            <thead>
                <tr>
                    <th>ID</th>
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
                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
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
    
    <!-- Pending Approvals -->
    <div class="table-card">
        <div class="table-card-header">
            <h3>⏳ Menunggu Persetujuan</h3>
            <span class="badge badge-warning">{{ $stats['pending_approvals'] ?? 0 }}</span>
        </div>
        <table class="modern-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingUsers ?? [] as $user)
                <tr>
                    <td>
                        <div style="font-weight: 600;">{{ $user->name }}</div>
                        <div style="font-size: 0.75rem; color: #888;">{{ $user->email }}</div>
                    </td>
                    <td><span class="badge badge-info">{{ ucfirst($user->role) }}</span></td>
                    <td>
                        <form action="{{ route('admin.users.approve', $user) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">✓ Approve</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted" style="padding: 2rem;">Semua user sudah disetujui ✓</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Low Stock Warning -->
@if(count($lowStockProducts ?? []) > 0)
<div class="table-card" style="margin-top: 1.5rem;">
    <div class="table-card-header">
        <h3>⚠️ Stok Menipis</h3>
    </div>
    <table class="modern-table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Pedagang</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lowStockProducts as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->user->name ?? '-' }}</td>
                <td><span class="badge badge-warning">{{ $product->stock }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusColors = {
        'pending': '#ffc107',
        'paid': '#17a2b8',
        'processing': '#007bff',
        'ready_pickup': '#fd7e14',
        'shipped': '#6f42c1',
        'delivered': '#6c757d',
        'completed': '#28a745',
        'cancelled': '#dc3545'
    };
    
    const statusLabels = {
        'pending': 'Pending',
        'paid': 'Paid',
        'processing': 'Processing',
        'ready_pickup': 'Ready Pickup',
        'shipped': 'Shipped',
        'delivered': 'Delivered',
        'completed': 'Completed',
        'cancelled': 'Cancelled'
    };

    // Donut Chart
    const ordersByStatus = @json($ordersByStatus ?? []);
    const ordersCtx = document.getElementById('ordersChart');
    
    if (ordersCtx && ordersByStatus.length > 0) {
        new Chart(ordersCtx, {
            type: 'doughnut',
            data: {
                labels: ordersByStatus.map(item => statusLabels[item.status] || item.status),
                datasets: [{
                    data: ordersByStatus.map(item => parseInt(item.total)),
                    backgroundColor: ordersByStatus.map(item => statusColors[item.status] || '#999'),
                    borderWidth: 0,
                    spacing: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: { legend: { display: false } }
            }
        });
        
        // Build legend
        const legendContainer = document.getElementById('statusLegend');
        if (legendContainer) {
            let html = '';
            ordersByStatus.forEach(item => {
                const label = statusLabels[item.status] || item.status;
                const color = statusColors[item.status] || '#999';
                html += `
                    <div class="legend-item">
                        <div class="legend-label">
                            <span class="legend-dot" style="background: ${color}"></span>
                            <span class="legend-text">${label}</span>
                        </div>
                        <span class="legend-count">${parseInt(item.total)}</span>
                    </div>
                `;
            });
            legendContainer.innerHTML = html;
        }
    }

    // Bar Chart
    const dailySales = @json($dailySales ?? []);
    const salesCtx = document.getElementById('salesChart');
    
    if (salesCtx && dailySales.length > 0) {
        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: dailySales.map(item => {
                    const date = new Date(item.date);
                    return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
                }),
                datasets: [{
                    label: 'Penjualan',
                    data: dailySales.map(item => item.total),
                    backgroundColor: 'rgba(102, 126, 234, 0.8)',
                    borderRadius: 8,
                    barThickness: 35
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(1) + 'jt';
                                if (value >= 1000) return 'Rp ' + (value/1000).toFixed(0) + 'rb';
                                return 'Rp ' + value;
                            },
                            font: { size: 11 }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1a1a2e',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection
