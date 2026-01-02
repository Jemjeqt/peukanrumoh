<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KurirMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isKurir()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Kurir access required.'], 403);
            }
            return redirect()->route('home')->with('error', 'Akses ditolak. Anda harus login sebagai Kurir.');
        }

        return $next($request);
    }
}
