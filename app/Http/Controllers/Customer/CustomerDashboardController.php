<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerDashboardController extends Controller
{
    public function dashboard()
    {
        // Logic for customer dashboard
        $customer = Auth::user();
        return view('customer.dashboard', compact('customer'));
    }
}
