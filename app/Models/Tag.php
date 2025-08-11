<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_tags',
            'tag_id',
            'product_id'
        );
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
