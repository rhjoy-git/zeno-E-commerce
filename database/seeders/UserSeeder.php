<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'otp' => null,
            'role_id' => $adminRole->id,
        ]);

        CustomerProfile::create([
            'user_id' => $admin->id,
            'cus_name' => 'Admin User',
            'cus_address' => '123 Admin Street',
            'cus_city' => 'Admin City',
            'cus_phone' => '123-456-7890'
        ]);
        // Create customer user
        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'otp' => null,
            'role_id' => $customerRole->id,
        ]);

        CustomerProfile::create([
            'user_id' => $customer->id,
            'cus_name' => 'Customer User',
            'cus_address' => '123 Admin Street',
            'cus_city' => 'User City',
            'cus_phone' => '123-456-7890'
        ]);
    }
}
