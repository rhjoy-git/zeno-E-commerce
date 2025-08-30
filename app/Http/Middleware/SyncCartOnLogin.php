<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SyncCartOnLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Session::has('cart')) {
            // Get the cart controller instance
            $cartController = app()->make('App\Http\Controllers\Customer\CartController');
            
            // Sync the cart
            $cartController->syncCart();
        }

        return $next($request);
    }
}