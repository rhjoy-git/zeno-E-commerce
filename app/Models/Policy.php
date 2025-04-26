<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'type',
        'des'
    ];
}
