<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'inner_logo',
        'outer_logo',
        'home_page_logo',
        'partnership_section_id',
        'title',
        'description',
        'button_text',
        'button_url',
        'background_color',
        'is_active'
    ];

    public function getInnerLogoAttribute($value)
    {
        return getFilePath($value);
    }

    public function getOuterLogoAttribute($value)
    {
        return getFilePath($value);
    }

    public function getHomePageLogoAttribute($value)
    {
        return getFilePath($value);
    }

    public function partnershipSection()
    {
        return $this->belongsTo(PartnershipSection::class, 'partnership_section_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
