<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class District extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'division_id'];
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
