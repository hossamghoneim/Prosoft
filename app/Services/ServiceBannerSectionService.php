<?php

namespace App\Services;

use App\Interfaces\ServiceBannerSectionRepositoryInterface;
use App\Models\ServiceBannerSection;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceBannerSectionService
{
    protected ServiceBannerSectionRepositoryInterface $serviceBannerSectionRepository;

    public function __construct(ServiceBannerSectionRepositoryInterface $serviceBannerSectionRepository)
    {
        $this->serviceBannerSectionRepository = $serviceBannerSectionRepository;
    }
    public function index( $noLimit = false ): LengthAwarePaginator
    {
        return $this->serviceBannerSectionRepository->index($noLimit);
    }
    public function show($id)
    {
        return $this->serviceBannerSectionRepository->show($id);
    }
    public function store(array $attributes)
    {
        $serviceBannerSectionsNumber = ServiceBannerSection::whereIsActive(true)->count();
        $attributes['is_active'] = $serviceBannerSectionsNumber == 0 ? true : false;
        $attributes['image'] = upload_file($attributes['image'], 'banner-images');

        return $this->serviceBannerSectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $serviceBannerSection = $this->serviceBannerSectionRepository->show($id);

        if ( isset($attributes['image']))
            $attributes['image'] = update_file($serviceBannerSection->image, $attributes['image'], 'banner-images');

        return $this->serviceBannerSectionRepository->update($id,$attributes);
    }

    public function destroy(int $id): int
    {
        return $this->serviceBannerSectionRepository->destroy($id);
    }
}
