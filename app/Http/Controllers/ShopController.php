<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display the shop homepage with products.
     */
    public function index(Request $request)
    {
        $query = Product::active()->inStock();
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        $products = $query->with('pedagang')->latest()->paginate(12);
        $categories = Product::active()->distinct()->pluck('category');
        
        return view('shop.index', compact('products', 'categories'));
    }

    /**
     * Display a single product.
     */
    public function show(Product $product)
    {
        // Load reviews with user data
        $product->load(['reviews.user', 'pedagang']);
        
        // Calculate sold count from completed orders
        $soldCount = \App\Models\OrderItem::where('product_id', $product->id)
            ->whereHas('order', function($q) {
                $q->where('status', 'completed');
            })
            ->sum('quantity');
        
        // Calculate average rating
        $avgRating = $product->reviews->avg('rating') ?? 0;
        $reviewCount = $product->reviews->count();
        
        $relatedProducts = Product::active()
            ->inStock()
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
            
        return view('shop.show', compact('product', 'relatedProducts', 'soldCount', 'avgRating', 'reviewCount'));
    }
}
