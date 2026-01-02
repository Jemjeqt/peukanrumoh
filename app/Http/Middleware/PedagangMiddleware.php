<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PedagangMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isPedagang()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Pedagang access required.'], 403);
            }
            return redirect()->route('home')->with('error', 'Akses ditolak. Anda harus login sebagai Pedagang.');
        }

        return $next($request);
    }
}
