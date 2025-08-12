<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'country_id'];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
