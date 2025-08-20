<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUsContent extends Model
{
    protected $fillable = ['title', 'description', 'video_url', 'contact_email', 'contact_phone'];

    public function contactUsSections()
    {
        return $this->hasMany(ContactUsSection::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
