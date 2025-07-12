<?php

namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void {
        $categories = [
            ['categoryName' => 'Electronics', 'categoryImg' => 'https://picsum.photos/200'],
            ['categoryName' => 'Clothing', 'categoryImg' => 'https://picsum.photos/201'],
            ['categoryName' => 'Books', 'categoryImg' => 'https://picsum.photos/202'],
            ['categoryName' => 'Home & Kitchen', 'categoryImg' => 'https://picsum.photos/203'],
            
        ];
    
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
