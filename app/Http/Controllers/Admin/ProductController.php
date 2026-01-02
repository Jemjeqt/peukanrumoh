<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products (monitoring only).
     */
    public function index(Request $request)
    {
        $query = Product::with(['pedagang']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by pedagang
        if ($request->filled('pedagang')) {
            $query->where('user_id', $request->pedagang);
        }

        $products = $query->latest()->paginate(15);
        
        // Get categories for filter
        $categories = Product::distinct()->pluck('category');

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product (monitoring only).
     */
    public function show(Product $product)
    {
        $product->load(['pedagang', 'reviews.user']);
        
        return view('admin.products.show', compact('product'));
    }
}
