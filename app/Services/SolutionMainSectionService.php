<?php

namespace App\Services;

use App\Interfaces\SolutionMainSectionRepositoryInterface;
use App\Models\Solution;
use App\Models\SolutionMainSection;
use Illuminate\Pagination\LengthAwarePaginator;

class SolutionMainSectionService
{
    protected SolutionMainSectionRepositoryInterface $solutionMainSectionRepository;

    public function __construct(SolutionMainSectionRepositoryInterface $solutionMainSectionRepository)
    {
        $this->solutionMainSectionRepository = $solutionMainSectionRepository;
    }

    public function index($noLimit = false)
    {
        return $this->solutionMainSectionRepository->all();
    }

    public function show($id)
    {
        return $this->solutionMainSectionRepository->find($id);
    }

    public function store(array $attributes)
    {
        // Check if a main section already exists for this specific solution
        $existingSection = SolutionMainSection::where('solution_id', $attributes['solution_id'])->first();

        if ($existingSection) {
            throw new \Exception('A main section already exists for this solution.');
        }

        // Set is_active to true
        $attributes['is_active'] = true;

        // Handle enable_grid_view checkbox - set to false if not present
        $attributes['enable_grid_view'] = isset($attributes['enable_grid_view']) ? true : false;

        return $this->solutionMainSectionRepository->create($attributes);
    }

    public function update(array $attributes, int $id)
    {
        // Handle enable_grid_view checkbox - set to false if not present
        $attributes['enable_grid_view'] = isset($attributes['enable_grid_view']) ? true : false;

        return $this->solutionMainSectionRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->solutionMainSectionRepository->delete($id);
    }
}
