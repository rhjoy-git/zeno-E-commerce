<?php

namespace Database\Seeders;

use App\Models\ShippingAddress;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class ShippingAddressSeeder extends Seeder
{
    public function run(): void
    {
        $customerRole = Role::where('slug', 'customer')->first() ?? Role::factory()->create(['slug' => 'customer']);
        $adminRole = Role::where('slug', 'admin')->first() ?? Role::factory()->create(['slug' => 'admin']);
        $customer = User::where('role_id', $customerRole->id)->first() ?? User::factory()->create(['role_id' => $customerRole->id]);
        $admin = User::where('role_id', $adminRole->id)->first() ?? User::factory()->create(['role_id' => $adminRole->id]);
        $addresses = [
            [
                'user_id' => $customer->id,
                'name' => 'John Doe',
                'address' => '123 Main St',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'USA',
                'postal_code' => '10001',
                'phone' => '555-123-4567',
                'is_default' => true,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
            [
                'user_id' => $customer->id,
                'name' => 'Jane Smith',
                'address' => '456 Elm St',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'country' => 'USA',
                'postal_code' => '90001',
                'phone' => '555-987-6543',
                'is_default' => false,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
        ];
        ShippingAddress::upsert($addresses, ['user_id', 'address'], ['name', 'city', 'state', 'country', 'postal_code', 'phone', 'is_default', 'created_by', 'updated_by']);
        ShippingAddress::factory()->count(8)->create(['created_by' => $admin->id, 'updated_by' => $admin->id]);
    }
}
