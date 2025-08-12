<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingAddressFactory extends Factory
{
    public function definition()
    {
        $customerRole = Role::where('slug', 'customer')->first() ?? Role::factory()->create(['slug' => 'customer']);
        $adminRole = Role::where('slug', 'admin')->first() ?? Role::factory()->create(['slug' => 'admin']);
        $user = User::where('role_id', $customerRole->id)->inRandomOrder()->first() ?? User::factory()->create(['role_id' => $customerRole->id]);
        $admin = User::where('role_id', $adminRole->id)->inRandomOrder()->first() ?? User::factory()->create(['role_id' => $adminRole->id]);
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
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ];
    }
}
