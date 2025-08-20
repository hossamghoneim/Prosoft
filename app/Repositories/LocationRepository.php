<?php

namespace App\Repositories;

use App\Interfaces\LocationRepositoryInterface;
use App\Models\Location;
use Illuminate\Pagination\LengthAwarePaginator;

class LocationRepository implements LocationRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = Location::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('address', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ($filters['per_page'] ?? 10);

        return $query->orderBy('order', 'asc')->paginate($limit);
    }

    public function store(array $attributes): Location
    {
        return Location::create($attributes);
    }

    public function show($id)
    {
        return Location::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $location = Location::findOrFail($id);
        $location->update($attributes);

        return $location->fresh();
    }

    public function destroy($id): int
    {
        return Location::destroy($id);
    }
}
