<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role->slug === 'customer') {
            return $next($request);
        }
        
        abort(403, 'Unauthorized access. Customer privileges required.');
    }
}