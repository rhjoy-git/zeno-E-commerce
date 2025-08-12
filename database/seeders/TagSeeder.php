<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role_id', Role::where('slug', 'admin')->first()->id)->first() ?? User::factory()->create([
            'role_id' => Role::where('slug', 'admin')->first()->id ?? Role::factory()->create(['slug' => 'admin'])->id
        ]);
        $tags = [
            ['name' => 'popular', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['name' => 'new', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['name' => 'sale', 'created_by' => $admin->id, 'updated_by' => $admin->id],
        ];
        Tag::upsert($tags, ['name'], ['created_by', 'updated_by']);
    }
}