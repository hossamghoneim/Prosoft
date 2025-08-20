<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnershipSection extends Model
{
    protected $fillable = ['title', 'description', 'image', 'is_active'];

    public function partners()
    {
        return $this->hasMany(Partner::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
