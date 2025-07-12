<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'short_des',
        'price',
        'category_id',
        'brand_id',
        'discount',
        'discount_price',
        'stock',
        'stock_quantity',
        'stock_alert',
        'slug',
        'sku',
        'status'
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

    public function productDetail()
    {
        return $this->hasOne(ProductDetail::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function slider()
    {
        return $this->hasOne(ProductSlider::class);
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
        return $this->hasMany(ProductTag::class);
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function invoiceProducts()
    {
        return $this->hasMany(InvoiceProduct::class);
    }
}
