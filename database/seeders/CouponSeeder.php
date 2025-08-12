<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role_id', Role::where('slug', 'admin')->first()->id)->first() ?? User::factory()->create([
            'role_id' => Role::where('slug', 'admin')->first()->id ?? Role::factory()->create(['slug' => 'admin'])->id
        ]);
        $coupons = [
            [
                'code' => 'SAVE10',
                'type' => 'fixed',
                'value' => 10.00,
                'min_order_amount' => 50.00,
                'valid_from' => now(),
                'valid_to' => now()->addMonth(),
                'usage_limit' => 100,
                'used_count' => 0,
                'is_active' => true,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
            [
                'code' => 'PERCENT20',
                'type' => 'percentage',
                'value' => 20.00,
                'min_order_amount' => 100.00,
                'valid_from' => now(),
                'valid_to' => now()->addMonth(),
                'usage_limit' => 50,
                'used_count' => 0,
                'is_active' => true,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
        ];
        Coupon::upsert($coupons, ['code'], ['type', 'value', 'min_order_amount', 'valid_from', 'valid_to', 'usage_limit', 'used_count', 'is_active', 'created_by', 'updated_by']);
    }
}
