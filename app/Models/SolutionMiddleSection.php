<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolutionMiddleSection extends Model
{
    protected $fillable = [
        'solution_id',
        'title',
        'is_active',
    ];

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
