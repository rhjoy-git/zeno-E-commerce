<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'otp' => null,
            'role_id' => Role::where('slug', 'customer')->first()->id ?? Role::factory()->create(['slug' => 'customer'])->id,
            'created_by' => User::inRandomOrder()->first()->id ?? User::factory()->create(['role_id' => Role::where('slug', 'admin')->first()->id])->id,
            'updated_by' => User::inRandomOrder()->first()->id ?? User::factory()->create(['role_id' => Role::where('slug', 'admin')->first()->id])->id,
        ];
    }
}
