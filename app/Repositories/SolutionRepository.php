<?php

namespace App\Repositories;

use App\Interfaces\SolutionRepositoryInterface;
use App\Models\Solution;
use Illuminate\Pagination\LengthAwarePaginator;

class SolutionRepository implements SolutionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = Solution::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('slug', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ($filters['per_page'] ?? 10);

        return $query->paginate($limit);
    }

    public function store(array $attributes): Solution
    {
        return Solution::create($attributes);
    }

    public function show($id)
    {
        return Solution::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $solution = Solution::findOrFail($id);
        $solution->update($attributes);

        return $solution->fresh();
    }

    public function destroy($id): int
    {
        return Solution::destroy($id);
    }
}

