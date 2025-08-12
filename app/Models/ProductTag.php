<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductTag extends Model
{
    use HasFactory;
    protected $table = 'product_tags';
    protected $fillable = [
        'product_id',
        'tag_id',
        'created_by',
        'updated_by',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
    protected static function booted()
    {
        static::creating(function ($tag) {
            $tag->created_by = Auth::id() ?? null;
            $tag->updated_by = Auth::id() ?? null;
        });
        static::updating(function ($tag) {
            $tag->updated_by = Auth::id() ?? null;
        });
    }
}
