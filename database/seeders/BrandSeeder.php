<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['brand_name' => 'Apple', 'brand_image' => 'https://picsum.photos/204', 'status' => 'active', 'created_by' => 1, 'updated_by' => 1],
            ['brand_name' => 'Samsung', 'brand_image' => 'https://picsum.photos/205', 'status' => 'active', 'created_by' => 1, 'updated_by' => 1],
            ['brand_name' => 'Nike', 'brand_image' => 'https://picsum.photos/206', 'status' => 'active', 'created_by' => 1, 'updated_by' => 1],
            ['brand_name' => 'Sony', 'brand_image' => 'https://picsum.photos/207', 'status' => 'active', 'created_by' => 1, 'updated_by' => 1],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
