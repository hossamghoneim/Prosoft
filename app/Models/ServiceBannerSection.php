<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceBannerSection extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',

        'is_active',
    ];

    public function getImageAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}
