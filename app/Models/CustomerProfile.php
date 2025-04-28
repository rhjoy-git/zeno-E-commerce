<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    protected $fillable = [
        'cus_name',
        'cus_email',
        'cus_phone',
        'cus_address',
        'cus_city',
        'cus_state',
        'cus_country',
        'cus_zipcode',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviews() {
        return $this->hasMany(ProductReview::class, 'customer_id');
    }
}
