<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;


class ProfileController extends Controller
{
    public function showProfile(Request $request): View
    {
        if (Gate::allows('isAdmin')) {
            return view('admin.profile.profile', [
                'user' => $request->user(),
            ]);
        }
        return view('customer.profile', [
            'user' => $request->user(),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'phone' => ['nullable', 'string', 'max:20'],
            // 'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
        // if ($request->hasFile('avatar')) {
        //     if ($user->avatar) {
        //         Storage::delete($user->avatar);
        //     }
        //     $path = $request->file('avatar')->store('avatars');
        //     $validatedData['avatar'] = $path;
        // }

        $user->update($validatedData);

        return redirect()->route('profile')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Update password
        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        // Regenerate session ID to prevent session fixation
        $request->session()->regenerate();
        if (Gate::allows('isAdmin')) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Password updated successfully!');
        }
        return redirect()->route('customer.dashboard')
            ->with('success', 'Password updated successfully!');
    }
}
