<?php

namespace App\Services;

use App\Interfaces\ServiceHeroSectionRepositoryInterface;
use App\Models\ServiceHeroSection;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceHeroSectionService
{
    protected ServiceHeroSectionRepositoryInterface $serviceHeroSectionRepository;

    public function __construct(ServiceHeroSectionRepositoryInterface $serviceHeroSectionRepository)
    {
        $this->serviceHeroSectionRepository = $serviceHeroSectionRepository;
    }
    public function index( $noLimit = false ): LengthAwarePaginator
    {
        return $this->serviceHeroSectionRepository->index($noLimit);
    }
    public function show($id)
    {
        return $this->serviceHeroSectionRepository->show($id);
    }
    public function store(array $attributes)
    {
        $serviceHeroSectionsNumber = ServiceHeroSection::whereIsActive(true)->count();
        $attributes['is_active'] = $serviceHeroSectionsNumber == 0 ? true : false;
        $attributes['video_url'] = upload_file($attributes['video_url'], 'hero-video');

        return $this->serviceHeroSectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $serviceHeroSection = $this->serviceHeroSectionRepository->show($id);

        if ( isset($attributes['video_url']))
            $attributes['video_url'] = update_file($serviceHeroSection->video_url, $attributes['video_url'], 'hero-video');

        return $this->serviceHeroSectionRepository->update($id,$attributes);
    }

    public function destroy(int $id): int
    {
        return $this->serviceHeroSectionRepository->destroy($id);
    }
}
