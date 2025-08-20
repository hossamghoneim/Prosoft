<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'title',
        'address',
        'latitude',
        'longitude',
        'iframe_url',
        'is_active',
        'order',
    ];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
