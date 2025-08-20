<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    protected $fillable = [
        'title',
        'image',
        'slug',
        'is_active'
    ];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
