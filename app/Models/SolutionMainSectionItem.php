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
        'is_active',
    ];

    public function solutionMainSection()
    {
        return $this->belongsTo(SolutionMainSection::class);
    }

    public function solutionMainSectionItemContent()
    {
        return $this->hasOne(SolutionMainSectionItemContent::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
