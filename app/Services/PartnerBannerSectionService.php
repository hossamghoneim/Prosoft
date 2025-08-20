<?php

namespace App\Services;

use App\Interfaces\PartnerBannerSectionRepositoryInterface;
use App\Models\PartnerBannerSection;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnerBannerSectionService
{
    protected PartnerBannerSectionRepositoryInterface $partnerBannerSectionRepository;

    public function __construct(PartnerBannerSectionRepositoryInterface $partnerBannerSectionRepository)
    {
        $this->partnerBannerSectionRepository = $partnerBannerSectionRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->partnerBannerSectionRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->partnerBannerSectionRepository->show($id);
    }

    public function store(array $attributes)
    {
        // Set is_active to true for the first record, false for others
        $partnerBannerSectionsNumber = PartnerBannerSection::whereIsActive(true)->count();
        $attributes['is_active'] = $partnerBannerSectionsNumber == 0 ? true : false;

        // Handle image upload
        if (isset($attributes['image'])) {
            $attributes['image'] = upload_file($attributes['image'], 'partner-banner-sections');
        }

        return $this->partnerBannerSectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $partnerBannerSection = $this->partnerBannerSectionRepository->show($id);

        // Handle image update
        if (isset($attributes['image'])) {
            $attributes['image'] = update_file($partnerBannerSection->image, $attributes['image'], 'partner-banner-sections');
        }

        return $this->partnerBannerSectionRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->partnerBannerSectionRepository->destroy($id);
    }
}
