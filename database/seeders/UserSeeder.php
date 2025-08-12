<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first() ?? Role::factory()->create(['slug' => 'admin']);
        $customerRole = Role::where('slug', 'customer')->first() ?? Role::factory()->create(['slug' => 'customer']);
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'otp' => null,
            'otp_attempts' => 0,
            'otp_last_attempt' => null,
            'otp_blocked_until' => null,
            'otp_requests_today' => 0,
            'last_otp_request_date' => null,
            'status' => 'active',
            'role_id' => $adminRole->id,
            'entry_user_id' => null,
        ]);
        CustomerProfile::create([
            'user_id' => $admin->id,
            'cus_name' => 'Admin User',
            'cus_address' => '123 Admin Street',
            'cus_city' => 'Admin City',
            'cus_state' => 'CA',
            'cus_postcode' => '90001',
            'cus_country' => 'USA',
            'cus_phone' => '123-456-7890',
            'cus_fax' => null,
            'entry_user_id' => $admin->id,
        ]);
        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'otp' => null,
            'otp_attempts' => 0,
            'otp_last_attempt' => null,
            'otp_blocked_until' => null,
            'otp_requests_today' => 0,
            'last_otp_request_date' => null,
            'status' => 'active',
            'role_id' => $customerRole->id,
            'entry_user_id' => $admin->id,
        ]);
        CustomerProfile::create([
            'user_id' => $customer->id,
            'cus_name' => 'Customer User',
            'cus_address' => '456 User Street',
            'cus_city' => 'User City',
            'cus_state' => 'NY',
            'cus_postcode' => '10001',
            'cus_country' => 'USA',
            'cus_phone' => '987-654-3210',
            'cus_fax' => null,
            'entry_user_id' => $admin->id,
        ]);
        User::factory()->count(8)->create(['entry_user_id' => $admin->id]);
    }
}