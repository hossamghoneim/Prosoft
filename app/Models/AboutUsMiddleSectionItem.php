<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsMiddleSectionItem extends Model
{
    protected $fillable = [
        'about_us_middle_section_id',
        'icon',
        'title',
        'description',
        'order',
        'is_active',
    ];

    public function getIconAttribute($value)
    {
        return getFilePath($value);
    }

    public function aboutUsMiddleSection()
    {
        return $this->belongsTo(AboutUsMiddleSection::class, 'about_us_middle_section_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
