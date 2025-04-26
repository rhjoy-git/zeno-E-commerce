<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function customerProfile() {
        return $this->hasOne(CustomerProfile::class);
    }
    
    public function productWishes() {
        return $this->hasMany(ProductWish::class);
    }
    
    public function productCarts() {
        return $this->hasMany(ProductCart::class);
    }
    
    public function invoices() {
        return $this->hasMany(Invoice::class);
    }
    
    public function invoiceProducts() {
        return $this->hasMany(InvoiceProduct::class);
    }
    
}
