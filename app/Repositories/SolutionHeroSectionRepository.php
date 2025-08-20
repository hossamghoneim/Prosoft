<?php

namespace App\Repositories;

use App\Interfaces\SolutionHeroSectionRepositoryInterface;
use App\Models\SolutionHeroSection;
use Illuminate\Pagination\LengthAwarePaginator;

class SolutionHeroSectionRepository implements SolutionHeroSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = SolutionHeroSection::with('solution');

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

    public function store(array $attributes): SolutionHeroSection
    {
        return SolutionHeroSection::create($attributes);
    }

    public function show($id)
    {
        return SolutionHeroSection::with('solution')->findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $solutionHeroSection = SolutionHeroSection::findOrFail($id);
        $solutionHeroSection->update($attributes);

        return $solutionHeroSection->fresh(['solution']);
    }

    public function destroy($id): int
    {
        return SolutionHeroSection::destroy($id);
    }
}
