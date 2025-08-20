<?php

namespace App\Repositories;

use App\Interfaces\ServiceHeroSectionRepositoryInterface;
use App\Models\ServiceHeroSection;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceHeroSectionRepository implements ServiceHeroSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = ServiceHeroSection::query();

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

    public function store(array $attributes): ServiceHeroSection
    {
        return ServiceHeroSection::create($attributes);
    }

    public function show($id)
    {
        return ServiceHeroSection::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $serviceHeroSection = ServiceHeroSection::findOrFail($id);
        $serviceHeroSection->update($attributes);

        return $serviceHeroSection->fresh();
    }
    public function destroy($id): int
    {
        return ServiceHeroSection::destroy($id);
    }
}
