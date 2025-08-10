<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolutionMainSection extends Model
{
    protected $fillable = [
        'solution_id',
        'title',
        'description',
        'is_active',
        'enable_grid_view'
    ];

    public function solution()
    {
        return $this->belongsTo(Solution::class);
    }

    public function solutionMainSectionItems()
    {
        return $this->hasMany(SolutionMainSectionItem::class);
    }
}
