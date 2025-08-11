<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = ['name', 'code'];

    /**
     * Get the divisions for the country.
     */
    public function divisions(): HasMany
    {
        return $this->hasMany(Division::class);
    }
}
