<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function customerProfile()
    {
        return $this->hasOne(CustomerProfile::class);
    }

    public function productWishes()
    {
        return $this->hasMany(ProductWish::class);
    }

    public function productCarts()
    {
        return $this->hasMany(ProductCart::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function invoiceProducts()
    {
        return $this->hasMany(InvoiceProduct::class);
    }
}
