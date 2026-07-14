<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        // If user is logged in AND is an admin, let them proceed
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Otherwise, send them away (e.g., to customer dashboard or login)
        return redirect('/dashboard')->with('error', 'Access denied. Admins only!');
    }
}
