<?php

namespace App\Http\Controllers\Pedagang;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $productIds = Product::where('user_id', $user->id)->pluck('id');

        // Get revenue from order items (only this pedagang's products)
        $getRevenue = function($query = null) use ($productIds) {
            $base = OrderItem::whereIn('product_id', $productIds)
                ->whereHas('order', function($q) {
                    $q->whereNotIn('status', ['cancelled', 'pending']);
                });
            if ($query) $base = $query($base);
            return $base->sum('subtotal');
        };

        // Revenue stats
        $revenue = [
            'total' => $getRevenue(),
            'today' => $getRevenue(fn($q) => $q->whereDate('created_at', today())),
            'this_week' => $getRevenue(fn($q) => $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])),
            'this_month' => $getRevenue(fn($q) => $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)),
            'this_year' => $getRevenue(fn($q) => $q->whereYear('created_at', now()->year)),
        ];

        // Daily revenue for last 7 days
        $dailyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $amount = OrderItem::whereIn('product_id', $productIds)
                ->whereHas('order', fn($q) => $q->whereNotIn('status', ['cancelled', 'pending']))
                ->whereDate('created_at', $date)
                ->sum('subtotal');
            $dailyRevenue[] = [
                'date' => $date->format('d M'),
                'amount' => (float) $amount,
            ];
        }

        // Monthly revenue for last 6 months
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $amount = OrderItem::whereIn('product_id', $productIds)
                ->whereHas('order', fn($q) => $q->whereNotIn('status', ['cancelled', 'pending']))
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('subtotal');
            $monthlyRevenue[] = [
                'month' => $date->format('M Y'),
                'amount' => (float) $amount,
            ];
        }

        // Product stats
        $stats = [
            'total_products' => Product::where('user_id', $user->id)->count(),
            'active_products' => Product::where('user_id', $user->id)->where('is_active', true)->count(),
            'low_stock' => Product::where('user_id', $user->id)->where('stock', '<=', 5)->where('stock', '>', 0)->count(),
            'out_of_stock' => Product::where('user_id', $user->id)->where('stock', 0)->count(),
        ];

        // Order stats
        $orderIds = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.user_id', $user->id)
            ->pluck('order_items.order_id')
            ->unique();

        $stats['total_orders'] = Order::whereIn('id', $orderIds)->whereNotIn('status', ['cancelled', 'pending'])->count();
        $stats['pending_orders'] = Order::whereIn('id', $orderIds)->whereIn('status', ['paid', 'processing'])->count();

        // Recent orders
        $recentOrders = Order::with(['user', 'items.product'])
            ->whereIn('id', $orderIds)
            ->latest()
            ->limit(5)
            ->get();

        // Top selling products
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
            ->whereIn('product_id', $productIds)
            ->whereHas('order', fn($q) => $q->whereNotIn('status', ['cancelled', 'pending']))
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->with('product')
            ->get();

        // Low stock products
        $lowStockProducts = Product::where('user_id', $user->id)
            ->where('stock', '<=', 5)
            ->where('stock', '>', 0)
            ->limit(5)
            ->get();

        return view('pedagang.dashboard', compact(
            'stats', 'revenue', 'dailyRevenue', 'monthlyRevenue', 
            'recentOrders', 'topProducts', 'lowStockProducts'
        ));
    }

    /**
     * Export laporan penjualan bulanan sebagai PDF
     */
    public function exportReport()
    {
        $user = auth()->user();
        $currentMonth = now()->format('F Y');
        $storeName = $user->store_name ?? $user->name;
        $productIds = Product::where('user_id', $user->id)->pluck('id');

        // Helper function for revenue calculation
        $getRevenue = function($query = null) use ($productIds) {
            $base = OrderItem::whereIn('product_id', $productIds)
                ->whereHas('order', function($q) {
                    $q->whereNotIn('status', ['cancelled', 'pending']);
                });
            if ($query) $base = $query($base);
            return (float) $base->sum('subtotal');
        };

        // Revenue data
        $revenue = [
            'total' => $getRevenue(),
            'this_month' => $getRevenue(fn($q) => $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)),
            'this_week' => $getRevenue(fn($q) => $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])),
            'today' => $getRevenue(fn($q) => $q->whereDate('created_at', today())),
        ];

        // Stats
        $stats = [
            'total_products' => Product::where('user_id', $user->id)->count(),
            'active_products' => Product::where('user_id', $user->id)->where('is_active', true)->count(),
            'low_stock' => Product::where('user_id', $user->id)->where('stock', '<=', 5)->where('stock', '>', 0)->count(),
            'out_of_stock' => Product::where('user_id', $user->id)->where('stock', 0)->count(),
            'total_orders' => Order::whereHas('items', fn($q) => $q->whereIn('product_id', $productIds))
                ->whereNotIn('status', ['cancelled', 'pending'])->count(),
        ];

        // Top products
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
            ->whereIn('product_id', $productIds)
            ->whereHas('order', function($q) {
                $q->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year)
                  ->whereNotIn('status', ['cancelled', 'pending']);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->with('product')
            ->get();

        // Daily revenue
        $dailyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayItems = OrderItem::whereIn('product_id', $productIds)
                ->whereHas('order', fn($q) => $q->whereNotIn('status', ['cancelled', 'pending']))
                ->whereDate('created_at', $date);
            $dailyRevenue[] = [
                'date' => $date->format('d F Y'),
                'count' => $dayItems->count(),
                'amount' => (float) $dayItems->sum('subtotal'),
            ];
        }

        // Monthly revenue
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthItems = OrderItem::whereIn('product_id', $productIds)
                ->whereHas('order', fn($q) => $q->whereNotIn('status', ['cancelled', 'pending']))
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year);
            $monthlyRevenue[] = [
                'month' => $date->format('F Y'),
                'count' => $monthItems->count(),
                'amount' => (float) $monthItems->sum('subtotal'),
            ];
        }

        // Products list
        $products = Product::where('user_id', $user->id)->orderBy('name')->get();

        // Order items
        $orderItems = OrderItem::with(['order.user', 'product'])
            ->whereIn('product_id', $productIds)
            ->whereHas('order', function($q) {
                $q->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
            })
            ->latest()
            ->get();

        $pdf = Pdf::loadView('pedagang.reports.sales', compact(
            'currentMonth',
            'storeName',
            'revenue',
            'stats',
            'topProducts',
            'dailyRevenue',
            'monthlyRevenue',
            'products',
            'orderItems'
        ));

        $pdf->setPaper('a4', 'portrait');
        
        $filename = 'laporan_penjualan_' . str_replace(' ', '_', strtolower($storeName)) . '_' . now()->format('Y-m') . '.pdf';
        $pdfContent = $pdf->output();
        
        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"; filename*=UTF-8\'\'"' . rawurlencode($filename) . '"')
            ->header('Content-Length', strlen($pdfContent))
            ->header('X-Download-Filename', $filename)
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}

