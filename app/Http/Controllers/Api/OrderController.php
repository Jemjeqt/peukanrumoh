<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Get all orders for the authenticated user.
     */
    public function index()
    {
        $orders = Order::with('items')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    /**
     * Create a new order (checkout).
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cash,bank_transfer,e_wallet',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang Anda kosong!',
            ], 422);
        }

        // Validate stock for all items
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok produk '{$item->product->name}' tidak mencukupi. Stok tersedia: {$item->product->stock}",
                ], 422);
            }
        }

        $subtotal = $cartItems->sum(fn($item) => $item->subtotal);
        $adminFee = Order::ADMIN_FEE;
        $shippingCost = Order::SHIPPING_COST;

        try {
            $order = DB::transaction(function () use ($request, $cartItems, $subtotal, $adminFee, $shippingCost) {
                // Create Order
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'total' => $subtotal,
                    'shipping_cost' => $shippingCost,
                    'admin_fee' => $adminFee,
                    'status' => 'pending',
                    'payment_method' => $request->payment_method,
                    'shipping_address' => $request->shipping_address,
                    'phone' => $request->phone,
                    'notes' => $request->notes,
                ]);

                // Create Order Items
                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                        'subtotal' => $item->subtotal,
                    ]);

                    // Reduce stock
                    $item->product->decrement('stock', $item->quantity);
                }

                // Clear cart
                Cart::where('user_id', auth()->id())->delete();

                return $order->load('items');
            });

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'data' => $order,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get order detail.
     */
    public function show(Order $order)
    {
        // Verify ownership
        if ($order->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $order->load('items');

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    /**
     * Confirm payment for pending order.
     */
    public function confirmPayment(Order $order)
    {
        // Verify ownership
        if ($order->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        // Only pending orders can be paid
        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan ini sudah dibayar atau dibatalkan',
            ], 422);
        }

        // Simulate payment processing
        $order->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil',
            'data' => $order->load('items'),
        ]);
    }
}
