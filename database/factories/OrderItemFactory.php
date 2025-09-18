<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Role;
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
        $quantity = $this->faker->numberBetween(1, min(5, $variant->stock_quantity));
        $price = $variant->price ?? $product->price;
        $discount_amount = $this->faker->randomFloat(2, 0, $price * 0.2);
        $tax_amount = $this->faker->randomFloat(2, 0, $price * 0.1);
        return [
            'order_id' => Order::factory()->create()->id,
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'name' => $product->title,
            'sku' => $variant->sku ?? $product->sku,
            'description' => $product->short_description,
            'variant_color' => $variant->color ? $variant->color->name : null,
            'variant_size' => $variant->size ? $variant->size->name : null,
            'price' => $price,
            'original_price' => $price,
            'discount_amount' => $discount_amount,
            'tax_amount' => $tax_amount,
            'quantity' => $quantity,
            'quantity_shipped' => $this->faker->numberBetween(0, $quantity),
            'quantity_refunded' => $this->faker->numberBetween(0, $quantity),
            'quantity_cancelled' => $this->faker->numberBetween(0, $quantity),
            'row_total' => ($price - $discount_amount) * $quantity,
            'row_total_incl_tax' => ($price - $discount_amount + $tax_amount) * $quantity,
            'weight' => $this->faker->randomFloat(2, 0, 5),
            'volume' => $this->faker->randomFloat(2, 0, 5),
            'fulfillment_status' => $this->faker->randomElement(['unfulfilled', 'partially_fulfilled', 'fulfilled']),
            'notes' => $this->faker->optional()->sentence,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ];
    }
}
