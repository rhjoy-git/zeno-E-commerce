<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_sizes')->insert([
            ['name' => 'XS', 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'S', 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'M', 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'L', 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'XL', 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'XXL', 'created_by' => 1, 'updated_by' => 1],
            ['name' => '38', 'created_by' => 1, 'updated_by' => 1],
            ['name' => '39', 'created_by' => 1, 'updated_by' => 1],
            ['name' => '42', 'created_by' => 1, 'updated_by' => 1],
        ]);
    }
}
