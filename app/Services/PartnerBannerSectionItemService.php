<?php

namespace App\Services;

use App\Interfaces\PartnerBannerSectionItemRepositoryInterface;
use App\Models\PartnerBannerSectionItem;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnerBannerSectionItemService
{
    protected PartnerBannerSectionItemRepositoryInterface $partnerBannerSectionItemRepository;

    public function __construct(PartnerBannerSectionItemRepositoryInterface $partnerBannerSectionItemRepository)
    {
        $this->partnerBannerSectionItemRepository = $partnerBannerSectionItemRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->partnerBannerSectionItemRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->partnerBannerSectionItemRepository->show($id);
    }

    public function store(array $attributes)
    {
        // Handle icon upload
        if (isset($attributes['icon'])) {
            $attributes['icon'] = upload_file($attributes['icon'], 'partner-banner-section-items');
        }

        $attributes['is_active'] = true;

        return $this->partnerBannerSectionItemRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $partnerBannerSectionItem = $this->partnerBannerSectionItemRepository->show($id);

        // Handle icon update
        if (isset($attributes['icon'])) {
            $attributes['icon'] = update_file($partnerBannerSectionItem->icon, $attributes['icon'], 'partner-banner-section-items');
        }

        return $this->partnerBannerSectionItemRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->partnerBannerSectionItemRepository->destroy($id);
    }
}
