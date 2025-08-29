<?php

namespace App\Repositories;

use App\Interfaces\SolutionMiddleSectionItemRepositoryInterface;
use App\Models\SolutionMiddleSectionItem;
use Illuminate\Pagination\LengthAwarePaginator;

class SolutionMiddleSectionItemRepository implements SolutionMiddleSectionItemRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = SolutionMiddleSectionItem::with('solutionMiddleSection');

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

    public function store(array $attributes): SolutionMiddleSectionItem
    {
        return SolutionMiddleSectionItem::create($attributes);
    }

    public function show($id)
    {
        return SolutionMiddleSectionItem::with('solutionMiddleSection')->findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $solutionMiddleSectionItem = SolutionMiddleSectionItem::findOrFail($id);
        $solutionMiddleSectionItem->update($attributes);

        return $solutionMiddleSectionItem->fresh(['solutionMiddleSection']);
    }

    public function destroy($id): int
    {
        return SolutionMiddleSectionItem::destroy($id);
    }
}
