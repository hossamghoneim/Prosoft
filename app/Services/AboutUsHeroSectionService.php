<?php

namespace App\Services;

use App\Interfaces\AboutUsHeroSectionRepositoryInterface;
use App\Models\AboutUsHeroSection;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsHeroSectionService
{
    protected AboutUsHeroSectionRepositoryInterface $aboutUsHeroSectionRepository;

    public function __construct(AboutUsHeroSectionRepositoryInterface $aboutUsHeroSectionRepository)
    {
        $this->aboutUsHeroSectionRepository = $aboutUsHeroSectionRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->aboutUsHeroSectionRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->aboutUsHeroSectionRepository->show($id);
    }

    public function store(array $attributes)
    {
        $aboutUsHeroSectionsNumber = AboutUsHeroSection::whereIsActive(true)->count();
        $attributes['is_active'] = $aboutUsHeroSectionsNumber == 0 ? true : false;

        if (isset($attributes['video_url'])) {
            $attributes['video_url'] = upload_file($attributes['video_url'], 'about-us-hero-videos');
        }

        return $this->aboutUsHeroSectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $aboutUsHeroSection = $this->aboutUsHeroSectionRepository->show($id);

        if (isset($attributes['video_url'])) {
            $attributes['video_url'] = update_file($aboutUsHeroSection->video_url, $attributes['video_url'], 'about-us-hero-videos');
        }

        return $this->aboutUsHeroSectionRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->aboutUsHeroSectionRepository->destroy($id);
    }
}
