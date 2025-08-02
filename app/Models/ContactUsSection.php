<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUsSection extends Model
{
    protected $fillable = ['contact_us_content_id', 'title', 'description'];

    public function contactUsContent()
    {
        return $this->belongsTo(ContactUsContent::class);
    }
}
