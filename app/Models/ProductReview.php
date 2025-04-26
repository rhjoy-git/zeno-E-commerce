<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{    
    public function product() {
        return $this->belongsTo(Product::class);
    }
    public function customerProfile() {
        return $this->belongsTo(CustomerProfile::class, 'customer_id');
    }
}
