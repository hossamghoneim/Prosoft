<?php

namespace App\Repositories;

use App\Interfaces\BrandRepositoryInterface;
use App\Models\Brand;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandRepository implements BrandRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = Brand::query();

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

    public function store(array $attributes): Brand
    {
        return Brand::create($attributes);
    }

    public function show($id)
    {
        return Brand::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $brand = Brand::findOrFail($id);
        $brand->update($attributes);

        return $brand->fresh();
    }
    public function destroy($id): int
    {
        return Brand::destroy($id);
    }
}
