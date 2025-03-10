<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Role extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected function name(): Attribute
    {
         return Attribute::make(
             get: fn () => $this->attributes[ 'name_' . getLocale() ],
         );
    }
    protected function permissions(): Attribute
    {
         return Attribute::make(
             get: fn (string $value) => json_decode($value, true),
             set: fn (array $value) =>  json_encode($value),
         );
    }

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }

}
