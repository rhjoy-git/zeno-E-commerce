<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Role;
use App\Models\ShippingAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition()
    {
        $user = User::where('role_id', Role::where('slug', 'customer')->first()->id)->inRandomOrder()->first() ?? User::factory()->create([
            'role_id' => Role::where('slug', 'customer')->first()->id ?? Role::factory()->create(['slug' => 'customer'])->id
        ]);
        $admin = User::where('role_id', Role::where('slug', 'admin')->first()->id)->inRandomOrder()->first() ?? User::factory()->create([
            'role_id' => Role::where('slug', 'admin')->first()->id ?? Role::factory()->create(['slug' => 'admin'])->id
        ]);

        return [
            'order_number' => $this->faker->unique()->bothify('ORD-#####'),
            'invoice_number' => $this->faker->unique()->bothify('INV-#####'),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'processing', 'shipped', 'delivered']),
            'subtotal' => $this->faker->randomFloat(2, 100, 5000),
            'discount_amount' => $this->faker->randomFloat(2, 0, 100),
            'tax_amount' => $this->faker->randomFloat(2, 0, 50),
            'shipping_amount' => $this->faker->randomFloat(2, 0, 50),
            'total' => fn(array $attributes) => $attributes['subtotal'] - $attributes['discount_amount'] + $attributes['tax_amount'] + $attributes['shipping_amount'],
            'total_paid' => fn(array $attributes) => $attributes['status'] === 'delivered' ? $attributes['total'] : 0,
            'total_refunded' => 0,
            'currency' => 'USD',
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'partially_paid']),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'transaction_id' => $this->faker->uuid,
            'payment_notes' => $this->faker->optional()->sentence,
            'shipping_address_id' => ShippingAddress::factory()->create(['user_id' => $user->id, 'created_by' => $admin->id, 'updated_by' => $admin->id])->id,
            'shipping_method' => $this->faker->randomElement(['standard', 'express']),
            'shipping_weight' => $this->faker->randomFloat(2, 0, 10),
            'tracking_number' => $this->faker->optional()->bothify('TRK-#####'),
            'tracking_url' => $this->faker->optional()->url,
            'user_id' => $user->id,
            'customer_email' => $user->email,
            'customer_phone' => $this->faker->phoneNumber,
            'customer_ip' => $this->faker->ipv4,
            'confirmed_at' => $this->faker->optional()->dateTime,
            'paid_at' => $this->faker->optional()->dateTime,
            'processing_at' => $this->faker->optional()->dateTime,
            'shipped_at' => $this->faker->optional()->dateTime,
            'delivered_at' => $this->faker->optional()->dateTime,
            'cancelled_at' => $this->faker->optional()->dateTime,
            'notes' => $this->faker->optional()->sentence,
            'admin_notes' => $this->faker->optional()->sentence,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ];
    }
}