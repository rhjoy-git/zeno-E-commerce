<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationMenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'navigation_menu_id', 'parent_id', 'title', 'url', 'route',
        'category_id', 'brand_id', 'icon', 'order', 'is_featured',
        'featured_image', 'description', 'status'
    ];

    public function parent()
    {
        return $this->belongsTo(NavigationMenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(NavigationMenuItem::class, 'parent_id')->orderBy('order');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function getLinkAttribute()
    {
        if ($this->route) {
            return route($this->route);
        }

        if ($this->url) {
            return url($this->url);
        }

        if ($this->category_id) {
            return route('categories.show', $this->category);
        }

        if ($this->brand_id) {
            return route('brands.show', $this->brand);
        }

        return '#';
    }
}