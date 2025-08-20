<?php

namespace App\Repositories;

use App\Interfaces\ServiceSectionItemRepositoryInterface;
use App\Models\ServiceSectionItem;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceSectionItemRepository implements ServiceSectionItemRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = ServiceSectionItem::with('serviceSection');

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ( $filters['per_page'] ?? 10 );

        return $query->orderBy('order', 'asc')->paginate($limit);
    }

    public function store(array $attributes): ServiceSectionItem
    {
        return ServiceSectionItem::create($attributes);
    }

    public function show($id)
    {
        return ServiceSectionItem::with('serviceSection')->findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $serviceSectionItem = ServiceSectionItem::findOrFail($id);
        $serviceSectionItem->update($attributes);

        return $serviceSectionItem->fresh();
    }
    public function destroy($id): int
    {
        return ServiceSectionItem::destroy($id);
    }
}
