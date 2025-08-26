<?php

namespace App\Repositories;

use App\Interfaces\TermsConditionItemRepositoryInterface;
use App\Models\TermsConditionItem;
use Illuminate\Pagination\LengthAwarePaginator;

class TermsConditionItemRepository implements TermsConditionItemRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = TermsConditionItem::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ( $filters['per_page'] ?? 10 );

        return $query->orderBy('order')->paginate($limit);
    }

    public function store(array $attributes): TermsConditionItem
    {
        return TermsConditionItem::create($attributes);
    }

    public function show($id)
    {
        return TermsConditionItem::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $termsConditionItem = TermsConditionItem::findOrFail($id);
        $termsConditionItem->update($attributes);

        return $termsConditionItem->fresh();
    }

    public function destroy($id): int
    {
        return TermsConditionItem::destroy($id);
    }
}

