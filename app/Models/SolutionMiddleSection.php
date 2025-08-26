<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolutionMiddleSection extends Model
{
    protected $fillable = [
        'solution_id',
        'main_title',
        'first_card_icon',
        'first_card_title',
        'first_card_description',
        'second_card_icon',
        'second_card_title',
        'second_card_description',
        'third_card_icon',
        'third_card_title',
        'third_card_description',
        'is_active',
    ];

    public function getFirstCardIconAttribute($value)
    {
        return getFilePath($value);
    }

    public function getSecondCardIconAttribute($value)
    {
        return getFilePath($value);
    }

    public function getThirdCardIconAttribute($value)
    {
        return getFilePath($value);
    }

    public function solution()
    {
        return $this->belongsTo(Solution::class);
    }

    public function solutionMiddleSectionItems()
    {
        return $this->hasMany(SolutionMiddleSectionItem::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
