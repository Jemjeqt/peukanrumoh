<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan - Peukan Rumoh</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #11998e;
        }
        .header h1 {
            font-size: 22px;
            color: #11998e;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 12px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .stats-row {
            display: table-row;
        }
        .stat-box {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            background: #f8f9fa;
        }
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #11998e;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
        }
        .revenue-box {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .revenue-box h3 {
            color: #11998e;
            margin-bottom: 10px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-info { background: #d1ecf1; color: #0c5460; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #888;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏪 LAPORAN BULANAN PLATFORM</h1>
        <p><strong>PEUKAN RUMOH</strong></p>
        <p>Periode: {{ $currentMonth }} | Tanggal Cetak: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <!-- Stats Overview -->
    <div class="section">
        <div class="section-title">📊 RINGKASAN STATISTIK PLATFORM</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stat-box">
                    <div class="stat-value">{{ $stats['total_pembeli'] }}</div>
                    <div class="stat-label">Total Pembeli</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ $stats['total_pedagang'] }}</div>
                    <div class="stat-label">Total Pedagang</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ $stats['total_kurir'] }}</div>
                    <div class="stat-label">Total Kurir</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ $stats['total_products'] }}</div>
                    <div class="stat-label">Total Produk</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue -->
    <div class="section">
        <div class="section-title">💰 PENDAPATAN BULAN INI</div>
        <div class="revenue-box">
            <table>
                <tr>
                    <td><strong>Total Transaksi Bulan Ini</strong></td>
                    <td class="text-right"><strong>{{ $monthlyStats['order_count'] }} pesanan</strong></td>
                </tr>
                <tr>
                    <td><strong>Total Nilai Transaksi</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($monthlyStats['total_revenue'], 0, ',', '.') }}</strong></td>
                </tr>
                <tr>
                    <td>Pendapatan Admin (Fee)</td>
                    <td class="text-right">Rp {{ number_format($monthlyStats['admin_fee'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Total Ongkos Kirim</td>
                    <td class="text-right">Rp {{ number_format($monthlyStats['shipping_cost'], 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Orders by Status -->
    <div class="section">
        <div class="section-title">📦 PESANAN BULAN INI BERDASARKAN STATUS</div>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-right">Nilai Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ordersByStatus as $order)
                <tr>
                    <td>{{ $order['label'] }}</td>
                    <td class="text-center">{{ $order['total'] }}</td>
                    <td class="text-right">Rp {{ number_format($order['nilai'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pedagang Revenue -->
    <div class="section">
        <div class="section-title">🏪 PENDAPATAN PER PEDAGANG BULAN INI</div>
        <table>
            <thead>
                <tr>
                    <th>Nama Pedagang</th>
                    <th>Email</th>
                    <th class="text-center">Produk Terjual</th>
                    <th class="text-right">Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedagangRevenue as $p)
                <tr>
                    <td>{{ $p['name'] }}</td>
                    <td>{{ $p['email'] }}</td>
                    <td class="text-center">{{ $p['sold'] }}</td>
                    <td class="text-right">Rp {{ number_format($p['revenue'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <!-- Return Stats -->
    <div class="section">
        <div class="section-title">🔄 STATISTIK PENGEMBALIAN BULAN INI</div>
        <table>
            <tr><td>Total Pengajuan Return</td><td class="text-right"><strong>{{ $returnStats['total'] }}</strong></td></tr>
            <tr><td>Return Disetujui</td><td class="text-right">{{ $returnStats['approved'] }}</td></tr>
            <tr><td>Return Ditolak</td><td class="text-right">{{ $returnStats['rejected'] }}</td></tr>
            <tr><td>Return Selesai</td><td class="text-right">{{ $returnStats['completed'] }}</td></tr>
            <tr><td>Tipe Ganti Barang</td><td class="text-right">{{ $returnStats['replacement'] }}</td></tr>
            <tr><td>Tipe Refund</td><td class="text-right">{{ $returnStats['refund'] }}</td></tr>
        </table>
    </div>

    <!-- Review Stats -->
    <div class="section">
        <div class="section-title">⭐ STATISTIK ULASAN BULAN INI</div>
        <table>
            <tr><td>Total Ulasan</td><td class="text-right"><strong>{{ $reviewStats['total'] }}</strong></td></tr>
            <tr><td>Rata-rata Rating</td><td class="text-right"><strong>{{ number_format($reviewStats['average'], 1) }} / 5</strong></td></tr>
            @for($i = 5; $i >= 1; $i--)
            <tr><td>Rating {{ $i }} Bintang</td><td class="text-right">{{ $reviewStats['rating_' . $i] }}</td></tr>
            @endfor
        </table>
    </div>

    <!-- Top Products -->
    <div class="section">
        <div class="section-title">🏆 10 PRODUK TERLARIS BULAN INI</div>
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Pedagang</th>
                    <th class="text-center">Terjual</th>
                    <th class="text-right">Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topProducts as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td>{{ $item->product->pedagang->name ?? 'N/A' }}</td>
                    <td class="text-center">{{ $item->total_sold }}</td>
                    <td class="text-right">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center">Belum ada data penjualan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Recent Orders -->
    <div class="section">
        <div class="section-title">📋 20 PESANAN TERBARU</div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pembeli</th>
                    <th class="text-right">Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                    <td class="text-right">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>{{ $order->status_label }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem Peukan Rumoh</p>
        <p>© {{ date('Y') }} Peukan Rumoh - Platform Pasar Online</p>
    </div>
</body>
</html>
