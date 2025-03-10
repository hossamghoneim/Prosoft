<?php

namespace App\Repositories;

use App\Interfaces\CarModelRepositoryInterface;
use App\Models\CarModel;
use Illuminate\Pagination\LengthAwarePaginator;

class CarModelRepository implements CarModelRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'brand_id', 'search');

        $query = CarModel::query()->with('brand');

        $query->when(isset($filters['brand_id']), function ($q) use ($filters) {
            $q->where('brand_id', $filters['brand_id']);
        });

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('name_ar', 'LIKE', "%{$search}%")
                    ->orWhere('name_en', 'LIKE', "%{$search}%");
            });
        });


        $limit = $noLimit ? 1000000000 : ( $filters['per_page'] ?? 10 );

        return $query->paginate($limit);
    }

    public function store(array $attributes): CarModel
    {
        return CarModel::create($attributes);
    }

    public function show($id)
    {
        return CarModel::with('brand')->findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $vendor = CarModel::findOrFail($id);
        $vendor->update($attributes);

        return $vendor->fresh();
    }
    public function destroy($id): int
    {
        return CarModel::destroy($id);
    }
}
