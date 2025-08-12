<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Policy;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role_id', Role::where('slug', 'admin')->first()->id)->first() ?? User::factory()->create([
            'role_id' => Role::where('slug', 'admin')->first()->id ?? Role::factory()->create(['slug' => 'admin'])->id
        ]);
        $policies = [
            ['type' => 'about', 'description' => 'About our company...', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['type' => 'refund', 'description' => 'Our refund policy allows returns within 30 days...', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['type' => 'terms', 'description' => 'Terms and conditions...', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['type' => 'how to buy', 'description' => 'Steps to purchase products...', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['type' => 'contact', 'description' => 'Contact us at support@example.com...', 'created_by' => $admin->id, 'updated_by' => $admin->id],
            ['type' => 'complain', 'description' => 'File complaints via our support portal...', 'created_by' => $admin->id, 'updated_by' => $admin->id],
        ];
        Policy::upsert($policies, ['type'], ['description', 'created_by', 'updated_by']);
    }
}
