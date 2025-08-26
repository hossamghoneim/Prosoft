<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolutionMainSectionItemContent extends Model
{
    protected $fillable = [
        'solution_main_section_item_id',
        'main_title',
        'description',
        'background_image',
        'first_card_title',
        'first_card_description',
        'second_card_title',
        'second_card_description',
        'third_card_title',
        'third_card_description',
        'logo',
        'button_text',
    ];

    public function getBackgroundImageAttribute($value)
    {
        return getFilePath($value);
    }
    public function getLogoAttribute($value)
    {
        return getFilePath($value);
    }

    public function solutionMainSectionItem()
    {
        return $this->belongsTo(SolutionMainSectionItem::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
