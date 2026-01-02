<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'pending_pickup' => Order::where('kurir_id', $user->id)->where('status', 'ready_pickup')->count(),
            'in_delivery' => Order::where('kurir_id', $user->id)->where('status', 'shipped')->count(),
            'completed_today' => Order::where('kurir_id', $user->id)
                ->where('status', 'completed')
                ->whereDate('delivered_at', today())
                ->count(),
            'total_completed' => Order::where('kurir_id', $user->id)->where('status', 'completed')->count(),
            'total_earnings' => Order::where('kurir_id', $user->id)
                ->where('status', 'completed')
                ->sum('shipping_cost') ?: 0,
            'earnings_today' => Order::where('kurir_id', $user->id)
                ->where('status', 'completed')
                ->whereDate('delivered_at', today())
                ->sum('shipping_cost') ?: 0,
            'returns' => \App\Models\ProductReturn::where('kurir_id', $user->id)
                ->whereIn('status', ['pickup', 'delivering'])
                ->count()
                + \App\Models\ProductReturn::where('replacement_kurir_id', $user->id)
                ->where('status', 'replacement_shipping')
                ->count(),
        ];

        // Pending pickups
        $pendingPickups = Order::with(['user', 'items.product'])
            ->where('kurir_id', $user->id)
            ->where('status', 'ready_pickup')
            ->latest()
            ->limit(5)
            ->get();

        // In delivery
        $inDelivery = Order::with(['user', 'items.product'])
            ->where('kurir_id', $user->id)
            ->where('status', 'shipped')
            ->latest()
            ->limit(5)
            ->get();

        return view('kurir.dashboard', compact('stats', 'pendingPickups', 'inDelivery'));
    }
}
