<?php

namespace App\Services;

use App\Interfaces\AboutUsMiddleSectionRepositoryInterface;
use App\Models\AboutUsMiddleSection;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsMiddleSectionService
{
    protected AboutUsMiddleSectionRepositoryInterface $aboutUsMiddleSectionRepository;

    public function __construct(AboutUsMiddleSectionRepositoryInterface $aboutUsMiddleSectionRepository)
    {
        $this->aboutUsMiddleSectionRepository = $aboutUsMiddleSectionRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->aboutUsMiddleSectionRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->aboutUsMiddleSectionRepository->show($id);
    }

    public function store(array $attributes)
    {
        // Handle background image upload
        if (isset($attributes['background_image'])) {
            $attributes['background_image'] = upload_file($attributes['background_image'], 'about-us-middle-sections');
        }

        $attributes['is_active'] = true;

        return $this->aboutUsMiddleSectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $aboutUsMiddleSection = $this->aboutUsMiddleSectionRepository->show($id);

        // Handle background image update
        if (isset($attributes['background_image'])) {
            $attributes['background_image'] = update_file($aboutUsMiddleSection->background_image, $attributes['background_image'], 'about-us-middle-sections');
        }

        return $this->aboutUsMiddleSectionRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->aboutUsMiddleSectionRepository->destroy($id);
    }
}
