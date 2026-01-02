<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'kurir', 'items.product']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by order ID or user
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.orders.partials.table', compact('orders'))->render(),
            ]);
        }

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'kurir', 'items.product']);

        if (request()->ajax()) {
            return response()->json(['order' => $order]);
        }

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,processing,ready_pickup,shipped,completed,cancelled',
        ]);

        $order->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diupdate',
                'order' => $order
            ]);
        }

        return back()->with('success', 'Status pesanan berhasil diupdate');
    }
}
