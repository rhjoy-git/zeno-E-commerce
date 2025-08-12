<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'short_description',
        'price',
        'discount',
        'discount_price',
        'stock_alert',
        'stock_quantity',
        'slug',
        'sku',
        'status',
        'category_id',
        'brand_id',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'status' => 'string',
        'discount' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'stock_alert' => 'integer',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('status', 'approved');
    }
    public function details()
    {
        return $this->hasOne(ProductDetail::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function wishes()
    {
        return $this->hasMany(ProductWish::class);
    }
    public function carts()
    {
        return $this->hasMany(ProductCart::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function sliders()
    {
        return $this->hasMany(ProductSlider::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }
    protected static function booted()
    {
        static::creating(function ($product) {
            $product->created_by = Auth::id() ?? null;
            $product->updated_by = Auth::id() ?? null;
        });
        static::updating(function ($product) {
            $product->updated_by = Auth::id() ?? null;
        });
    }
}
