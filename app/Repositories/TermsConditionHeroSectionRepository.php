<?php

namespace App\Repositories;

use App\Interfaces\TermsConditionHeroSectionRepositoryInterface;
use App\Models\TermsConditionHeroSection;
use Illuminate\Pagination\LengthAwarePaginator;

class TermsConditionHeroSectionRepository implements TermsConditionHeroSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = TermsConditionHeroSection::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('description', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ( $filters['per_page'] ?? 10 );

        return $query->paginate($limit);
    }

    public function store(array $attributes): TermsConditionHeroSection
    {
        return TermsConditionHeroSection::create($attributes);
    }

    public function show($id)
    {
        return TermsConditionHeroSection::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $termsConditionHeroSection = TermsConditionHeroSection::findOrFail($id);
        $termsConditionHeroSection->update($attributes);

        return $termsConditionHeroSection->fresh();
    }

    public function destroy($id): int
    {
        return TermsConditionHeroSection::destroy($id);
    }
}

