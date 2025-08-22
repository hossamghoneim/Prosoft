<?php

namespace App\Repositories;

use App\Interfaces\HomeHeroSectionRepositoryInterface;
use App\Models\HomeHeroSection;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeHeroSectionRepository implements HomeHeroSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = HomeHeroSection::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('button_text', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ($filters['per_page'] ?? 10);

        return $query->paginate($limit);
    }

    public function store(array $attributes): HomeHeroSection
    {
        return HomeHeroSection::create($attributes);
    }

    public function show($id)
    {
        return HomeHeroSection::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $homeHeroSection = HomeHeroSection::findOrFail($id);
        $homeHeroSection->update($attributes);

        return $homeHeroSection->fresh();
    }

    public function destroy($id): int
    {
        return HomeHeroSection::destroy($id);
    }
}
