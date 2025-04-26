<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'brand_id',
        'price',
        'discount_price',
        'quantity',
        'description',
        'image',
        'status'
    ];
    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function brand() {
        return $this->belongsTo(Brand::class);
    }
    
    public function reviews() {
        return $this->hasMany(ProductReview::class);
    }
    
    public function productDetail() {
        return $this->hasOne(ProductDetail::class);
    }
    
    public function slider() {
        return $this->hasOne(ProductSlider::class);
    }
    
    public function wishes() {
        return $this->hasMany(ProductWish::class);
    }
    
    public function carts() {
        return $this->hasMany(ProductCart::class);
    }
    
    public function invoiceProducts() {
        return $this->hasMany(InvoiceProduct::class);
    }
    
}
