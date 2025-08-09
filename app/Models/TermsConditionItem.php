<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsConditionItem extends Model
{
    protected $fillable = ['title', 'description', 'order', 'is_active'];
}
