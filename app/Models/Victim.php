<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Victim extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'gender',
        'contact',
        'location',
        'safe_zone_id',
    ];

    public function safeZone()
    {
        return $this->belongsTo(SafeZone::class);
    }
}
