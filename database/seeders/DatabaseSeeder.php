<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ProductReviewSeeder;
use Database\Seeders\PolicySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
        ]);

        $this->call([
            ProductSeeder::class,
            ProductReviewSeeder::class,
            PolicySeeder::class,
        ]);
    }
}
