<?php

namespace App\Interfaces;
use Illuminate\Database\Eloquent\Collection;

interface SettingRepositoryInterface
{
    public function index(): Collection;
    public function update(array $attributes);
}
