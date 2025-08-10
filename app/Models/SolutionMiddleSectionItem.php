<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolutionMiddleSectionItem extends Model
{
    protected $fillable = [
        'solution_middle_section_id',
        'title',
        'description',
        'icon',
        'order',
        'is_active'
    ];

    public function solutionMiddleSection()
    {
        return $this->belongsTo(SolutionMiddleSection::class);
    }

    public function getIconAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}
