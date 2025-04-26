<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviews() {
        return $this->hasMany(ProductReview::class, 'customer_id');
    }
}
