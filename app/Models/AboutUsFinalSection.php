<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsFinalSection extends Model
{
    protected $fillable = ['title', 'description', 'is_active'];

    public function aboutUsFinalSectionItems()
    {
        return $this->hasMany(AboutUsFinalSectionItem::class);
    }
}
