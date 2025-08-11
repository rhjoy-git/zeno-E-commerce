<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Tag;
use App\Models\Color;
use App\Models\ProductSize;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }
    public function run(): void
    {
        // Ensure admin user exists
        $admin = User::where('role_id', Role::where('slug', 'admin')->first()->id)->first() ?? User::factory()->create([
            'role_id' => Role::where('slug', 'admin')->first()->id ?? Role::factory()->create(['slug' => 'admin'])->id
        ]);

        // Ensure tags exist
        $popularTag = Tag::firstOrCreate(['name' => 'popular', 'created_by' => $admin->id, 'updated_by' => $admin->id]);
        $newTag = Tag::firstOrCreate(['name' => 'new', 'created_by' => $admin->id, 'updated_by' => $admin->id]);

        // Ensure colors and sizes exist
        $colors = [
            Color::firstOrCreate(['name' => 'Black', 'hex_code' => '#000000', 'created_by' => $admin->id, 'updated_by' => $admin->id]),
            Color::firstOrCreate(['name' => 'White', 'hex_code' => '#FFFFFF', 'created_by' => $admin->id, 'updated_by' => $admin->id]),
            Color::firstOrCreate(['name' => 'Blue', 'hex_code' => '#0000FF', 'created_by' => $admin->id, 'updated_by' => $admin->id]),
        ];
        $sizes = [
            ProductSize::firstOrCreate(['name' => 'M', 'created_by' => $admin->id, 'updated_by' => $admin->id]),
            ProductSize::firstOrCreate(['name' => 'L', 'created_by' => $admin->id, 'updated_by' => $admin->id]),
            ProductSize::firstOrCreate(['name' => 'XL', 'created_by' => $admin->id, 'updated_by' => $admin->id]),
        ];

        // Create one specific product
        $product = Product::create([
            'title' => 'Sample T-Shirt',
            'short_description' => 'A high-quality cotton t-shirt for daily wear.',
            'price' => 500,
            'discount' => true,
            'discount_price' => 400,
            'stock_quantity' => 50,
            'stock_alert' => 5,
            'slug' => 'sample-t-shirt',
            'sku' => 'SKU-123AB',
            'status' => 'active',
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory()->create()->id,
            'brand_id' => Brand::inRandomOrder()->first()->id ?? Brand::factory()->create()->id,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        // Attach tags to product
        $product->tags()->attach([$popularTag->id, $newTag->id], ['created_by' => $admin->id, 'updated_by' => $admin->id]);

        // Create product variants for the specific product
        $variantConfigs = [
            ['color' => $colors[0], 'size' => $sizes[0], 'price' => 500, 'stock_quantity' => 50, 'sku' => 'SKU-123AB-M'],
            ['color' => $colors[0], 'size' => $sizes[1], 'price' => 550, 'stock_quantity' => 30, 'sku' => 'SKU-123AB-L'],
            ['color' => $colors[0], 'size' => $sizes[2], 'price' => 600, 'stock_quantity' => 20, 'sku' => 'SKU-123AB-XL'],
            ['color' => $colors[1], 'size' => $sizes[0], 'price' => 500, 'stock_quantity' => 50, 'sku' => 'SKU-123AB-WM'],
            ['color' => $colors[1], 'size' => $sizes[1], 'price' => 550, 'stock_quantity' => 30, 'sku' => 'SKU-123AB-WL'],
            ['color' => $colors[1], 'size' => $sizes[2], 'price' => 600, 'stock_quantity' => 20, 'sku' => 'SKU-123AB-WXL'],
            ['color' => $colors[2], 'size' => $sizes[0], 'price' => 500, 'stock_quantity' => 50, 'sku' => 'SKU-123AB-BM'],
            ['color' => $colors[2], 'size' => $sizes[1], 'price' => 550, 'stock_quantity' => 30, 'sku' => 'SKU-123AB-BL'],
            ['color' => $colors[2], 'size' => $sizes[2], 'price' => 600, 'stock_quantity' => 20, 'sku' => 'SKU-123AB-BXL'],
        ];

        $variantIds = [];
        foreach ($variantConfigs as $config) {
            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'color_id' => $config['color']->id,
                'size_id' => $config['size']->id,
                'price' => $config['price'],
                'stock_quantity' => $config['stock_quantity'],
                'stock_alert' => 5,
                'sku' => $config['sku'],
                'status' => 'active',
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);
            $variantIds[] = $variant->id;
        }

        // Add product detail
        ProductDetail::create([
            'product_id' => $product->id,
            'description' => 'This is a comfortable and breathable t-shirt suitable for all seasons.',
            'specifications' => 'Material: 100% Cotton, Fit: Regular, Care: Machine Washable, Do Not Bleach',
            'warranty' => '1 Year Manufacturer Warranty',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        // Add product images linked to variants
        foreach (array_slice($variantIds, 0, 3) as $index => $variantId) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => "images/products/" . ($index + 1) . ".jpg",
                'variant_id' => $variantId,
                'is_primary' => $index === 0,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);
        }

        // Create additional products using factory
        Product::factory()->count(9)->create([
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
            'category_id' => fn() => Category::inRandomOrder()->first()->id ?? Category::factory()->create()->id,
            'brand_id' => fn() => Brand::inRandomOrder()->first()->id ?? Brand::factory()->create()->id,
        ])->each(function ($product) use ($admin, $colors, $sizes, $popularTag, $newTag) {
            $product->tags()->attach([$popularTag->id, $newTag->id], ['created_by' => $admin->id, 'updated_by' => $admin->id]);

            // Generate unique color-size combinations
            $availableCombinations = [];
            foreach ($colors as $color) {
                foreach ($sizes as $size) {
                    $availableCombinations[] = ['color_id' => $color->id, 'size_id' => $size->id];
                }
            }
            // Shuffle and select 2-4 unique combinations
            shuffle($availableCombinations);
            $variantCount = rand(2, 4);
            $selectedCombinations = array_slice($availableCombinations, 0, $variantCount);

            // Create variants
            foreach ($selectedCombinations as $index => $combo) {
                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id' => $combo['color_id'],
                    'size_id' => $combo['size_id'],
                    'price' => $this->faker->randomFloat(2, 400, 600),
                    'stock_quantity' => $this->faker->numberBetween(10, 50),
                    'stock_alert' => 5,
                    'sku' => $this->faker->unique()->bothify('SKU-###??-' . $product->id . '-' . $index),
                    'status' => 'active',
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => "images/products/" . ($product->id) . "-" . ($index + 1) . ".jpg",
                    'variant_id' => $variant->id,
                    'is_primary' => $index === 0,
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]);
            }

            ProductDetail::create([
                'product_id' => $product->id,
                'description' => $this->faker->paragraph,
                'specifications' => $this->faker->sentence,
                'warranty' => $this->faker->optional()->sentence,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);
        });
    }
}
