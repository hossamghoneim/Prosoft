<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsFinalSectionItem extends Model
{
    protected $fillable = [
        'about_us_final_section_id',
        'title',
        'description',
        'icon',
        'order',
        'is_active',
    ];

    public function aboutUsFinalSection()
    {
        return $this->belongsTo(AboutUsFinalSection::class);
    }

    public function getIconAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}
