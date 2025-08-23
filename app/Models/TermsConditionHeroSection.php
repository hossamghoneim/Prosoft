<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsConditionHeroSection extends Model
{
    protected $fillable = [
        'description',
        'video_url',
        'is_active',
        'effective_date',
    ];

    protected $casts = [
        'effective_date' => 'date',
    ];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
