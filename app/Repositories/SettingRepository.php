<?php

namespace App\Repositories;

use App\Interfaces\SettingRepositoryInterface;
use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SettingRepository implements SettingRepositoryInterface
{
    public function index(): Collection
    {
        return Setting::all();
    }
    public function update(array $attributes)
    {
        $records = collect($attributes)->map(function ($value, $key) {
            return [
                'key' => $key,
                'value' => $value,
                'updated_at' => now()
            ];
        })->values()->toArray();

        return Setting::upsert(
            $records,
            ['key'], // unique key(s)
            ['value', 'updated_at'] // columns to update if record exists
        );

    }
}
