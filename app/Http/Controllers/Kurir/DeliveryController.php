<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Order::with(['user', 'items.product'])
            ->where('kurir_id', $user->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default: show active deliveries
            $query->whereIn('status', ['ready_pickup', 'shipped']);
        }

        $orders = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('kurir.deliveries.partials.table', compact('orders'))->render(),
            ]);
        }

        return view('kurir.deliveries.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->kurir_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['user', 'items.product']);

        return view('kurir.deliveries.show', compact('order'));
    }

    public function pickup(Order $order)
    {
        if ($order->kurir_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'ready_pickup') {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak dalam status siap pickup'], 400);
            }
            return back()->with('error', 'Pesanan tidak dapat diambil');
        }

        $order->update([
            'status' => 'shipped',
            'picked_up_at' => now(),
        ]);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pesanan berhasil diambil, sedang dalam pengiriman']);
        }

        return back()->with('success', 'Pesanan berhasil diambil');
    }

    public function deliver(Order $order)
    {
        if ($order->kurir_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'shipped') {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak dalam status pengiriman'], 400);
            }
            return back()->with('error', 'Pesanan tidak dapat diselesaikan');
        }

        $order->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pesanan diantar, menunggu konfirmasi pembeli']);
        }

        return back()->with('success', 'Pesanan diantar, menunggu konfirmasi pembeli');
    }

    public function history(Request $request)
    {
        $user = auth()->user();

        // Completed deliveries
        $orders = Order::with(['user', 'items.product'])
            ->where('kurir_id', $user->id)
            ->where('status', 'completed')
            ->latest('delivered_at')
            ->paginate(10);

        // Completed returns (pickup return OR replacement delivery)
        $returns = \App\Models\ProductReturn::with(['order.user', 'order.items.product'])
            ->where(function($q) use ($user) {
                $q->where('kurir_id', $user->id)
                  ->whereIn('status', ['received', 'replacement_sent', 'refund_sent', 'completed']);
            })
            ->orWhere(function($q) use ($user) {
                $q->where('replacement_kurir_id', $user->id)
                  ->whereIn('status', ['replacement_delivered', 'completed']);
            })
            ->latest()
            ->get();

        return view('kurir.deliveries.history', compact('orders', 'returns'));
    }
}
