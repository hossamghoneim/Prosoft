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

    public function serviceSection()
    {
        return $this->belongsTo(ServiceSection::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
