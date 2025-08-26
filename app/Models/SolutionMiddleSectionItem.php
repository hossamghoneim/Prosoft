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

    public function getIconAttribute($value)
    {
        return getFilePath($value);
    }

    public function solutionMiddleSection()
    {
        return $this->belongsTo(SolutionMiddleSection::class);
    }
}
