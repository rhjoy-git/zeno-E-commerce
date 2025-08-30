<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NavigationMenu;
use App\Models\NavigationMenuItem;
use App\Models\MegaMenuContent;

class NavigationMenuSeeder extends Seeder
{
    public function run()
    {
        // Create main navigation menus
        $menus = [
            [
                'name' => 'Men',
                'slug' => 'men',
                'position' => 1,
                'status' => 'active',
                'is_mega_menu' => true,
                'mega_menu_type' => 'categories'
            ],
            [
                'name' => 'Women',
                'slug' => 'women',
                'position' => 2,
                'status' => 'active',
                'is_mega_menu' => true,
                'mega_menu_type' => 'categories'
            ],
            [
                'name' => 'Kid',
                'slug' => 'kid',
                'position' => 3,
                'status' => 'active',
                'is_mega_menu' => false
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'position' => 4,
                'status' => 'active',
                'is_mega_menu' => false
            ],
            [
                'name' => 'Sale',
                'slug' => 'sale',
                'position' => 5,
                'status' => 'active',
                'is_mega_menu' => false
            ]
        ];

        foreach ($menus as $menuData) {
            $menu = NavigationMenu::create($menuData);
            
            // Add sample mega menu content for mega menus
            if ($menu->is_mega_menu) {
                MegaMenuContent::create([
                    'navigation_menu_id' => $menu->id,
                    'type' => 'categories',
                    'title' => $menu->name . "'s Categories",
                    'content' => json_encode([
                        ['name' => 'Clothing', 'slug' => 'clothing', 'children' => [
                            ['name' => 'T-Shirts', 'slug' => 't-shirts'],
                            ['name' => 'Shirts', 'slug' => 'shirts'],
                            ['name' => 'Jeans', 'slug' => 'jeans'],
                            ['name' => 'Shorts', 'slug' => 'shorts']
                        ]],
                        ['name' => 'Footwear', 'slug' => 'footwear'],
                        ['name' => 'Accessories', 'slug' => 'accessories'],
                        ['name' => 'Sportswear', 'slug' => 'sportswear']
                    ]),
                    'columns' => 1,
                    'order' => 1,
                    'is_active' => true
                ]);
            }
        }
    }
}