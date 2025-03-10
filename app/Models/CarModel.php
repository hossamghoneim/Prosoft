<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarModel extends Model
{
    use SoftDeletes;

    protected $hidden = ['created_at', 'updated_at'];

    protected $guarded = [];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes[ 'name_' . getLocale() ],
        );
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

}
