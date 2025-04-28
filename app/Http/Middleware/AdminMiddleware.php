<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role->slug === 'admin') {
            return $next($request);
        }

        abort(403, 'Unauthorized access. Administrator privileges required.');
    }
}