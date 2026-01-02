<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - {{ $storeName }}</title>
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
            font-size: 20px;
            color: #11998e;
            margin-bottom: 5px;
        }
        .header .store-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 11px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
            padding: 8px 12px;
            font-size: 12px;
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
            padding: 6px 8px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .revenue-cards {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .revenue-row {
            display: table-row;
        }
        .revenue-card {
            display: table-cell;
            width: 25%;
            padding: 12px;
            text-align: center;
            border: 1px solid #11998e;
            background: #e8f5e9;
        }
        .revenue-value {
            font-size: 14px;
            font-weight: bold;
            color: #11998e;
        }
        .revenue-label {
            font-size: 9px;
            color: #666;
            margin-top: 3px;
        }
        .stats-table td:first-child {
            width: 60%;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .status-aktif { color: #28a745; }
        .status-menipis { color: #ffc107; }
        .status-habis { color: #dc3545; }
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
        <h1>📊 LAPORAN PENJUALAN BULANAN</h1>
        <div class="store-name">🏪 {{ $storeName }}</div>
        <p>Periode: {{ $currentMonth }} | Tanggal Cetak: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <!-- Revenue Cards -->
    <div class="section">
        <div class="section-title">💰 RINGKASAN PENDAPATAN</div>
        <div class="revenue-cards">
            <div class="revenue-row">
                <div class="revenue-card">
                    <div class="revenue-value">Rp {{ number_format($revenue['total'], 0, ',', '.') }}</div>
                    <div class="revenue-label">Total Keseluruhan</div>
                </div>
                <div class="revenue-card">
                    <div class="revenue-value">Rp {{ number_format($revenue['this_month'], 0, ',', '.') }}</div>
                    <div class="revenue-label">Bulan Ini</div>
                </div>
                <div class="revenue-card">
                    <div class="revenue-value">Rp {{ number_format($revenue['this_week'], 0, ',', '.') }}</div>
                    <div class="revenue-label">Minggu Ini</div>
                </div>
                <div class="revenue-card">
                    <div class="revenue-value">Rp {{ number_format($revenue['today'], 0, ',', '.') }}</div>
                    <div class="revenue-label">Hari Ini</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Stats -->
    <div class="section">
        <div class="section-title">📦 STATISTIK PRODUK</div>
        <table class="stats-table">
            <tr><td>Total Produk</td><td class="text-right"><strong>{{ $stats['total_products'] }}</strong></td></tr>
            <tr><td>Produk Aktif</td><td class="text-right">{{ $stats['active_products'] }}</td></tr>
            <tr><td>Stok Menipis (&lt;= 5)</td><td class="text-right">{{ $stats['low_stock'] }}</td></tr>
            <tr><td>Stok Habis</td><td class="text-right">{{ $stats['out_of_stock'] }}</td></tr>
            <tr><td>Total Pesanan</td><td class="text-right"><strong>{{ $stats['total_orders'] }}</strong></td></tr>
        </table>
    </div>

    <!-- Top Products -->
    <div class="section">
        <div class="section-title">🏆 10 PRODUK TERLARIS BULAN INI</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th class="text-center">Terjual</th>
                    <th class="text-right">Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topProducts as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td>{{ $item->product->category ?? 'N/A' }}</td>
                    <td class="text-center">{{ $item->total_sold }}</td>
                    <td class="text-right">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">Belum ada data penjualan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Daily Revenue -->
    <div class="section">
        <div class="section-title">📅 PENDAPATAN 7 HARI TERAKHIR</div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th class="text-center">Jumlah Transaksi</th>
                    <th class="text-right">Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dailyRevenue as $day)
                <tr>
                    <td>{{ $day['date'] }}</td>
                    <td class="text-center">{{ $day['count'] }}</td>
                    <td class="text-right">Rp {{ number_format($day['amount'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Monthly Revenue -->
    <div class="section">
        <div class="section-title">📊 PENDAPATAN 6 BULAN TERAKHIR</div>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th class="text-center">Jumlah Transaksi</th>
                    <th class="text-right">Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyRevenue as $month)
                <tr>
                    <td>{{ $month['month'] }}</td>
                    <td class="text-center">{{ $month['count'] }}</td>
                    <td class="text-right">Rp {{ number_format($month['amount'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <!-- Product List -->
    <div class="section">
        <div class="section-title">📋 DAFTAR SEMUA PRODUK</div>
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th class="text-right">Harga</th>
                    <th class="text-center">Stok</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                @php
                    $status = $product->is_active ? 'Aktif' : 'Nonaktif';
                    $statusClass = 'status-aktif';
                    if ($product->stock == 0) { $status = 'Stok Habis'; $statusClass = 'status-habis'; }
                    elseif ($product->stock <= 5) { $status = 'Stok Menipis'; $statusClass = 'status-menipis'; }
                @endphp
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category }}</td>
                    <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $product->stock }}</td>
                    <td class="text-center {{ $statusClass }}">{{ $status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Transaction Details -->
    <div class="section">
        <div class="section-title">📝 DETAIL TRANSAKSI BULAN INI</div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>ID Order</th>
                    <th>Pembeli</th>
                    <th>Produk</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Subtotal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orderItems as $item)
                <tr>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>#{{ $item->order_id }}</td>
                    <td>{{ $item->order->user->name ?? 'N/A' }}</td>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    <td>{{ $item->order->status_label }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">Belum ada transaksi bulan ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem Peukan Rumoh</p>
        <p>© {{ date('Y') }} Peukan Rumoh - Platform Pasar Online</p>
    </div>
</body>
</html>
