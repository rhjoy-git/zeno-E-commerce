<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Electronics', 'category_image' => 'https://picsum.photos/200', 'status' => 'active', 'parent_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['category_name' => 'Clothing', 'category_image' => 'https://picsum.photos/201', 'status' => 'active', 'parent_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['category_name' => 'Books', 'category_image' => 'https://picsum.photos/202', 'status' => 'active', 'parent_id' => null, 'created_by' => 1, 'updated_by' => 1],
            ['category_name' => 'Home & Kitchen', 'category_image' => 'https://picsum.photos/203', 'status' => 'active', 'parent_id' => null, 'created_by' => 1, 'updated_by' => 1],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
