<?php

namespace App\Interfaces;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\ServiceHeroSection;

interface ServiceHeroSectionRepositoryInterface
{
    public function index(): LengthAwarePaginator;
    public function show($id);
    public function store(array $attributes): ServiceHeroSection;
    public function update($id, array $attributes);
    public function destroy($id): int;
}
