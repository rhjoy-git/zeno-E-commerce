<?php

namespace Database\Seeders;

use App\Models\SslcommerzAccount;
use Illuminate\Database\Seeder;

class SslcommerzAccountSeeder extends Seeder
{
    public function run(): void
    {
        SslcommerzAccount::create([
            'store_id' => 'teststore',
            'store_passwd' => 'testpass',
            'currency' => 'USD',
            'success_url' => 'http://example.com/success',
            'fail_url' => 'http://example.com/fail',
            'cancel_url' => 'http://example.com/cancel',
            'ipn_url' => 'http://example.com/ipn',
            'init_url' => 'http://example.com/init',
        ]);
    }
}