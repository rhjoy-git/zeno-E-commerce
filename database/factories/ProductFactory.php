<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        $admin = User::where('role_id', Role::where('slug', 'admin')->first()->id)->first() ?? User::factory()->create([
            'role_id' => Role::where('slug', 'admin')->first()->id ?? Role::factory()->create(['slug' => 'admin'])->id
        ]);

        return [
            'title' => $this->faker->words(3, true),
            'short_description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'discount' => $this->faker->boolean(30),
            'discount_price' => fn(array $attributes) => $attributes['discount'] ? $attributes['price'] * 0.8 : null,
            'stock_quantity' => $this->faker->numberBetween(10, 100),
            'stock_alert' => $this->faker->numberBetween(1, 10),
            'slug' => $this->faker->unique()->slug(),
            'sku' => $this->faker->unique()->bothify('SKU-###??'),
            'status' => $this->faker->randomElement(['active', 'inactive', 'discontinued']),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory()->create()->id,
            'brand_id' => Brand::inRandomOrder()->first()->id ?? Brand::factory()->create()->id,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ];
    }
}
