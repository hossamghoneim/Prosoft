<?php

namespace App\Repositories;

use App\Interfaces\AboutUsFinalSectionItemRepositoryInterface;
use App\Models\AboutUsFinalSectionItem;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsFinalSectionItemRepository implements AboutUsFinalSectionItemRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = AboutUsFinalSectionItem::with('aboutUsFinalSection');

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

    public function store(array $attributes): AboutUsFinalSectionItem
    {
        return AboutUsFinalSectionItem::create($attributes);
    }

    public function show($id)
    {
        return AboutUsFinalSectionItem::with('aboutUsFinalSection')->findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $aboutUsFinalSectionItem = AboutUsFinalSectionItem::findOrFail($id);
        $aboutUsFinalSectionItem->update($attributes);

        return $aboutUsFinalSectionItem->fresh(['aboutUsFinalSection']);
    }

    public function destroy($id): int
    {
        return AboutUsFinalSectionItem::destroy($id);
    }
}
