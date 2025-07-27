<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSectionItem extends Model
{
    protected $fillable = [
        'service_section_id',
        'icon',
        'title',
        'description',
        'order',
        'is_active',
    ];

    public function section() {
        return $this->belongsTo(ServiceSection::class);
    }

    public function getIconAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}
