<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearNavigationCache extends Command
{
    protected $signature = 'navigation:clear-cache';
    protected $description = 'Clear the navigation menu cache';

    public function handle()
    {
        Cache::forget('navigation_menus');
        $this->info('Navigation menu cache cleared successfully.');
        
        return 0;
    }
}