<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role_id', Role::where('slug', 'admin')->first()->id)->first() ?? User::factory()->create([
            'role_id' => Role::where('slug', 'admin')->first()->id ?? Role::factory()->create(['slug' => 'admin'])->id
        ]);
        $colors = [
            ['name' => 'Black', 'hex_code' => '#000000', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['name' => 'White', 'hex_code' => '#FFFFFF', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['name' => 'Navy Blue', 'hex_code' => '#1E3A8A', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['name' => 'Red', 'hex_code' => '#FF0000', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['name' => 'Green', 'hex_code' => '#10B981', 'created_by' => $admin->id, 'updated_by' => $admin->id],
        ];
        Color::upsert($colors, ['name'], ['hex_code', 'created_by', 'updated_by']);
    }
}