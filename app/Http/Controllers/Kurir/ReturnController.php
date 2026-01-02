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
        // Allow access if assigned as pickup kurir OR replacement kurir
        if ($return->kurir_id !== auth()->id() && $return->replacement_kurir_id !== auth()->id()) {
            abort(403);
        }

        $return->load(['user', 'order.items.product']);

        return view('kurir.returns.show', compact('return'));
    }

    // Pickup return from buyer -> deliver to pedagang
    public function pickup(ProductReturn $return)
    {
        if ($return->kurir_id !== auth()->id()) {
            abort(403);
        }

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
        if ($return->kurir_id !== auth()->id()) {
            abort(403);
        }

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
        if ($return->replacement_kurir_id !== auth()->id()) {
            abort(403);
        }

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

