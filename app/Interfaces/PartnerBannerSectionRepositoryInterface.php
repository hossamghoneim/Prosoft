<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\PartnerBannerSection;

interface PartnerBannerSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator;
    public function show($id);
    public function store(array $attributes): PartnerBannerSection;
    public function update($id, array $attributes);
    public function destroy($id): int;
}
