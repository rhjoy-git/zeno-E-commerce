<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function invoiceProducts() {
        return $this->hasMany(InvoiceProduct::class);
    }
    
}
