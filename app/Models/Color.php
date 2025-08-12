<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Color extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'hex_code',
        'created_by',
        'updated_by',
    ];
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    protected static function booted()
    {
        static::creating(function ($color) {
            $color->created_by = Auth::id() ?? null;
            $color->updated_by = Auth::id() ?? null;
        });
        static::updating(function ($color) {
            $color->updated_by = Auth::id() ?? null;
        });
    }
}
