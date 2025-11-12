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
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('AuthLogin')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();
        
        // Check if user has admin role (handle null case)
        if (!$user->roles || $user->roles !== 'admin') {
            abort(403, 'Access denied. Administrator access required.');
        }

        // Check if user account is active
        if ($user->status !== 'aktif') {
            auth()->logout();
            return redirect()->route('AuthLogin')->with('error', 'Akun Anda tidak aktif. Hubungi administrator.');
        }

        return $next($request);
    }
}
