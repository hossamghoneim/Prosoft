<?php

namespace App\Repositories;

use App\Interfaces\ServiceSectionRepositoryInterface;
use App\Models\ServiceSection;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceSectionRepository implements ServiceSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = ServiceSection::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('slug', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ( $filters['per_page'] ?? 10 );

        return $query->orderBy('order', 'asc')->paginate($limit);
    }

    public function store(array $attributes): ServiceSection
    {
        return ServiceSection::create($attributes);
    }

    public function show($id)
    {
        return ServiceSection::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $serviceSection = ServiceSection::findOrFail($id);
        $serviceSection->update($attributes);

        return $serviceSection->fresh();
    }
    public function destroy($id): int
    {
        return ServiceSection::destroy($id);
    }
}
