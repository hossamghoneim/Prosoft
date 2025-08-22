<?php

namespace App\Services;

use App\Interfaces\HomeHeroSectionRepositoryInterface;
use App\Models\HomeHeroSection;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeHeroSectionService
{
    protected HomeHeroSectionRepositoryInterface $homeHeroSectionRepository;

    public function __construct(HomeHeroSectionRepositoryInterface $homeHeroSectionRepository)
    {
        $this->homeHeroSectionRepository = $homeHeroSectionRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->homeHeroSectionRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->homeHeroSectionRepository->show($id);
    }

    public function store(array $attributes)
    {
        $homeHeroSectionsNumber = HomeHeroSection::whereIsActive(true)->count();
        $attributes['is_active'] = $homeHeroSectionsNumber == 0 ? true : false;

        if (isset($attributes['video_url'])) {
            $attributes['video_url'] = upload_file($attributes['video_url'], 'home-hero-videos');
        }

        return $this->homeHeroSectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $homeHeroSection = $this->homeHeroSectionRepository->show($id);

        if (isset($attributes['video_url'])) {
            $attributes['video_url'] = update_file($homeHeroSection->video_url, $attributes['video_url'], 'home-hero-videos');
        }

        return $this->homeHeroSectionRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->homeHeroSectionRepository->destroy($id);
    }
}
