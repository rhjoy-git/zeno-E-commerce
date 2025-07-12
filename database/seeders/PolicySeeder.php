<?php

namespace Database\Seeders;
use App\Models\Policy;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    public function run(): void {
        $policies = [
            ['type' => 'about', 'des' => ''],
            ['type' => 'refund', 'des' => ''],
            ['type' => 'terms', 'des' => ''],
            ['type' => 'how to buy', 'des' => ''],
            ['type' => 'contact', 'des' => ''],
            ['type' => 'complain', 'des' => '']
        ];
    
        foreach ($policies as $policy) {
            Policy::create($policy);
        }
    }
}
