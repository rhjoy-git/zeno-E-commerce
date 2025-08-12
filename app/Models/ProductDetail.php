<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'specifications',
        'warranty',
        'product_id',
        'created_by',
        'updated_by',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    protected static function booted()
    {
        static::creating(function ($detail) {
            $detail->created_by = Auth::id() ?? null;
            $detail->updated_by = Auth::id() ?? null;
        });
        static::updating(function ($detail) {
            $detail->updated_by = Auth::id() ?? null;
        });
    }
}
