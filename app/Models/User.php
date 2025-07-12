<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'remember_token',
        'role_id',
        'otp',
        'otp_expires_at',
        'otp_blocked_until',
        'otp_last_sent_at'
    ];
    protected $casts = [
        'otp_expires_at' => 'datetime',
        'otp_blocked_until' => 'datetime',
        'otp_last_sent_at' => 'datetime'
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
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    public function cartItems()
    {
        return $this->hasMany(ProductCart::class);
    }
}
