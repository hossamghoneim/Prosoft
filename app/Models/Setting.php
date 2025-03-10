<?php

namespace App\Models;

use App\Enums\SettingEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public function title(): Attribute
    {
        return Attribute::make(
            get: fn() => SettingEnum::tryFrom($this->attributes['key'])->name(),
        );
    }
}
