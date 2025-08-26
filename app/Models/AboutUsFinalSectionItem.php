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

    public function getIconAttribute($value)
    {
        return getFilePath($value);
    }

    public function aboutUsFinalSection()
    {
        return $this->belongsTo(AboutUsFinalSection::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
