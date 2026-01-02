<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\ProductReturn;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats
        $stats = [
            'total_pembeli' => User::where('role', 'pembeli')->count(),
            'total_pedagang' => User::where('role', 'pedagang')->count(),
            'total_kurir' => User::where('role', 'kurir')->count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
            'admin_revenue' => Order::where('status', '!=', 'cancelled')->sum('admin_fee'),
            'pending_approvals' => User::where('is_approved', false)->count(),
        ];

        // Recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        // Orders by status - return as array with status and total keys for JS Chart
    $ordersByStatus = Order::select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->get()
        ->toArray();

        // Daily sales for last 7 days
        $dailySales = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Low stock products
        $lowStockProducts = Product::with('user')
            ->where('stock', '<=', 5)
            ->where('stock', '>', 0)
            ->limit(5)
            ->get();

        // Pending user approvals
        $pendingUsers = User::where('is_approved', false)
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'ordersByStatus',
            'dailySales',
            'lowStockProducts',
            'pendingUsers'
        ));
    }
    /**
     * Export laporan bulanan platform sebagai PDF
     */
    public function exportReport()
    {
        $currentMonth = now()->format('F Y');
        
        // Stats
        $stats = [
            'total_pembeli' => User::where('role', 'pembeli')->count(),
            'total_pedagang' => User::where('role', 'pedagang')->count(),
            'total_kurir' => User::where('role', 'kurir')->count(),
            'total_products' => Product::count(),
        ];

        // Monthly stats
        $monthlyOrders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', '!=', 'cancelled');
        
        $monthlyStats = [
            'order_count' => $monthlyOrders->count(),
            'total_revenue' => (float) $monthlyOrders->sum('total'),
            'admin_fee' => (float) $monthlyOrders->sum('admin_fee'),
            'shipping_cost' => (float) $monthlyOrders->sum('shipping_cost'),
        ];

        // Orders by status
        $statusLabels = [
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'processing' => 'Diproses',
            'ready_pickup' => 'Siap Diambil Kurir',
            'shipped' => 'Dalam Pengiriman',
            'delivered' => 'Menunggu Konfirmasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $ordersByStatus = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->select('status', DB::raw('count(*) as total'), DB::raw('SUM(total) as nilai'))
            ->groupBy('status')
            ->get()
            ->map(function($order) use ($statusLabels) {
                return [
                    'label' => $statusLabels[$order->status] ?? ucfirst($order->status),
                    'total' => $order->total,
                    'nilai' => (float) $order->nilai,
                ];
            });

        // Pedagang Revenue
        $pedagangRevenue = User::where('role', 'pedagang')
            ->where('is_approved', true)
            ->get()
            ->map(function($pedagang) {
                $productIds = Product::where('user_id', $pedagang->id)->pluck('id');
                $revenue = OrderItem::whereIn('product_id', $productIds)
                    ->whereHas('order', function($q) {
                        $q->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year)
                          ->whereNotIn('status', ['cancelled', 'pending']);
                    })
                    ->sum('subtotal');
                $soldCount = OrderItem::whereIn('product_id', $productIds)
                    ->whereHas('order', function($q) {
                        $q->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year)
                          ->whereNotIn('status', ['cancelled', 'pending']);
                    })
                    ->sum('quantity');
                return [
                    'name' => $pedagang->name,
                    'email' => $pedagang->email,
                    'sold' => $soldCount,
                    'revenue' => (float) $revenue,
                ];
            })
            ->sortByDesc('revenue')
            ->values();

        // Return stats
        $monthlyReturns = ProductReturn::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
        
        $returnStats = [
            'total' => $monthlyReturns->count(),
            'approved' => (clone $monthlyReturns)->whereNotIn('status', ['pending', 'rejected'])->count(),
            'rejected' => (clone $monthlyReturns)->where('status', 'rejected')->count(),
            'completed' => (clone $monthlyReturns)->where('status', 'completed')->count(),
            'replacement' => (clone $monthlyReturns)->where('type', 'replacement')->count(),
            'refund' => (clone $monthlyReturns)->where('type', 'refund')->count(),
        ];

        // Review stats  
        $monthlyReviews = Review::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
        
        $reviewStats = [
            'total' => $monthlyReviews->count(),
            'average' => (float) ($monthlyReviews->avg('rating') ?? 0),
        ];
        for($i = 5; $i >= 1; $i--) {
            $reviewStats['rating_' . $i] = (clone $monthlyReviews)->where('rating', $i)->count();
        }

        // Top products
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
            ->whereHas('order', function($q) {
                $q->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year)
                  ->whereNotIn('status', ['cancelled', 'pending']);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->with('product.pedagang')
            ->get();

        // Recent orders
        $recentOrders = Order::with('user')->latest()->limit(20)->get();

        $pdf = Pdf::loadView('admin.reports.monthly', compact(
            'currentMonth',
            'stats',
            'monthlyStats',
            'ordersByStatus',
            'pedagangRevenue',
            'returnStats',
            'reviewStats',
            'topProducts',
            'recentOrders'
        ));

        $pdf->setPaper('a4', 'portrait');
        
        $filename = 'laporan_peukan_rumoh_' . now()->format('Y-m') . '.pdf';
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
