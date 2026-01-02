<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by approval status
        if ($request->filled('approved')) {
            $query->where('is_approved', $request->approved === 'yes');
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.users.partials.table', compact('users'))->render(),
                'pagination' => $users->links()->render()
            ]);
        }

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:pembeli,pedagang,kurir,admin',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'is_approved' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_approved'] = $request->boolean('is_approved', true);

        $user = User::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan',
                'user' => $user
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        if (request()->ajax()) {
            return response()->json(['user' => $user]);
        }
        return view('admin.users.edit', compact('user'));
    }

    public function show(User $user)
    {
        $user->loadCount(['products', 'orders']);
        return view('admin.users.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:pembeli,pedagang,kurir,admin',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'is_approved' => 'boolean',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_approved'] = $request->boolean('is_approved');

        $user->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diupdate',
                'user' => $user
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus akun sendiri'], 403);
            }
            return back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        try {
            $user->delete();
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus user karena masih memiliki data terkait (produk, pesanan, dll)'], 400);
            }
            return back()->with('error', 'Tidak dapat menghapus user karena masih memiliki data terkait (produk, pesanan, dll)');
        }

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'User berhasil dihapus']);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }

    public function approve(User $user)
    {
        $user->update(['is_approved' => true]);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'User berhasil disetujui']);
        }

        return back()->with('success', 'User berhasil disetujui');
    }

    public function reject(User $user)
    {
        $user->update(['is_approved' => false]);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Persetujuan user dicabut']);
        }

        return back()->with('success', 'Persetujuan user dicabut');
    }
}
