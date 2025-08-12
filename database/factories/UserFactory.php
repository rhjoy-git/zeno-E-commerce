<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition()
    {
        $customerRole = Role::where('slug', 'customer')->first() ?? Role::factory()->create(['slug' => 'customer']);
        $adminRole = Role::where('slug', 'admin')->first() ?? Role::factory()->create(['slug' => 'admin']);
        $admin = User::where('role_id', $adminRole->id)->inRandomOrder()->first() ?? User::factory()->create(['role_id' => $adminRole->id]);
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'otp' => null,
            'otp_attempts' => 0,
            'otp_last_attempt' => null,
            'otp_blocked_until' => null,
            'otp_requests_today' => 0,
            'last_otp_request_date' => null,
            'status' => 'active',
            'role_id' => $customerRole->id,
            'entry_user_id' => $admin->id,
        ];
    }
}
