<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart.
     */
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();
            
        $total = $cartItems->sum(fn($item) => $item->subtotal);
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add item to cart.
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'integer|min:1|max:' . $product->stock,
        ]);

        $quantity = $request->input('quantity', 1);

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => min($cartItem->quantity + $quantity, $product->stock)
            ]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Added to cart!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cart->product->stock,
        ]);

        $cart->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Cart updated!');
    }

    /**
     * Remove item from cart.
     */
    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    /**
     * Clear entire cart.
     */
    public function clear()
    {
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->back()->with('success', 'Cart cleared!');
    }
}
