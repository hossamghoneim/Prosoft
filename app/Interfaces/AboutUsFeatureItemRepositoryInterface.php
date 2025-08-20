<?php

namespace App\Interfaces;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\AboutUsFeatureItem;

interface AboutUsFeatureItemRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator;
    public function show($id);
    public function store(array $attributes): AboutUsFeatureItem;
    public function update($id, array $attributes);
    public function destroy($id): int;
}
