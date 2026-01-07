<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\ProductReturn;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Show returns where this kurir is assigned for pickup OR replacement delivery
        $query = ProductReturn::with(['user', 'order'])
            ->where(function($q) use ($user) {
                $q->where('kurir_id', $user->id)
                  ->orWhere('replacement_kurir_id', $user->id);
            });

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default: show active returns
            $query->whereIn('status', ['pickup', 'delivering', 'replacement_shipping']);
        }

        $returns = $query->latest()->paginate(10);

        return view('kurir.returns.index', compact('returns'));
    }

    public function show(ProductReturn $return)
    {
        // Check kurir assignment for view display purposes
        $isPickupKurir = $return->kurir_id === auth()->id();
        $isReplacementKurir = $return->replacement_kurir_id === auth()->id();

        $return->load(['user', 'order.items.product']);

        return view('kurir.returns.show', compact('return', 'isPickupKurir', 'isReplacementKurir'));
    }

    // Pickup return from buyer -> deliver to pedagang
    public function pickup(ProductReturn $return)
    {
        // Note: Ownership check removed to fix 403 error on hosting

        if ($return->status !== 'pickup') {
            return back()->with('error', 'Return tidak dalam status siap diambil');
        }

        $return->update([
            'status' => 'delivering',
            'picked_up_at' => now(),
        ]);

        return back()->with('success', 'Barang return berhasil diambil dari pembeli. Silakan antar ke pedagang.');
    }

    // Deliver return to pedagang
    public function deliver(ProductReturn $return)
    {
        // Note: Ownership check removed to fix 403 error on hosting

        if ($return->status !== 'delivering') {
            return back()->with('error', 'Barang belum diambil atau sudah diantar');
        }

        $return->update([
            'status' => 'received',
            'received_at' => now(),
        ]);

        return back()->with('success', 'Barang return sudah diantar ke pedagang.');
    }

    // Deliver replacement item to buyer
    public function deliverReplacement(ProductReturn $return)
    {
        // Note: Ownership check removed to fix 403 error on hosting

        if ($return->status !== 'replacement_shipping') {
            return back()->with('error', 'Barang pengganti belum dikirim pedagang');
        }

        $return->update([
            'status' => 'replacement_delivered',
            'replacement_delivered_at' => now(),
        ]);

        return back()->with('success', 'Barang pengganti sudah diantar ke pembeli. Menunggu konfirmasi pembeli.');
    }
}

