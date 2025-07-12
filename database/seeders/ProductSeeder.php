<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductDetail;
use App\Models\ProductSlider;
use App\Models\ProductTag;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create one product with dummy data
        $product = Product::create([
            'title' => 'Sample T-Shirt',
            'short_des' => 'A high-quality cotton t-shirt for daily wear.',
            'price' => 500,
            'discount' => true,
            'discount_price' => 400,
            'stock_quantity' => 50,
            'stock_alert' => 5,
            'slug' => 'sample-t-shirt',
            'sku' => 'SKU-123AB',
            'status' => 'active',
            'category_id' => Category::inRandomOrder()->first()->id,
            'brand_id' => Brand::inRandomOrder()->first()->id,
        ]);
        // Add product Tag
        ProductTag::create([
            'product_id' => $product->id,
            'tag' => 'popular',
        ]);
        ProductTag::create([
            'product_id' => $product->id,
            'tag' => 'new',
        ]);
        // Add product variant
        $variants = [
            [
                'color' => 'Black',
                'size' => 'M',
                'price' => 500,
                'stock_quantity' => 50,
                'sku' => 'SKU-123AB-M',
                'status' => 'active',
            ],
            [
                'color' => 'Black',
                'size' => 'L',
                'price' => 550,
                'stock_quantity' => 30,
                'sku' => 'SKU-123AB-L',
                'status' => 'active',
            ],
            [
                'color' => 'Black',
                'size' => 'XL',
                'price' => 600,
                'stock_quantity' => 20,
                'sku' => 'SKU-123AB-XL',
                'status' => 'active',
            ],
            [
                'color' => 'White',
                'size' => 'M',
                'price' => 500,
                'stock_quantity' => 50,
                'sku' => 'SKU-123AB-WM',
                'status' => 'active',
            ],
            [
                'color' => 'White',
                'size' => 'L',
                'price' => 550,
                'stock_quantity' => 30,
                'sku' => 'SKU-123AB-WL',
                'status' => 'active',
            ],
            [
                'color' => 'White',
                'size' => 'XL',
                'price' => 600,
                'stock_quantity' => 20,
                'sku' => 'SKU-123AB-WXL',
                'status' => 'active',
            ],
            [
                'color' => 'Blue',
                'size' => 'M',
                'price' => 500,
                'stock_quantity' => 50,
                'sku' => 'SKU-123AB-BM',
                'status' => 'active',
            ],
            [
                'color' => 'Blue',
                'size' => 'L',
                'price' => 550,
                'stock_quantity' => 30,
                'sku' => 'SKU-123AB-BL',
                'status' => 'active',
            ],
            [
                'color' => 'Blue',
                'size' => 'XL',
                'price' => 600,
                'stock_quantity' => 20,
                'sku' => 'SKU-123AB-BXL',
                'status' => 'active',
            ]
        ];

        foreach ($variants as $variantData) {
            ProductVariant::create([
                'product_id' => $product->id,
                'color' => $variantData['color'],
                'size' => $variantData['size'],
                'price' => $variantData['price'],
                'stock_quantity' => $variantData['stock_quantity'],
                'sku' => $variantData['sku'],
                'status' => $variantData['status'],
            ]);
        }

        // Add product detail
        ProductDetail::create([
            'product_id' => $product->id,
            'description' => 'This is a comfortable and breathable t-shirt suitable for all seasons.',
            'specifications' => 'Material: 100% Cotton, Fit: Regular, Care: Machine Washable, Do Not Bleach',
            'warranty' => '1 Year Manufacturer Warranty',
        ]);

        // Add 3 product images
        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => 'images/products/1.jpg',
            'variant_id' => 1,
        ]);
        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => 'images/products/2.jpg',
            'variant_id' => 2,
        ]);
        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => 'images/products/3.jpg',
            'variant_id' => 3,
        ]);
    }
}
