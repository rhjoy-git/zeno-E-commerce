<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
protected $fillable = [
    'product_id', 'image_path', 'variant_id', 'is_primary'
    
];
  public function product()
{
    return $this->belongsTo(Product::class);
}

}
