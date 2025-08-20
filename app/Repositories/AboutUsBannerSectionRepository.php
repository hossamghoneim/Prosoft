<?php

namespace App\Repositories;

use App\Interfaces\AboutUsBannerSectionRepositoryInterface;
use App\Models\AboutUsBannerSection;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsBannerSectionRepository implements AboutUsBannerSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = AboutUsBannerSection::query();

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

    public function store(array $attributes): AboutUsBannerSection
    {
        return AboutUsBannerSection::create($attributes);
    }

    public function show($id)
    {
        return AboutUsBannerSection::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $aboutUsBannerSection = AboutUsBannerSection::findOrFail($id);
        $aboutUsBannerSection->update($attributes);

        return $aboutUsBannerSection->fresh();
    }

    public function destroy($id): int
    {
        return AboutUsBannerSection::destroy($id);
    }
}
