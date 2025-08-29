<?php

namespace App\Services;

use App\Interfaces\SolutionMiddleSectionItemRepositoryInterface;
use App\Models\SolutionMiddleSectionItem;
use Illuminate\Pagination\LengthAwarePaginator;

class SolutionMiddleSectionItemService
{
    protected SolutionMiddleSectionItemRepositoryInterface $solutionMiddleSectionItemRepository;

    public function __construct(SolutionMiddleSectionItemRepositoryInterface $solutionMiddleSectionItemRepository)
    {
        $this->solutionMiddleSectionItemRepository = $solutionMiddleSectionItemRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->solutionMiddleSectionItemRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->solutionMiddleSectionItemRepository->show($id);
    }

    public function store(array $attributes)
    {
        // Handle icon upload
        if (isset($attributes['icon'])) {
            $attributes['icon'] = upload_file($attributes['icon'], 'solution-middle-section-items');
        }

        $attributes['is_active'] = true;

        return $this->solutionMiddleSectionItemRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $solutionMiddleSectionItem = $this->solutionMiddleSectionItemRepository->show($id);

        // Handle icon update
        if (isset($attributes['icon'])) {
            $attributes['icon'] = update_file($solutionMiddleSectionItem->icon, $attributes['icon'], 'solution-middle-section-items');
        }

        return $this->solutionMiddleSectionItemRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->solutionMiddleSectionItemRepository->destroy($id);
    }
}
