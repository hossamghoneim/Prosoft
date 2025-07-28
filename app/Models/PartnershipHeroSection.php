<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnershipHeroSection extends Model
{
    protected $fillable = [
        'title',
        'description',
        'button_text',
        'button_url',
        'video_url',
        'is_active',
    ];

    public function getVideoUrlAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}
