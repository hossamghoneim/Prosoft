<?php

namespace App\Repositories;

use App\Interfaces\AboutUsFinalSectionRepositoryInterface;
use App\Models\AboutUsFinalSection;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsFinalSectionRepository implements AboutUsFinalSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = AboutUsFinalSection::query();

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

    public function store(array $attributes): AboutUsFinalSection
    {
        return AboutUsFinalSection::create($attributes);
    }

    public function show($id)
    {
        return AboutUsFinalSection::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $aboutUsFinalSection = AboutUsFinalSection::findOrFail($id);
        $aboutUsFinalSection->update($attributes);

        return $aboutUsFinalSection->fresh();
    }

    public function destroy($id): int
    {
        return AboutUsFinalSection::destroy($id);
    }
}
