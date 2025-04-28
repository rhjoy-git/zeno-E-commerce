<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\OtpService;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);
    
        try {
            DB::beginTransaction();
    
            // Create user without logging in yet
            $user = User::create([
                'name' => $validated['name'],
                'email' => strtolower($validated['email']),
                'password' => Hash::make($validated['password']),
                'role_id' => Role::where('slug', 'customer')->first()->id
            ]);

            // Generate and send OTP
            $otpService = new OtpService();
            $otpService->generateAndSendOtp($user);
    
            DB::commit();
    
            // Redirect to OTP verification page
            return redirect()->route('otp.verify', ['email' => $user->email])
                   ->with('success', 'OTP sent to your email!');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Registration failed: '.$e->getMessage());
        }
    }
    protected function redirectPath()
    {
        return route('home');
    }
}
