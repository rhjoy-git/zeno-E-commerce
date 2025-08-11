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
        // Ensure a customer exists
        $customer = User::where('role_id', Role::where('slug', 'customer')->first()->id)->first() ?? User::factory()->create(['role_id' => Role::where('slug', 'customer')->first()->id]);
        $adminId = User::where('role_id', Role::where('slug', 'admin')->first()->id)->first()->id ?? 1;

        // Create sample addresses
        ShippingAddress::create([
            'user_id' => $customer->id,
            'name' => 'John Doe',
            'address' => '123 Main St',
            'city' => 'New York',
            'state' => 'NY',
            'country' => 'USA',
            'postal_code' => '10001',
            'phone' => '555-123-4567',
            'is_default' => true,
            'created_by' => $adminId,
            'updated_by' => $adminId,
        ]);

        ShippingAddress::create([
            'user_id' => $customer->id,
            'name' => 'Jane Smith',
            'address' => '456 Elm St',
            'city' => 'Los Angeles',
            'state' => 'CA',
            'country' => 'USA',
            'postal_code' => '90001',
            'phone' => '555-987-6543',
            'is_default' => false,
            'created_by' => $adminId,
            'updated_by' => $adminId,
        ]);

        // Create additional addresses via factory
        ShippingAddress::factory()->count(8)->create();
    }
}