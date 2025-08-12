<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSlider extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'short_des',
        'price',
        'image',
        'product_id',
        'status',
    ];
    protected $casts = [
        'status' => 'string',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
