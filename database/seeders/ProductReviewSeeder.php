<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\CustomerProfile;
use App\Models\ProductReview;
use Faker\Factory as Faker;

class ProductReviewSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $products = Product::all();
        $customers = CustomerProfile::all();

        // যদি কোন product বা customer না থাকে তবে কিছু না করেই বের হয়ে যাবে
        if ($products->isEmpty() || $customers->isEmpty()) {
            // $this->command->warn('No products or customers found. Skipping ProductReviewSeeder.');
            return;
        }

        foreach ($products as $product) {
            // প্রতিটা প্রোডাক্টে 2 থেকে 5 টা review দিব
            foreach (range(1, rand(2, 5)) as $i) {
                ProductReview::create([
                    'product_id'  => $product->id,
                    'customer_id' => $customers->random()->id,
                    'description' => $faker->sentence(rand(8, 15)),
                    'rating'      => rand(1, 5),
                    'status'      => $faker->randomElement(['approved', 'pending', 'rejected']),
                ]);
            }
        }

        // $this->command->info('Product reviews seeded successfully!');
    }
}
