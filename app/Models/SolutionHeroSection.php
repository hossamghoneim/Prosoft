<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolutionHeroSection extends Model
{
    protected $fillable = ['title', 'description', 'button_text', 'button_url', 'video_url', 'is_active', 'solution_id'];

    public function getVideoUrlAttribute($value)
    {
        return getFilePath($value);
    }

    public function solution()
    {
        return $this->belongsTo(Solution::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');
    }
}
