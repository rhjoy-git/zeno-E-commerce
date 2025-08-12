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
        $customerRole = Role::where('slug', 'customer')->first() ?? Role::factory()->create(['slug' => 'customer']);
        $adminRole = Role::where('slug', 'admin')->first() ?? Role::factory()->create(['slug' => 'admin']);
        $user = User::where('role_id', $customerRole->id)->inRandomOrder()->first() ?? User::factory()->create([
            'role_id' => $customerRole->id
        ]);
        $admin = User::where('role_id', $adminRole->id)->inRandomOrder()->first() ?? User::factory()->create([
            'role_id' => $adminRole->id
        ]);
        $status = $this->faker->randomElement(['pending', 'confirmed', 'processing', 'shipped', 'delivered']);
        $subtotal = $this->faker->randomFloat(2, 100, 5000);
        $discount_amount = $this->faker->randomFloat(2, 0, $subtotal * 0.2);
        $tax_amount = $this->faker->randomFloat(2, 0, 50);
        $shipping_amount = $this->faker->randomFloat(2, 0, 50);
        $total = $subtotal - $discount_amount + $tax_amount + $shipping_amount;
        $payment_status = $this->faker->randomElement(['pending', 'paid', 'partially_paid']);
        return [
            'order_number' => $this->faker->unique()->bothify('ORD-#####'),
            'invoice_number' => $this->faker->unique()->bothify('INV-#####'),
            'status' => $status,
            'subtotal' => $subtotal,
            'discount_amount' => $discount_amount,
            'tax_amount' => $tax_amount,
            'shipping_amount' => $shipping_amount,
            'total' => $total,
            'total_paid' => $payment_status === 'paid' ? $total : ($payment_status === 'partially_paid' ? $this->faker->randomFloat(2, $total * 0.5, $total) : 0),
            'total_refunded' => 0,
            'currency' => 'USD',
            'payment_status' => $payment_status,
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
            'confirmed_at' => $status !== 'pending' ? $this->faker->dateTimeThisYear : null,
            'paid_at' => $payment_status !== 'pending' ? $this->faker->dateTimeThisYear : null,
            'processing_at' => in_array($status, ['processing', 'shipped', 'delivered']) ? $this->faker->dateTimeThisYear : null,
            'shipped_at' => in_array($status, ['shipped', 'delivered']) ? $this->faker->dateTimeThisYear : null,
            'delivered_at' => $status === 'delivered' ? $this->faker->dateTimeThisYear : null,
            'cancelled_at' => $status === 'cancelled' ? $this->faker->dateTimeThisYear : null,
            'notes' => $this->faker->optional()->sentence,
            'admin_notes' => $this->faker->optional()->sentence,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ];
    }
}