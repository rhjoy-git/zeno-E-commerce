<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('colors')->insert([
            ['name' => 'Black', 'hex_code' => '#000000', 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'White', 'hex_code' => '#FFFFFF', 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Navy Blue', 'hex_code' => '#1E3A8A', 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Red', 'hex_code' => '#FF0000', 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Green', 'hex_code' => '#10B981', 'created_by' => 1, 'updated_by' => 1],
        ]);
    }
}
