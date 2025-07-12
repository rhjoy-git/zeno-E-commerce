<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSlider extends Model
{
    protected $fillable = [
        'status',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
