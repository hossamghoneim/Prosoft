<?php

namespace App\Interfaces;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\PartnershipHeroSection;

interface PartnershipHeroSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator;
    public function show($id);
    public function store(array $attributes): PartnershipHeroSection;
    public function update($id, array $attributes);
    public function destroy($id): int;
}
