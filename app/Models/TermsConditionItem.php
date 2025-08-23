<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsConditionItem extends Model
{
    protected $fillable = [
        'title',
        'description',
        'order',
        'is_active',
    ];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
