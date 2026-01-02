<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Show checkout form.
     */
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->subtotal);
        $adminFee = Order::ADMIN_FEE;
        $shippingCost = Order::SHIPPING_COST;
        $total = $subtotal + $adminFee + $shippingCost;

        return view('checkout.index', compact('cartItems', 'subtotal', 'adminFee', 'shippingCost', 'total'));
    }

    /**
     * Process checkout.
     */
    public function process(Request $request)
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
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->subtotal);
        $adminFee = Order::ADMIN_FEE;
        $shippingCost = Order::SHIPPING_COST;
        $total = $subtotal + $adminFee + $shippingCost;

        DB::transaction(function () use ($request, $cartItems, $subtotal, $adminFee, $shippingCost) {
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

            // Store order ID in session for payment demo
            session(['pending_order_id' => $order->id]);
        });

        return redirect()->route('checkout.payment');
    }

    /**
     * Show payment demo page.
     */
    public function payment()
    {
        $orderId = session('pending_order_id');
        
        if (!$orderId) {
            return redirect()->route('home')->with('error', 'No pending order found!');
        }

        $order = Order::with('items')->findOrFail($orderId);

        return view('checkout.payment', compact('order'));
    }

    /**
     * Process payment (demo).
     */
    public function confirmPayment(Request $request)
    {
        $orderId = session('pending_order_id');
        
        if (!$orderId) {
            return redirect()->route('home')->with('error', 'No pending order found!');
        }

        $order = Order::findOrFail($orderId);
        
        // Simulate payment processing
        $order->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        session()->forget('pending_order_id');

        return redirect()->route('checkout.success', $order)->with('success', 'Payment successful!');
    }

    /**
     * Show success page.
     */
    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * Pay for existing pending order (from order history).
     */
    public function payOrder(Order $order)
    {
        // Verify ownership
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Only pending orders can be paid
        if ($order->status !== 'pending') {
            return redirect()->route('pembeli.orders.show', $order)
                ->with('error', 'Pesanan ini sudah dibayar atau dibatalkan');
        }
        
        // Set order in session for payment confirmation
        session(['pending_order_id' => $order->id]);
        
        $order->load('items');
        return view('checkout.payment', compact('order'));
    }
}
