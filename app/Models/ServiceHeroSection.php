<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceHeroSection extends Model
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
        return getFilePath($value);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
