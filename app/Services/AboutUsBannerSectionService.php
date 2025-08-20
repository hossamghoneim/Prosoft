<?php

namespace App\Services;

use App\Interfaces\AboutUsBannerSectionRepositoryInterface;
use App\Models\AboutUsBannerSection;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsBannerSectionService
{
    protected AboutUsBannerSectionRepositoryInterface $aboutUsBannerSectionRepository;

    public function __construct(AboutUsBannerSectionRepositoryInterface $aboutUsBannerSectionRepository)
    {
        $this->aboutUsBannerSectionRepository = $aboutUsBannerSectionRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->aboutUsBannerSectionRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->aboutUsBannerSectionRepository->show($id);
    }

    public function store(array $attributes)
    {
        // Set is_active to true for the first record, false for others
        $aboutUsBannerSectionsNumber = AboutUsBannerSection::whereIsActive(true)->count();
        $attributes['is_active'] = $aboutUsBannerSectionsNumber == 0 ? true : false;

        // Handle video upload
        if (isset($attributes['video'])) {
            $attributes['video_url'] = upload_file($attributes['video'], 'about-us-banner-videos');
            unset($attributes['video']);
        }

        return $this->aboutUsBannerSectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $aboutUsBannerSection = $this->aboutUsBannerSectionRepository->show($id);

        // Handle video update
        if (isset($attributes['video'])) {
            $attributes['video_url'] = update_file($aboutUsBannerSection->video_url, $attributes['video'], 'about-us-banner-videos');
            unset($attributes['video']);
        }

        return $this->aboutUsBannerSectionRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->aboutUsBannerSectionRepository->destroy($id);
    }
}
