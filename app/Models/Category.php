<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'categoryName',
        'categoryImg',
        'status',
        'parent_id'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    // Get the parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
