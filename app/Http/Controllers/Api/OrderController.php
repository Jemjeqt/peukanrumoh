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
        $orders = Order::with(['items', 'productReturn'])
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
        // Verify ownership - use intval to ensure type consistency
        $orderUserId = intval($order->user_id);
        $authUserId = intval(auth()->id());
        
        if ($orderUserId !== $authUserId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
                'debug' => [
                    'order_user_id' => $orderUserId,
                    'auth_user_id' => $authUserId,
                ],
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
        // Verify ownership - use intval to ensure type consistency
        $orderUserId = intval($order->user_id);
        $authUserId = intval(auth()->id());
        
        if ($orderUserId !== $authUserId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
                'debug' => [
                    'order_user_id' => $orderUserId,
                    'auth_user_id' => $authUserId,
                ],
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

    /**
     * Confirm order delivery (buyer confirms receipt).
     */
    public function confirmDelivery(Order $order)
    {
        $orderUserId = intval($order->user_id);
        $authUserId = intval(auth()->id());
        
        if ($orderUserId !== $authUserId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        if ($order->status !== 'delivered') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan belum diantar kurir',
            ], 422);
        }

        $order->update([
            'status' => 'completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan dikonfirmasi diterima. Terima kasih telah berbelanja!',
            'data' => $order->load('items'),
        ]);
    }

    /**
     * Store review for products in order.
     */
    public function storeReview(Request $request, Order $order)
    {
        $orderUserId = intval($order->user_id);
        $authUserId = intval(auth()->id());
        
        if ($orderUserId !== $authUserId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        if ($order->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan harus selesai terlebih dahulu',
            ], 422);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Check if already reviewed
        $existing = \App\Models\Review::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->where('order_id', $order->id)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan ulasan untuk produk ini',
            ], 422);
        }

        $review = \App\Models\Review::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil ditambahkan',
            'data' => $review,
        ]);
    }

    /**
     * Create return request.
     */
    public function storeReturn(Request $request, Order $order)
    {
        $orderUserId = intval($order->user_id);
        $authUserId = intval(auth()->id());
        
        if ($orderUserId !== $authUserId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        if ($order->status !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan harus selesai terlebih dahulu',
            ], 422);
        }

        // Check if return already exists
        $existingReturn = \App\Models\ProductReturn::where('order_id', $order->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReturn) {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan return sudah ada untuk pesanan ini',
            ], 422);
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:1000',
            'type' => 'required|in:replacement,refund',
            'evidence' => 'nullable|file|mimetypes:image/jpeg,image/png,image/jpg,image/webp|max:10240',
        ]);

        // Handle evidence file upload
        $evidencePath = null;
        if ($request->hasFile('evidence')) {
            $evidencePath = $request->file('evidence')->store('returns', 'public');
        }

        $return = \App\Models\ProductReturn::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'reason' => $validated['reason'],
            'type' => $validated['type'],
            'evidence' => $evidencePath,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan return berhasil diajukan. Menunggu konfirmasi pedagang.',
            'data' => $return,
        ]);
    }

    /**
     * Confirm replacement received.
     */
    public function confirmReplacement(Order $order)
    {
        $authUserId = intval(auth()->id());
        
        $return = \App\Models\ProductReturn::where('order_id', $order->id)
            ->where('user_id', $authUserId)
            ->where('status', 'replacement_delivered')
            ->first();

        if (!$return) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada barang pengganti untuk dikonfirmasi',
            ], 422);
        }

        $return->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang pengganti diterima. Proses return selesai!',
            'data' => $return,
        ]);
    }

    /**
     * Confirm refund received.
     */
    public function confirmRefund(Order $order)
    {
        $authUserId = intval(auth()->id());
        
        $return = \App\Models\ProductReturn::where('order_id', $order->id)
            ->where('user_id', $authUserId)
            ->where('status', 'refund_sent')
            ->first();

        if (!$return) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada pengembalian uang untuk dikonfirmasi',
            ], 422);
        }

        $return->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Uang diterima. Proses return selesai!',
            'data' => $return,
        ]);
    }
}
