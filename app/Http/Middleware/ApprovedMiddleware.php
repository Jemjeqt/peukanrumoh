<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApprovedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Admin is always approved
        if (auth()->user()->isAdmin()) {
            return $next($request);
        }

        if (!auth()->user()->is_approved) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akun Anda belum disetujui oleh Admin.'], 403);
            }
            return redirect()->route('home')->with('warning', 'Akun Anda sedang menunggu persetujuan dari Admin.');
        }

        return $next($request);
    }
}
