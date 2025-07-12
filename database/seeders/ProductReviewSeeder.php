<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProductReview;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductReviewSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            ProductReview::create([
                'product_id' => $product->id,
                'customer_id' => 2,
                'description' => 'This is a great product! I really loved it. The quality is top-notch and it exceeded my expectations.',
                'rating' => rand(1, 5)
            ]);
        }
    }
}
