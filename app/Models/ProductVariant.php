<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'price',
        'stock_quantity',
        'stock_alert',
        'sku',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => 'string',
        'price' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(ProductSize::class);
    }

    protected static function booted()
    {
        static::creating(function ($variant) {
            $variant->created_by = Auth::id() ?? null;
            $variant->updated_by = Auth::id() ?? null;
        });

        static::updating(function ($variant) {
            $variant->updated_by = Auth::id() ?? null;
        });
    }
}