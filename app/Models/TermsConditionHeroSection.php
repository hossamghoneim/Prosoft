<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsConditionHeroSection extends Model
{
    protected $fillable = ['description', 'video_url', 'is_active', 'effective_date'];
    protected $casts = [
        'effective_date' => 'date',
    ];


    public function getVideoUrlAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}
