<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSecondarySection extends Model
{
    protected $fillable = [
        'main_title',
        'main_description',
        'background_image',
        'first_card_logo',
        'first_card_title',
        'first_card_description',
        'second_card_logo',
        'second_card_title',
        'second_card_description',
        'third_card_logo',
        'third_card_title',
        'third_card_description'
    ];

    public function getBackgroundImageAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function getFirstCardLogoAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function getSecondCardLogoAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function getThirdCardLogoAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}
