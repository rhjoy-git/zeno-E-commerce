<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code'];
    public function divisions()
    {
        return $this->hasMany(Division::class);
    }
}
