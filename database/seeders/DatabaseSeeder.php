<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\ColorSeeder;
use Database\Seeders\ProductSizeSeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\CouponSeeder;
use Database\Seeders\TaxRateSeeder;
use Database\Seeders\SslcommerzAccountSeeder;
use Database\Seeders\ShippingAddressSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ProductReviewSeeder;
use Database\Seeders\PolicySeeder;
use Database\Seeders\OrderSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ColorSeeder::class,
            ProductSizeSeeder::class,
            TagSeeder::class,
            CouponSeeder::class,
            TaxRateSeeder::class,
            SslcommerzAccountSeeder::class,
            ShippingAddressSeeder::class,
            ProductSeeder::class,
            ProductReviewSeeder::class,
            PolicySeeder::class,
            OrderSeeder::class,
        ]);
    }
}
