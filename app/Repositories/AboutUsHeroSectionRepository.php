<?php

namespace App\Repositories;

use App\Interfaces\AboutUsHeroSectionRepositoryInterface;
use App\Models\AboutUsHeroSection;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsHeroSectionRepository implements AboutUsHeroSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = AboutUsHeroSection::query();

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

    public function store(array $attributes): AboutUsHeroSection
    {
        return AboutUsHeroSection::create($attributes);
    }

    public function show($id)
    {
        return AboutUsHeroSection::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $aboutUsHeroSection = AboutUsHeroSection::findOrFail($id);
        $aboutUsHeroSection->update($attributes);

        return $aboutUsHeroSection->fresh();
    }

    public function destroy($id): int
    {
        return AboutUsHeroSection::destroy($id);
    }
}
