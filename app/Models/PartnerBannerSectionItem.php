<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerBannerSectionItem extends Model
{
    protected $fillable = [
        'partner_banner_section_id',
        'icon',
        'title',
        'description',
        'is_active',
    ];

    public function getIconAttribute($value)
    {
        return getFilePath($value);
    }

    public function partnerBannerSection()
    {
        return $this->belongsTo(PartnerBannerSection::class, 'partner_banner_section_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
