<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
    ];
    protected $casts = [
        'read_at' => 'datetime',
        'data' => 'array',
    ];
    public function notifiable()
    {
        return $this->morphTo();
    }
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
}
