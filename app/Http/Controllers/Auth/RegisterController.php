<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\CustomerProfile;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            // 'email' => 'required|string|email|max:255|unique:users',
        ]);

        try {
            DB::beginTransaction();
            // $validated['email'] = strtolower($validated['email']);
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => Role::where('slug', 'customer')->first()->id
            ]);

            // // Send welcome email
            // Mail::to($user->email)->send(new WelcomeEmail($user));

            DB::commit();

            Auth::login($user);

            return redirect()->intended($this->redirectPath())->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Registration failed. Please try again later.');
        }
    }
    protected function redirectPath()
    {
        return route('home');
    }
}
