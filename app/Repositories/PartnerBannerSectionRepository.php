<?php

namespace App\Repositories;

use App\Interfaces\PartnerBannerSectionRepositoryInterface;
use App\Models\PartnerBannerSection;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnerBannerSectionRepository implements PartnerBannerSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = PartnerBannerSection::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ($filters['per_page'] ?? 10);

        return $query->paginate($limit);
    }

    public function store(array $attributes): PartnerBannerSection
    {
        return PartnerBannerSection::create($attributes);
    }

    public function show($id)
    {
        return PartnerBannerSection::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $partnerBannerSection = PartnerBannerSection::findOrFail($id);
        $partnerBannerSection->update($attributes);

        return $partnerBannerSection->fresh();
    }

    public function destroy($id): int
    {
        return PartnerBannerSection::destroy($id);
    }
}
