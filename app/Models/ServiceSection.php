<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSection extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'order',
        'is_active',
    ];

    public function items() {
        return $this->hasMany(ServiceSectionItem::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
