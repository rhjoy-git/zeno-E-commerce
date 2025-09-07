<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductImage extends Model
{
  use HasFactory;
  protected $fillable = [
    'product_id',
    'variant_id',
    'image_path',
    'is_primary',
    'created_by',
    'updated_by',
  ];
  protected $casts = [
    'is_primary' => 'boolean',
  ];
  
  public function product()
  {
    return $this->belongsTo(Product::class);
  }
  public function variant()
  {
    return $this->belongsTo(ProductVariant::class);
  }
  public function scopePrimary($query)
  {
    return $query->where('is_primary', true);
  }
  protected static function booted()
  {
    static::creating(function ($image) {
      $image->created_by = Auth::id() ?? null;
      $image->updated_by = Auth::id() ?? null;
    });
    static::updating(function ($image) {
      $image->updated_by = Auth::id() ?? null;
    });
  }
}
