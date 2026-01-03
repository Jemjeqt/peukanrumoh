<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['pedagang'])->active()->inStock();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $products = $query->latest()->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function show(Product $product)
    {
        $product->load(['pedagang']);

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->isPedagang()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['user_id'] = $user->id;
        $validated['is_active'] = $request->boolean('is_active', true);

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan',
            'data' => $product,
        ], 201);
    }

    public function update(Request $request, Product $product)
    {
        $user = $request->user();

        if (!$user->isPedagang() || $product->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'category' => 'sometimes|required|string|max:100',
            'is_active' => 'boolean',
        ]);

        if ($request->has('is_active')) {
            $validated['is_active'] = $request->boolean('is_active');
        }

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diupdate',
            'data' => $product,
        ]);
    }

    public function destroy(Request $request, Product $product)
    {
        $user = $request->user();

        if (!$user->isPedagang() || $product->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($product->image && !str_starts_with($product->image, 'http') && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus',
        ]);
    }

    public function uploadImage(Request $request, Product $product)
    {
        $user = $request->user();

        if (!$user->isPedagang() || $product->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        // Delete old image
        if ($product->image && !str_starts_with($product->image, 'http') && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $path = $request->file('image')->store('products', 'public');
        $product->update(['image' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Gambar berhasil diupload',
            'data' => [
                'image' => $path,
                'image_url' => asset('storage/' . $path),
            ],
        ]);
    }
}
