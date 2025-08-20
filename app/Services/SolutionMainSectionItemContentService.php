<?php

namespace App\Services;

use App\Interfaces\SolutionMainSectionItemContentRepositoryInterface;
use App\Models\SolutionMainSectionItem;
use App\Models\SolutionMainSectionItemContent;
use Illuminate\Pagination\LengthAwarePaginator;

class SolutionMainSectionItemContentService
{
    protected SolutionMainSectionItemContentRepositoryInterface $solutionMainSectionItemContentRepository;

    public function __construct(SolutionMainSectionItemContentRepositoryInterface $solutionMainSectionItemContentRepository)
    {
        $this->solutionMainSectionItemContentRepository = $solutionMainSectionItemContentRepository;
    }

    public function index($noLimit = false)
    {
        return $this->solutionMainSectionItemContentRepository->all();
    }

    public function show($id)
    {
        return $this->solutionMainSectionItemContentRepository->find($id);
    }

    public function store(array $attributes)
    {
        // Check if content already exists for this item (only 1 allowed)
        $existingContent = $this->solutionMainSectionItemContentRepository->findByItem($attributes['solution_main_section_item_id']);
        if ($existingContent) {
            throw new \Exception('Only one content is allowed per item.');
        }

        // Handle background image upload
        if (isset($attributes['background_image'])) {
            $attributes['background_image'] = upload_file($attributes['background_image'], 'solution-main-section-item-contents');
        }

        // Handle logo upload
        if (isset($attributes['logo'])) {
            $attributes['logo'] = upload_file($attributes['logo'], 'solution-main-section-item-contents');
        }

        return $this->solutionMainSectionItemContentRepository->create($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $content = $this->solutionMainSectionItemContentRepository->find($id);

        // Handle background image update
        if (isset($attributes['background_image'])) {
            $attributes['background_image'] = update_file($content->background_image, $attributes['background_image'], 'solution-main-section-item-contents');
        }

        // Handle logo update
        if (isset($attributes['logo'])) {
            $attributes['logo'] = update_file($content->logo, $attributes['logo'], 'solution-main-section-item-contents');
        }

        return $this->solutionMainSectionItemContentRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->solutionMainSectionItemContentRepository->delete($id);
    }
}
