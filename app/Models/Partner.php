<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'inner_logo',
        'outer_logo',
        'partnership_section_id',
        'title',
        'description',
        'button_text',
        'button_url',
        'background_color',
        'is_active'
    ];

    public function partnershipSection()
    {
        return $this->belongsTo(PartnershipSection::class, 'partnership_section_id');
    }

    public function getInnerLogoAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function getOuterLogoAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}
