<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\ProductReview;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductReviewSeeder extends Seeder
{
    public function run(): void {
        $users = User::all();
    $products = Product::all();

    foreach ($products as $product) {
        $reviewCount = rand(1, 5);
        
        for ($i = 0; $i < $reviewCount; $i++) {
            ProductReview::create([
                'product_id' => $product->id,
                'customer_id' => $users->random()->customerProfile->id,
                'description' => fake()->paragraph,
                'rating' => rand(1, 5)
            ]);
        }
    }
    }
}
