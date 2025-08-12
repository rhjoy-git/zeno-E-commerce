<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Ensure there is an admin user
        $adminRoleId = Role::where('slug', 'admin')->first()->id
            ?? Role::factory()->create(['slug' => 'admin'])->id;

        $admin = User::where('role_id', $adminRoleId)->first()
            ?? User::factory()->create(['role_id' => $adminRoleId]);

        // Parent categories
        $electronics = $this->createCategory('Electronics', 'storage/categories/electronics.jpg', $admin->id);
        $clothing    = $this->createCategory('Clothing', 'storage/categories/clothing.jpg', $admin->id);
        $books       = $this->createCategory('Books', 'storage/categories/books.jpg', $admin->id);

        // Child categories
        $this->createCategory('Smartphones', 'storage/categories/smartphones.jpg', $admin->id, $electronics->id);
        $this->createCategory('Laptops', 'storage/categories/laptops.jpg', $admin->id, $electronics->id);
        $this->createCategory('Men\'s Clothing', 'storage/categories/mens_clothing.jpg', $admin->id, $clothing->id);
        $this->createCategory('Fiction Books', 'storage/categories/fiction_books.jpg', $admin->id, $books->id);
    }

    private function createCategory(string $name, string $image, int $userId, ?int $parentId = null): Category
    {
        return Category::create([
            'category_name' => $name,
            'category_image' => $image,
            'status' => 'active',
            'parent_id' => $parentId,
            'created_by' => $userId,
            'updated_by' => $userId,
        ]);
    }
}
