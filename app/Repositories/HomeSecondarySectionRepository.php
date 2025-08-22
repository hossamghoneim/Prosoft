<?php

namespace App\Repositories;

use App\Interfaces\HomeSecondarySectionRepositoryInterface;
use App\Models\HomeSecondarySection;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeSecondarySectionRepository implements HomeSecondarySectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = HomeSecondarySection::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('main_title', 'LIKE', "%{$search}%")
                    ->orWhere('main_description', 'LIKE', "%{$search}%")
                    ->orWhere('first_card_title', 'LIKE', "%{$search}%")
                    ->orWhere('second_card_title', 'LIKE', "%{$search}%")
                    ->orWhere('third_card_title', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ($filters['per_page'] ?? 10);

        return $query->paginate($limit);
    }

    public function store(array $attributes): HomeSecondarySection
    {
        return HomeSecondarySection::create($attributes);
    }

    public function show($id)
    {
        return HomeSecondarySection::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $homeSecondarySection = HomeSecondarySection::findOrFail($id);
        $homeSecondarySection->update($attributes);

        return $homeSecondarySection->fresh();
    }

    public function destroy($id): int
    {
        return HomeSecondarySection::destroy($id);
    }
}
