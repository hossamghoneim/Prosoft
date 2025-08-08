<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsMiddleSection extends Model
{
    protected $fillable = ['title', 'description', 'background_image', 'is_active'];

    public function aboutUsMiddleSectionItems()
    {
        return $this->hasMany(AboutUsMiddleSectionItem::class, 'about_us_middle_section_id');
    }

    public function getBackgroundImageAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}
