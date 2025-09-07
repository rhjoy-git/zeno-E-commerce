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
        'stock_quantity' => 'integer',
        'stock_alert' => 'integer',
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
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getHasVariantsAttribute()
    {
        return $this->variants()->exists();
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
