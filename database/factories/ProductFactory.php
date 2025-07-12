<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'short_des' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(100, 1000),
            'discount' => $this->faker->boolean(30),
            'discount_price' => function (array $attributes) {
                return $attributes['discount'] ? $attributes['price'] * 0.8 : 0;
            },
            'stock' => $this->faker->boolean(80),
            'stock_quantity' => $this->faker->numberBetween(1, 100),
            'stock_alert' => $this->faker->numberBetween(1, 10),
            'star' => $this->faker->randomFloat(1, 1, 5),
            'remark' => $this->faker->randomElement(['popular','new','top','special','trending','regular']),
            'sku' => $this->faker->unique()->bothify('SKU-###??'),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'category_id' => Category::inRandomOrder()->first()->id,
            'brand_id' => Brand::inRandomOrder()->first()->id,
        ];
    }
}