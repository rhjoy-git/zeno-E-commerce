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
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function run(): void
    {
        $admin = User::where('role_id', Role::where('slug', 'admin')->first()->id)->first() ?? User::factory()->create([
            'role_id' => Role::where('slug', 'admin')->first()->id ?? Role::factory()->create(['slug' => 'admin'])->id
        ]);
        $popularTag = Tag::firstOrCreate(['name' => 'popular', 'created_by' => $admin->id, 'updated_by' => $admin->id]);
        $newTag = Tag::firstOrCreate(['name' => 'new', 'created_by' => $admin->id, 'updated_by' => $admin->id]);
        $colors = Color::all()->isEmpty() ? Color::factory()->count(3)->create(['created_by' => $admin->id, 'updated_by' => $admin->id]) : Color::all();
        $sizes = ProductSize::all()->isEmpty() ? ProductSize::factory()->count(3)->create(['created_by' => $admin->id, 'updated_by' => $admin->id]) : ProductSize::all();
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
        $product->tags()->attach([$popularTag->id, $newTag->id], ['created_by' => $admin->id, 'updated_by' => $admin->id]);
        $variantConfigs = [
            ['color_id' => $colors[0]->id, 'size_id' => $sizes[0]->id, 'price' => 500, 'stock_quantity' => 50, 'sku' => 'SKU-123AB-M'],
            ['color_id' => $colors[0]->id, 'size_id' => $sizes[1]->id, 'price' => 550, 'stock_quantity' => 30, 'sku' => 'SKU-123AB-L'],
            ['color_id' => $colors[0]->id, 'size_id' => $sizes[2]->id, 'price' => 600, 'stock_quantity' => 20, 'sku' => 'SKU-123AB-XL'],
            ['color_id' => $colors[1]->id, 'size_id' => $sizes[0]->id, 'price' => 500, 'stock_quantity' => 50, 'sku' => 'SKU-123AB-WM'],
            ['color_id' => $colors[1]->id, 'size_id' => $sizes[1]->id, 'price' => 550, 'stock_quantity' => 30, 'sku' => 'SKU-123AB-WL'],
            ['color_id' => $colors[1]->id, 'size_id' => $sizes[2]->id, 'price' => 600, 'stock_quantity' => 20, 'sku' => 'SKU-123AB-WXL'],
            ['color_id' => $colors[2]->id, 'size_id' => $sizes[0]->id, 'price' => 500, 'stock_quantity' => 50, 'sku' => 'SKU-123AB-BM'],
            ['color_id' => $colors[2]->id, 'size_id' => $sizes[1]->id, 'price' => 550, 'stock_quantity' => 30, 'sku' => 'SKU-123AB-BL'],
            ['color_id' => $colors[2]->id, 'size_id' => $sizes[2]->id, 'price' => 600, 'stock_quantity' => 20, 'sku' => 'SKU-123AB-BXL'],
        ];
        $variantIds = [];
        foreach ($variantConfigs as $config) {
            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'color_id' => $config['color_id'],
                'size_id' => $config['size_id'],
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
        ProductDetail::create([
            'product_id' => $product->id,
            'description' => 'This is a comfortable and breathable t-shirt suitable for all seasons.',
            'specifications' => 'Material: 100% Cotton, Fit: Regular, Care: Machine Washable, Do Not Bleach',
            'warranty' => '1 Year Manufacturer Warranty',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
        foreach (array_slice($variantIds, 0, 3) as $index => $variantId) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => "storage/products/{$product->id}-" . ($index + 1) . ".jpg",
                'variant_id' => $variantId,
                'is_primary' => $index === 0,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);
        }
        Product::factory()->count(9)->create([
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
            'category_id' => fn() => Category::inRandomOrder()->first()->id ?? Category::factory()->create()->id,
            'brand_id' => fn() => Brand::inRandomOrder()->first()->id ?? Brand::factory()->create()->id,
        ])->each(function ($product) use ($admin, $colors, $sizes, $popularTag, $newTag) {
            $product->tags()->attach([$popularTag->id, $newTag->id], ['created_by' => $admin->id, 'updated_by' => $admin->id]);
            $availableCombinations = [];
            foreach ($colors as $color) {
                foreach ($sizes as $size) {
                    $availableCombinations[] = ['color_id' => $color->id, 'size_id' => $size->id];
                }
            }
            shuffle($availableCombinations);
            $variantCount = rand(2, 4);
            $selectedCombinations = array_slice($availableCombinations, 0, $variantCount);
            foreach ($selectedCombinations as $index => $combo) {
                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id' => $combo['color_id'],
                    'size_id' => $combo['size_id'],
                    'price' => $this->faker->randomFloat(2, 400, 600),
                    'stock_quantity' => $this->faker->numberBetween(10, 50),
                    'stock_alert' => 5,
                    'sku' => $this->faker->unique()->bothify("SKU-{$product->id}-{$index}-##??"),
                    'status' => 'active',
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ]);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => "storage/products/{$product->id}-" . ($index + 1) . ".jpg",
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