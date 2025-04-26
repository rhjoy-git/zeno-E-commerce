<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    public function product() {
        return $this->belongsTo(Product::class);
    }
    
}
