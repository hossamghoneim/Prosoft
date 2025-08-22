<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\HomeHeroSection;

interface HomeHeroSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator;
    public function show($id);
    public function store(array $attributes): HomeHeroSection;
    public function update($id, array $attributes);
    public function destroy($id): int;
}
