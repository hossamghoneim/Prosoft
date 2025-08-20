<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'company',
        'email',
        'phone',
        'inquiry_type',
        'message',
    ];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }

    public function getInquiryTypeNameAttribute()
    {
        return \App\Enums\InquiryTypesEnum::from($this->inquiry_type)->name();
    }
}
