<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePrimarySection extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'is_active',
    ];

    public function getImageAttribute($value)
    {
        return getFilePath($value);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
