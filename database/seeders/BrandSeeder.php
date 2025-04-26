<?php

namespace Database\Seeders;
use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void {
        $brands = [
            ['brandName' => 'Apple', 'brandImg' => 'https://picsum.photos/204'],
            ['brandName' => 'Samsung', 'brandImg' => 'https://picsum.photos/205'],
            ['brandName' => 'Nike', 'brandImg' => 'https://picsum.photos/206'],
            ['brandName' => 'Sony', 'brandImg' => 'https://picsum.photos/207']
        ];
    
        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
