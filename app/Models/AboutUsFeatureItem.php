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
        'order',
        'is_active'
    ];

    public function aboutUsFeature()
    {
        return $this->belongsTo(AboutUsFeature::class, 'about_us_feature_id');
    }

    public function getIconAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}
