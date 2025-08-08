<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsFeature extends Model
{
    protected $fillable = [
        'title',
        'is_active',
    ];

    public function aboutUsFeatureItems()
    {
        return $this->hasMany(AboutUsFeatureItem::class, 'about_us_feature_id');
    }
}
