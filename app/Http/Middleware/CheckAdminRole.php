<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in and has admin role
        if (!auth()->check()) {
            return redirect()->route('AuthLogin')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (auth()->user()->roles !== 'admin') {
            abort(403, 'Access denied. Administrator access required.');
        }

        return $next($request);
    }
}
