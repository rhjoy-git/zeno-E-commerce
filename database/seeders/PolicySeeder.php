<?php

namespace Database\Seeders;

use App\Models\Policy;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    public function run(): void
    {
        $policies = [
            ['type' => 'about', 'description' => 'About our company...'],
            ['type' => 'refund', 'description' => 'Our refund policy allows returns within 30 days...'],
            ['type' => 'terms', 'description' => 'Terms and conditions...'],
            ['type' => 'how to buy', 'description' => 'Steps to purchase products...'],
            ['type' => 'contact', 'description' => 'Contact us at support@example.com...'],
            ['type' => 'complain', 'description' => 'File complaints via our support portal...'],
        ];

        foreach ($policies as $policy) {
            Policy::create($policy);
        }
    }
}
