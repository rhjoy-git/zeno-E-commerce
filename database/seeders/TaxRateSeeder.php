<?php

namespace Database\Seeders;

use App\Models\TaxRate;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class TaxRateSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role_id', Role::where('slug', 'admin')->first()->id)->first() ?? User::factory()->create([
            'role_id' => Role::where('slug', 'admin')->first()->id ?? Role::factory()->create(['slug' => 'admin'])->id
        ]);
        $taxRates = [
            [
                'name' => 'Standard VAT',
                'rate' => 5.00,
                'region' => 'USA',
                'is_active' => true,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
            [
                'name' => 'High VAT',
                'rate' => 10.00,
                'region' => 'EU',
                'is_active' => true,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
        ];
        TaxRate::upsert($taxRates, ['name', 'region'], ['rate', 'is_active', 'created_by', 'updated_by']);
    }
}