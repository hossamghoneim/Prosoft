<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsHeroSection extends Model
{
    protected $fillable = ['title', 'description', 'button_text', 'button_url', 'video_url', 'is_active'];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
