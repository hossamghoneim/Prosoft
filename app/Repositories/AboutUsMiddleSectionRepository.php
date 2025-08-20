<?php

namespace App\Repositories;

use App\Interfaces\AboutUsMiddleSectionRepositoryInterface;
use App\Models\AboutUsMiddleSection;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsMiddleSectionRepository implements AboutUsMiddleSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = AboutUsMiddleSection::query();

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

    public function store(array $attributes): AboutUsMiddleSection
    {
        return AboutUsMiddleSection::create($attributes);
    }

    public function show($id)
    {
        return AboutUsMiddleSection::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $aboutUsMiddleSection = AboutUsMiddleSection::findOrFail($id);
        $aboutUsMiddleSection->update($attributes);

        return $aboutUsMiddleSection->fresh();
    }

    public function destroy($id): int
    {
        return AboutUsMiddleSection::destroy($id);
    }
}
