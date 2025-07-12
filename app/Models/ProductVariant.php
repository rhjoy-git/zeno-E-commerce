<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'color',
        'size',
        'price',
        'stock_quantity',
        'sku',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
