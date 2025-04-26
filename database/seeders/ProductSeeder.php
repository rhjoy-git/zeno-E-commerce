<?php

namespace Database\Seeders;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductSlider;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void {
        // Create 50 products
    Product::factory(50)->create()->each(function ($product) {
        // Create product details
        ProductDetail::create([
            'product_id' => $product->id,
            'img1' => 'https://picsum.photos/300',
            'img2' => 'https://picsum.photos/301',
            'img3' => 'https://picsum.photos/302',
            'img4' => 'https://picsum.photos/303',
            'des' => fake()->paragraph(5),
            'color' => fake()->colorName,
            'size' => 'M'
        ]);

        // Create product slider
        ProductSlider::create([
            'product_id' => $product->id,
            'title' => $product->title,
            'short_des' => $product->short_des,
            'price' => $product->price,
            'image' => $product->image
        ]);
    });
    }
}
