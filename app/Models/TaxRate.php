<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxRate extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'rate',
        'region',
        'is_active',
    ];
    protected $casts = [
        'rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
