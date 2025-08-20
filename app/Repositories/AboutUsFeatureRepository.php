<?php

namespace App\Repositories;

use App\Interfaces\AboutUsFeatureRepositoryInterface;
use App\Models\AboutUsFeature;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsFeatureRepository implements AboutUsFeatureRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = AboutUsFeature::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ($filters['per_page'] ?? 10);

        return $query->paginate($limit);
    }

    public function store(array $attributes): AboutUsFeature
    {
        return AboutUsFeature::create($attributes);
    }

    public function show($id)
    {
        return AboutUsFeature::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $aboutUsFeature = AboutUsFeature::findOrFail($id);
        $aboutUsFeature->update($attributes);

        return $aboutUsFeature->fresh();
    }

    public function destroy($id): int
    {
        return AboutUsFeature::destroy($id);
    }
}
