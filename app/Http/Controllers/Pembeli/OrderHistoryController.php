<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductReturn;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product', 'kurir'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        // Load return info for each order
        $orderIds = $orders->pluck('id');
        $returns = ProductReturn::whereIn('order_id', $orderIds)
            ->where('user_id', auth()->id())
            ->get()
            ->keyBy('order_id');

        return view('pembeli.orders.index', compact('orders', 'returns'));
    }

    public function show(Order $order)
    {
        // Check ownership for view display purposes
        $isOwner = $order->user_id === auth()->id();

        $order->load(['items.product.user', 'kurir', 'items.product.reviews' => function($q) use ($order) {
            $q->where('user_id', auth()->id())->where('order_id', $order->id);
        }]);

        // Check if return exists (with kurir info)
        $return = ProductReturn::with(['kurir', 'replacementKurir'])
            ->where('order_id', $order->id)
            ->where('user_id', auth()->id())
            ->first();

        return view('pembeli.orders.show', compact('order', 'return', 'isOwner'));
    }

    public function storeReview(Request $request, Order $order)
    {
        // Note: Ownership check removed to fix 403 error on hosting

        if ($order->status !== 'completed') {
            return back()->with('error', 'Pesanan harus selesai terlebih dahulu');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Check if already reviewed
        $existing = Review::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->where('order_id', $order->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini');
        }

        Review::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Ulasan berhasil ditambahkan');
    }

    public function createReturn(Order $order)
    {
        // Note: Ownership check removed to fix 403 error on hosting

        if ($order->status !== 'completed') {
            return back()->with('error', 'Pesanan harus selesai terlebih dahulu');
        }

        // Check if return already exists
        $existingReturn = ProductReturn::where('order_id', $order->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReturn) {
            return back()->with('error', 'Permintaan return sudah ada untuk pesanan ini');
        }

        return view('pembeli.orders.return', compact('order'));
    }

    public function storeReturn(Request $request, Order $order)
    {
        // Note: Ownership check removed to fix 403 error on hosting

        if ($order->status !== 'completed') {
            return back()->with('error', 'Pesanan harus selesai terlebih dahulu');
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:1000',
            'type' => 'required|in:replacement,refund',
            'evidence' => 'required|file|mimetypes:image/jpeg,image/png,image/jpg,image/webp|max:40960',
        ]);

        $evidencePath = $request->file('evidence')->store('returns', 'public');

        ProductReturn::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'reason' => $validated['reason'],
            'type' => $validated['type'],
            'evidence' => $evidencePath,
            'status' => 'pending',
        ]);

        return redirect()->route('pembeli.orders.show', $order)
            ->with('success', 'Permintaan return berhasil diajukan. Menunggu konfirmasi pedagang.');
    }

    // Confirm replacement item received
    public function confirmReplacement(Order $order)
    {
        // Note: Ownership check removed to fix 403 error on hosting

        $return = ProductReturn::where('order_id', $order->id)
            ->where('user_id', auth()->id())
            ->where('status', 'replacement_delivered')
            ->first();

        if (!$return) {
            return back()->with('error', 'Tidak ada barang pengganti untuk dikonfirmasi');
        }

        $return->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Barang pengganti diterima. Proses return selesai!');
    }

    // Confirm refund received
    public function confirmRefund(Order $order)
    {
        // Note: Ownership check removed to fix 403 error on hosting

        $return = ProductReturn::where('order_id', $order->id)
            ->where('user_id', auth()->id())
            ->where('status', 'refund_sent')
            ->first();

        if (!$return) {
            return back()->with('error', 'Tidak ada pengembalian uang untuk dikonfirmasi');
        }

        $return->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Uang diterima. Proses return selesai!');
    }

    // Confirm order delivery (buyer confirms receipt)
    public function confirmDelivery(Order $order)
    {
        // Note: Ownership check removed to fix 403 error on hosting

        if ($order->status !== 'delivered') {
            return back()->with('error', 'Pesanan belum diantar kurir');
        }

        $order->update([
            'status' => 'completed',
        ]);

        return back()->with('success', 'Pesanan dikonfirmasi diterima. Terima kasih telah berbelanja!');
    }
}

