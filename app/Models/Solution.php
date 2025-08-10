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

    public function getImageAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}
