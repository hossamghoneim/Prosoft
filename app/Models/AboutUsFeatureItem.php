<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsFeatureItem extends Model
{
    protected $fillable = [
        'about_us_feature_id',
        'icon',
        'title',
        'description',
        'is_active',
    ];

    public function aboutUsFeature()
    {
        return $this->belongsTo(AboutUsFeature::class, 'about_us_feature_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
