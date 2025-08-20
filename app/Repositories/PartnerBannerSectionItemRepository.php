<?php

namespace App\Repositories;

use App\Interfaces\PartnerBannerSectionItemRepositoryInterface;
use App\Models\PartnerBannerSectionItem;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnerBannerSectionItemRepository implements PartnerBannerSectionItemRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = PartnerBannerSectionItem::with('partnerBannerSection');

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

    public function store(array $attributes): PartnerBannerSectionItem
    {
        return PartnerBannerSectionItem::create($attributes);
    }

    public function show($id)
    {
        return PartnerBannerSectionItem::with('partnerBannerSection')->findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $partnerBannerSectionItem = PartnerBannerSectionItem::findOrFail($id);
        $partnerBannerSectionItem->update($attributes);

        return $partnerBannerSectionItem->fresh();
    }

    public function destroy($id): int
    {
        return PartnerBannerSectionItem::destroy($id);
    }
}
