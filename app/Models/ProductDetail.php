<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $fillable = [
        'status',
        'des',
        'color',
        'size',
        'product_id'
    ];
    public function product() {
        return $this->belongsTo(Product::class);
    }
    
}
