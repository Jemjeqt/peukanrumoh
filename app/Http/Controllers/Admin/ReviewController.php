<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        // Get overall stats
        $stats = [
            'total' => Review::count(),
            'average' => Review::avg('rating') ?? 0,
            'count_5' => Review::where('rating', 5)->count(),
            'count_4' => Review::where('rating', 4)->count(),
            'count_3' => Review::where('rating', 3)->count(),
            'count_2' => Review::where('rating', 2)->count(),
            'count_1' => Review::where('rating', 1)->count(),
        ];
        
        // Get reviews with filters
        $query = Review::with(['user', 'product', 'order']);
        
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        
        $reviews = $query->latest()->paginate(20);
        
        // Get all products for filter dropdown (that have at least 1 review)
        $products = Product::whereHas('reviews')
            ->withCount('reviews')
            ->orderBy('name')
            ->get();
        
        return view('admin.reviews.index', compact('reviews', 'stats', 'products'));
    }
}
