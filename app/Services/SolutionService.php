<?php

namespace App\Services;

use App\Interfaces\SolutionRepositoryInterface;
use App\Models\Solution;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class SolutionService
{
    protected SolutionRepositoryInterface $solutionRepository;

    public function __construct(SolutionRepositoryInterface $solutionRepository)
    {
        $this->solutionRepository = $solutionRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->solutionRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->solutionRepository->show($id);
    }

    public function store(array $attributes)
    {
        // Handle image upload
        if (isset($attributes['image'])) {
            $attributes['image'] = upload_file($attributes['image'], 'solutions');
        }

        // Generate slug from title if not provided
        if (!isset($attributes['slug']) && isset($attributes['title'])) {
            $attributes['slug'] = Str::slug($attributes['title']);
        }

        $attributes['is_active'] = true;

        return $this->solutionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $solution = $this->solutionRepository->show($id);

        // Handle image update
        if (isset($attributes['image'])) {
            $attributes['image'] = update_file($solution->image, $attributes['image'], 'solutions');
        }

        // Generate slug from title if not provided
        if (!isset($attributes['slug']) && isset($attributes['title'])) {
            $attributes['slug'] = Str::slug($attributes['title']);
        }

        return $this->solutionRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->solutionRepository->destroy($id);
    }
}
