<?php

namespace App\Http\Controllers\Pedagang;

use App\Http\Controllers\Controller;
use App\Models\ProductReturn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductReturn::with(['user', 'order']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $returns = $query->latest()->paginate(10);

        return view('pedagang.returns.index', compact('returns'));
    }

    public function show(ProductReturn $return)
    {
        $return->load(['user', 'order.items.product', 'kurir', 'replacementKurir']);

        // Get kurirs for assignment
        $kurirs = User::where('role', 'kurir')->where('is_approved', true)->get();

        return view('pedagang.returns.show', compact('return', 'kurirs'));
    }

    public function approve(Request $request, ProductReturn $return)
    {
        if ($return->status !== 'pending') {
            return back()->with('error', 'Permintaan return tidak dalam status menunggu');
        }

        $validated = $request->validate([
            'kurir_id' => 'required|exists:users,id',
        ]);

        $return->update([
            'status' => 'pickup',
            'kurir_id' => $validated['kurir_id'],
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Return disetujui, menunggu kurir mengambil barang');
    }

    public function reject(Request $request, ProductReturn $return)
    {
        if ($return->status !== 'pending') {
            return back()->with('error', 'Permintaan return tidak dalam status menunggu');
        }

        $validated = $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $return->update([
            'status' => 'rejected',
            'admin_notes' => $validated['admin_notes'],
        ]);

        return back()->with('success', 'Permintaan return ditolak');
    }

    // For REPLACEMENT: Send replacement item via kurir
    public function sendReplacement(Request $request, ProductReturn $return)
    {
        if ($return->status !== 'received' || $return->type !== 'replacement') {
            return back()->with('error', 'Status tidak valid untuk mengirim barang pengganti');
        }

        $validated = $request->validate([
            'replacement_kurir_id' => 'required|exists:users,id',
        ]);

        $return->update([
            'status' => 'replacement_shipping',
            'replacement_kurir_id' => $validated['replacement_kurir_id'],
            'replacement_shipped_at' => now(),
        ]);

        return back()->with('success', 'Barang pengganti dikirim. Menunggu kurir mengantarkan ke pembeli.');
    }

    // For REFUND: Send money and upload proof
    public function sendRefund(Request $request, ProductReturn $return)
    {
        if ($return->status !== 'received' || $return->type !== 'refund') {
            return back()->with('error', 'Status tidak valid untuk mengirim pengembalian uang');
        }

        $validated = $request->validate([
            'refund_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $proofPath = $request->file('refund_proof')->store('refund_proofs', 'public');

        $return->update([
            'status' => 'refund_sent',
            'refund_proof' => $proofPath,
            'refund_sent_at' => now(),
        ]);

        return back()->with('success', 'Bukti transfer dikirim. Menunggu konfirmasi pembeli.');
    }
}

