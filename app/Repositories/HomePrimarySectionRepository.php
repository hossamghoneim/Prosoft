<?php

namespace App\Repositories;

use App\Interfaces\HomePrimarySectionRepositoryInterface;
use App\Models\HomePrimarySection;
use Illuminate\Pagination\LengthAwarePaginator;

class HomePrimarySectionRepository implements HomePrimarySectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = HomePrimarySection::query();

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

    public function store(array $attributes): HomePrimarySection
    {
        return HomePrimarySection::create($attributes);
    }

    public function show($id)
    {
        return HomePrimarySection::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $homePrimarySection = HomePrimarySection::findOrFail($id);
        $homePrimarySection->update($attributes);

        return $homePrimarySection->fresh();
    }

    public function destroy($id): int
    {
        return HomePrimarySection::destroy($id);
    }
}
