<?php

namespace App\Http\Controllers\Pedagang;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Get reviews for this pedagang's products
        $query = Review::with(['user', 'product', 'order'])
            ->whereHas('product', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by product
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $reviews = $query->latest()->paginate(15);

        // Get stats
        $stats = [
            'total' => Review::whereHas('product', fn($q) => $q->where('user_id', $user->id))->count(),
            'average' => Review::whereHas('product', fn($q) => $q->where('user_id', $user->id))->avg('rating') ?? 0,
            'count_5' => Review::whereHas('product', fn($q) => $q->where('user_id', $user->id))->where('rating', 5)->count(),
            'count_4' => Review::whereHas('product', fn($q) => $q->where('user_id', $user->id))->where('rating', 4)->count(),
            'count_3' => Review::whereHas('product', fn($q) => $q->where('user_id', $user->id))->where('rating', 3)->count(),
            'count_2' => Review::whereHas('product', fn($q) => $q->where('user_id', $user->id))->where('rating', 2)->count(),
            'count_1' => Review::whereHas('product', fn($q) => $q->where('user_id', $user->id))->where('rating', 1)->count(),
        ];

        // Get products for filter dropdown
        $products = $user->products()->withCount('reviews')->get();

        return view('pedagang.reviews.index', compact('reviews', 'stats', 'products'));
    }
}
