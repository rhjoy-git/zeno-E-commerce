<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Role;
use App\Models\Color;
use App\Models\ProductSize;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition()
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $variant = ProductVariant::where('product_id', $product->id)->inRandomOrder()->first() ?? ProductVariant::factory()->create(['product_id' => $product->id]);
        $admin = User::where('role_id', Role::where('slug', 'admin')->first()->id)->inRandomOrder()->first() ?? User::factory()->create([
            'role_id' => Role::where('slug', 'admin')->first()->id ?? Role::factory()->create(['slug' => 'admin'])->id
        ]);

        // Load color and size names for variant_options
        $colorName = $variant->color ? $variant->color->name : null;
        $sizeName = $variant->size ? $variant->size->name : null;

        return [
            'order_id' => Order::factory()->create()->id,
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'name' => $product->title,
            'sku' => $variant->sku ?? $product->sku,
            'description' => $product->short_description,
            'variant_options' => json_encode(array_filter(['color' => $colorName, 'size' => $sizeName])),
            'price' => $variant->price ?? $product->price,
            'original_price' => $variant->price ?? $product->price,
            'discount_amount' => $this->faker->randomFloat(2, 0, 50),
            'tax_amount' => $this->faker->randomFloat(2, 0, 20),
            'quantity' => $this->faker->numberBetween(1, 5),
            'quantity_shipped' => $this->faker->numberBetween(0, 2),
            'quantity_refunded' => $this->faker->numberBetween(0, 1),
            'quantity_cancelled' => $this->faker->numberBetween(0, 1),
            'row_total' => fn(array $attributes) => ($attributes['price'] - $attributes['discount_amount']) * $attributes['quantity'],
            'row_total_incl_tax' => fn(array $attributes) => ($attributes['price'] - $attributes['discount_amount'] + $attributes['tax_amount']) * $attributes['quantity'],
            'weight' => $this->faker->randomFloat(2, 0, 5),
            'volume' => $this->faker->randomFloat(2, 0, 5),
            'fulfillment_status' => $this->faker->randomElement(['unfulfilled', 'partially_fulfilled', 'fulfilled']),
            'notes' => $this->faker->optional()->sentence,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ];
    }
}