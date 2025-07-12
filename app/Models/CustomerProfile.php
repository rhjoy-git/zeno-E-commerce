<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    protected $fillable = [
        'cus_name',
        'cus_address',
        'cus_city',
        'cus_state',
        'cus_postcode',
        'cus_country',
        'cus_phone',
        'cus_fax',
        'ship_name',
        'ship_add',
        'ship_city',
        'ship_state',
        'ship_postcode',
        'ship_country',
        'ship_phone'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviews() {
        return $this->hasMany(ProductReview::class, 'customer_id');
    }
}
