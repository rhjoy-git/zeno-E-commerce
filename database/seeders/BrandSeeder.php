<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role_id', Role::where('slug', 'admin')->first()->id)->first() ?? User::factory()->create([
            'role_id' => Role::where('slug', 'admin')->first()->id ?? Role::factory()->create(['slug' => 'admin'])->id
        ]);
        $brands = [
            ['brand_name' => 'Apple', 'brand_image' => 'storage/brands/apple.jpg', 'status' => 'active', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['brand_name' => 'Samsung', 'brand_image' => 'storage/brands/samsung.jpg', 'status' => 'active', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['brand_name' => 'Nike', 'brand_image' => 'storage/brands/nike.jpg', 'status' => 'active', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['brand_name' => 'Sony', 'brand_image' => 'storage/brands/sony.jpg', 'status' => 'active', 'created_by' => $admin->id, 'updated_by' => $admin->id],
        ];
        Brand::upsert($brands, ['brand_name'], ['brand_image', 'status', 'created_by', 'updated_by']);
    }
}