<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    /**
     * Show user profile.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get stats based on role
        $stats = [];
        if ($user->isPembeli()) {
            $stats['total_orders'] = Order::where('user_id', $user->id)->count();
            $stats['total_spent'] = Order::where('user_id', $user->id)
                ->where('status', 'completed')
                ->sum('total');
        }
        
        $orders = Order::where('user_id', $user->id)
            ->with('items.product')
            ->latest()
            ->paginate(5);

        // Use dashboard layout for admin, pedagang, kurir
        if ($user->isAdmin() || $user->isPedagang() || $user->isKurir()) {
            return view('profile.dashboard', compact('user', 'orders', 'stats'));
        }

        return view('profile.index', compact('user', 'orders', 'stats'));
    }

    /**
     * Update profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ];

        // Add store validation for pedagang
        if ($user->isPedagang()) {
            $rules['store_name'] = ['required', 'string', 'max:255'];
            $rules['store_description'] = ['nullable', 'string', 'max:1000'];
            $rules['store_logo'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
        }

        $validated = $request->validate($rules);

        // Handle store logo upload
        if ($request->hasFile('store_logo')) {
            // Delete old logo
            if ($user->store_logo) {
                Storage::disk('public')->delete($user->store_logo);
            }
            $validated['store_logo'] = $request->file('store_logo')->store('store-logos', 'public');
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
}
