<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sudah terautentikasi dan memiliki role 'admin'
        if (!$request->user() || $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Access denied. Admin only'], 403);
        }

        return $next($request);
    }
}
