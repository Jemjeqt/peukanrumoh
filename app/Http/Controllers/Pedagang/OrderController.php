<?php

namespace App\Http\Controllers\Pedagang;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Get orders that contain this pedagang's products
        $orderIds = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.user_id', $user->id)
            ->pluck('order_items.order_id')
            ->unique();

        $query = Order::with(['user', 'items.product'])
            ->whereIn('id', $orderIds);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('pedagang.orders.partials.table', compact('orders'))->render(),
            ]);
        }

        return view('pedagang.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $user = auth()->user();

        // Verify this order contains pedagang's products
        $hasProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('order_items.order_id', $order->id)
            ->where('products.user_id', $user->id)
            ->exists();

        if (!$hasProducts) {
            abort(403);
        }

        $order->load(['user', 'items.product']);

        // Get kurirs for assignment
        $kurirs = User::where('role', 'kurir')->where('is_approved', true)->get();

        return view('pedagang.orders.show', compact('order', 'kurirs'));
    }

    public function process(Order $order)
    {
        if ($order->status !== 'paid') {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak dalam status yang tepat'], 400);
            }
            return back()->with('error', 'Pesanan tidak dapat diproses');
        }

        $order->update(['status' => 'processing']);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pesanan sedang diproses']);
        }

        return back()->with('success', 'Pesanan sedang diproses');
    }

    public function readyPickup(Request $request, Order $order)
    {
        if (!in_array($order->status, ['paid', 'processing'])) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Status pesanan tidak valid'], 400);
            }
            return back()->with('error', 'Status pesanan tidak valid');
        }

        $validated = $request->validate([
            'kurir_id' => 'required|exists:users,id',
        ]);

        $order->update([
            'status' => 'ready_pickup',
            'kurir_id' => $validated['kurir_id'],
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pesanan siap diambil kurir']);
        }

        return back()->with('success', 'Pesanan siap diambil kurir');
    }
}
