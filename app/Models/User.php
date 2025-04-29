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
        'otp',
        'otp_expires_at',
        'otp_attempts',
        'otp_blocked_until',
        'otp_last_attempt',
        'otp_blocked_until',
        'last_otp_request_date',
        'otp_requests_today'
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
}
