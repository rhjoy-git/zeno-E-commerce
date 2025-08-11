<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingAddressFactory extends Factory
{
    public function definition()
    {
        $user = User::where('role_id', Role::where('slug', 'customer')->first()->id)->inRandomOrder()->first() ?? User::factory()->create(['role_id' => Role::where('slug', 'customer')->first()->id]);

        return [
            'user_id' => $user->id,
            'name' => $this->faker->name,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'postal_code' => $this->faker->postcode,
            'phone' => $this->faker->phoneNumber,
            'is_default' => $this->faker->boolean(20),
            'created_by' => User::where('role_id', Role::where('slug', 'admin')->first()->id)->inRandomOrder()->first()->id ?? 1,
            'updated_by' => User::where('role_id', Role::where('slug', 'admin')->first()->id)->inRandomOrder()->first()->id ?? 1,
        ];
    }
}
