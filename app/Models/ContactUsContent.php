<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUsContent extends Model
{
    protected $fillable = ['title', 'description', 'video_url', 'contact_email', 'contact_phone'];

    public function getVideoUrlAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function contactUsSections()
    {
        return $this->hasMany(ContactUsSection::class);
    }
}
