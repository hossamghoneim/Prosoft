<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolutionMainSectionItem extends Model
{
    protected $fillable = [
        'solution_main_section_id',
        'title',
        'image',
        'order',
        'is_active'
    ];

    public function getImageAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function solutionMainSection()
    {
        return $this->belongsTo(SolutionMainSection::class, 'solution_main_section_id');
    }

    public function solutionMainSectionItemContents()
    {
        return $this->hasMany(SolutionMainSectionItemContent::class);
    }
}
