<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'position', 'status', 
        'is_mega_menu', 'mega_menu_type', 'mega_menu_content'
    ];

    protected $casts = [
        'mega_menu_content' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(NavigationMenuItem::class)->whereNull('parent_id')->orderBy('order');
    }

    public function allItems()
    {
        return $this->hasMany(NavigationMenuItem::class)->orderBy('order');
    }

    public function megaMenuContents()
    {
        return $this->hasMany(MegaMenuContent::class)->orderBy('order');
    }
}
