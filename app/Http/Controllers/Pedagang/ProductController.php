<?php

namespace App\Http\Controllers\Pedagang;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('user_id', auth()->id());

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->paginate(10);
        $categories = Product::where('user_id', auth()->id())
            ->distinct()
            ->pluck('category');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('pedagang.products.partials.table', compact('products'))->render(),
            ]);
        }

        return view('pedagang.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->orderBy('name')->pluck('name')->toArray();
        
        return view('pedagang.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'is_active' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan',
                'product' => $product
            ]);
        }

        return redirect()->route('pedagang.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function show(Product $product)
    {
        // Ensure pedagang only views their own products
        if ((int) $product->user_id !== (int) auth()->id()) {
            abort(403);
        }

        $product->load('reviews.user', 'orderItems');
        
        // Get sales stats
        $totalSold = $product->orderItems->sum('quantity');
        $totalRevenue = $product->orderItems->sum(fn($item) => $item->quantity * $item->price);
        $avgRating = $product->reviews->avg('rating');

        return view('pedagang.products.show', compact('product', 'totalSold', 'totalRevenue', 'avgRating'));
    }

    public function edit(Product $product)
    {
        // Ensure pedagang only edits their own products
        if ((int) $product->user_id !== (int) auth()->id()) {
            abort(403);
        }

        $categories = Category::active()->orderBy('name')->pluck('name')->toArray();

        if (request()->ajax()) {
            return response()->json([
                'product' => $product,
                'categories' => $categories
            ]);
        }

        return view('pedagang.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ((int) $product->user_id !== (int) auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && !str_starts_with($product->image, 'http') && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diupdate',
                'product' => $product
            ]);
        }

        return redirect()->route('pedagang.products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy(Product $product)
    {
        if ((int) $product->user_id !== (int) auth()->id()) {
            abort(403);
        }

        if ($product->image && !str_starts_with($product->image, 'http') && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus']);
        }

        return redirect()->route('pedagang.products.index')->with('success', 'Produk berhasil dihapus');
    }
}
