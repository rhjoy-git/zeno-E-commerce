<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('colors')->insert([
            ['name' => 'Black', 'hex_code' => '#000000'],
            ['name' => 'White', 'hex_code' => '#FFFFFF'],
            ['name' => 'Navy Blue', 'hex_code' => '#1E3A8A'],
            ['name' => 'Red', 'hex_code' => '#FF0000'],
            ['name' => 'Green', 'hex_code' => '#10B981'],
        ]);
    }
}
