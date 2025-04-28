<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
         // Ensure roles exist first
         $adminRole = Role::where('slug', 'admin')->first();
         $customerRole = Role::where('slug', 'customer')->first();
 
         if (!$adminRole || !$customerRole) {
             $this->call(RoleSeeder::class);
             $adminRole = Role::where('slug', 'admin')->first();
             $customerRole = Role::where('slug', 'customer')->first();
         }
 
         // Create admin user
         $admin = User::create([
             'name' => 'Admin User',
             'email' => 'admin@example.com',
             'password' => bcrypt('12345678'),
             'otp' => '0000',
             'role_id' => $adminRole->id, // Assign admin role
         ]);

        CustomerProfile::create([
            'user_id' => $admin->id,
            'cus_name' => 'Admin User',
            'cus_add' => '123 Admin Street',
            'cus_city' => 'Admin City',
            'cus_phone' => '123-456-7890'
        ]);

        // Create regular users using factory
        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                CustomerProfile::create([
                    'user_id' => $user->id,
                    'cus_name' => $user->name,
                    'cus_add' => fake()->address,
                    'cus_city' => fake()->city,
                    'cus_phone' => $user->phone
                ]);
            });
    }
}