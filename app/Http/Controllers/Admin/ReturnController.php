<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReturn;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductReturn::with(['user', 'order']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $returns = $query->latest()->paginate(20);
        
        return view('admin.returns.index', compact('returns'));
    }
    
    public function show(ProductReturn $return)
    {
        $return->load(['user', 'order.items.product', 'kurir', 'replacementKurir']);
        
        return view('admin.returns.show', compact('return'));
    }
}
