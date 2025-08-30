<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MegaMenuContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'navigation_menu_id', 'type', 'title', 'content', 'columns', 'order', 'is_active'
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function navigationMenu()
    {
        return $this->belongsTo(NavigationMenu::class);
    }
}