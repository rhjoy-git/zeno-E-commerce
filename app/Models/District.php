<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class District extends Model
{
    protected $fillable = ['name', 'division_id'];

    /**
     * Get the division that owns the district.
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
}
