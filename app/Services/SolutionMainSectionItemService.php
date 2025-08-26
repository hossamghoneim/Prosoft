<?php

namespace App\Services;

use App\Interfaces\SolutionMainSectionItemRepositoryInterface;
use App\Models\SolutionMainSection;
use App\Models\SolutionMainSectionItem;
use Illuminate\Pagination\LengthAwarePaginator;

class SolutionMainSectionItemService
{
    protected SolutionMainSectionItemRepositoryInterface $solutionMainSectionItemRepository;

    public function __construct(SolutionMainSectionItemRepositoryInterface $solutionMainSectionItemRepository)
    {
        $this->solutionMainSectionItemRepository = $solutionMainSectionItemRepository;
    }

    public function index($noLimit = false)
    {
        return $this->solutionMainSectionItemRepository->all();
    }

    public function show($id)
    {
        return $this->solutionMainSectionItemRepository->find($id);
    }

    public function store(array $attributes)
    {
        // Handle image upload
        if (isset($attributes['image'])) {
            $attributes['image'] = upload_file($attributes['image'], 'solution-main-section-items');
        }

        // Set is_active to true
        $attributes['is_active'] = true;

        return $this->solutionMainSectionItemRepository->create($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $item = $this->solutionMainSectionItemRepository->find($id);

        // Handle image update
        if (isset($attributes['image'])) {
            $attributes['image'] = update_file($item->image, $attributes['image'], 'solution-main-section-items');
        }

        return $this->solutionMainSectionItemRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->solutionMainSectionItemRepository->delete($id);
    }
}
