<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerBannerSection extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'is_active',
    ];

    public function getImageAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function partnerBannerSectionItems()
    {
        return $this->hasMany(PartnerBannerSectionItem::class, 'partner_banner_section_id');
    }
}
