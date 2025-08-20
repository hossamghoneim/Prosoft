<?php

namespace App\Repositories;

use App\Interfaces\AboutUsFeatureItemRepositoryInterface;
use App\Models\AboutUsFeatureItem;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsFeatureItemRepository implements AboutUsFeatureItemRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = AboutUsFeatureItem::with('aboutUsFeature');

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ( $filters['per_page'] ?? 10 );

        return $query->paginate($limit);
    }

    public function store(array $attributes): AboutUsFeatureItem
    {
        return AboutUsFeatureItem::create($attributes);
    }

    public function show($id)
    {
        return AboutUsFeatureItem::with('aboutUsFeature')->findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $aboutUsFeatureItem = AboutUsFeatureItem::findOrFail($id);
        $aboutUsFeatureItem->update($attributes);

        return $aboutUsFeatureItem->fresh();
    }
    public function destroy($id): int
    {
        return AboutUsFeatureItem::destroy($id);
    }
}
