<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Access\Gate;

abstract class Controller
{
    public function __construct(public $module = null){}

    public function authorize($permission)
    {
        return app(Gate::class)->authorize("{$permission->value}@{$this->module}");
    }
}
