<?php

namespace App\Repositories;

use App\Interfaces\AboutUsMiddleSectionItemRepositoryInterface;
use App\Models\AboutUsMiddleSectionItem;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsMiddleSectionItemRepository implements AboutUsMiddleSectionItemRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = AboutUsMiddleSectionItem::with('aboutUsMiddleSection');

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

    public function store(array $attributes): AboutUsMiddleSectionItem
    {
        return AboutUsMiddleSectionItem::create($attributes);
    }

    public function show($id)
    {
        return AboutUsMiddleSectionItem::with('aboutUsMiddleSection')->findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $aboutUsMiddleSectionItem = AboutUsMiddleSectionItem::findOrFail($id);
        $aboutUsMiddleSectionItem->update($attributes);

        return $aboutUsMiddleSectionItem->fresh(['aboutUsMiddleSection']);
    }

    public function destroy($id): int
    {
        return AboutUsMiddleSectionItem::destroy($id);
    }
}
