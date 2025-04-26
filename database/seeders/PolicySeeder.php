<?php

namespace Database\Seeders;
use App\Models\Policy;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    public function run(): void {
        $policies = [
            ['type' => 'about', 'des' => fake()->text(1000)],
            ['type' => 'refund', 'des' => fake()->text(1000)],
            ['type' => 'terms', 'des' => fake()->text(1000)],
            ['type' => 'how to buy', 'des' => fake()->text(1000)],
            ['type' => 'contact', 'des' => fake()->text(1000)],
            ['type' => 'complain', 'des' => fake()->text(1000)]
        ];
    
        foreach ($policies as $policy) {
            Policy::create($policy);
        }
    }
}
