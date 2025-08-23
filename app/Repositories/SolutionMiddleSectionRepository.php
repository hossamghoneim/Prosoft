<?php

namespace App\Repositories;

use App\Interfaces\SolutionMiddleSectionRepositoryInterface;
use App\Models\SolutionMiddleSection;

class SolutionMiddleSectionRepository implements SolutionMiddleSectionRepositoryInterface
{
    public function all()
    {
        return SolutionMiddleSection::all();
    }

    public function index($noLimit = false)
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = SolutionMiddleSection::with('solution');

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('main_title', 'LIKE', "%{$search}%")
                    ->orWhere('first_card_title', 'LIKE', "%{$search}%")
                    ->orWhere('second_card_title', 'LIKE', "%{$search}%")
                    ->orWhere('third_card_title', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ($filters['per_page'] ?? 10);

        return $query->paginate($limit);
    }

    public function find($id)
    {
        return SolutionMiddleSection::findOrFail($id);
    }

    public function create(array $data)
    {
        return SolutionMiddleSection::create($data);
    }

    public function update($id, array $data)
    {
        $section = $this->find($id);
        $section->update($data);
        return $section;
    }

    public function delete($id)
    {
        $section = $this->find($id);
        return $section->delete();
    }

    public function count()
    {
        return SolutionMiddleSection::count();
    }
}
