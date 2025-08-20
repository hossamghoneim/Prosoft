<?php

namespace App\Services;

use App\Interfaces\PartnershipHeroSectionRepositoryInterface;
use App\Models\PartnershipHeroSection;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnershipHeroSectionService
{
    protected PartnershipHeroSectionRepositoryInterface $partnershipHeroSectionRepository;

    public function __construct(PartnershipHeroSectionRepositoryInterface $partnershipHeroSectionRepository)
    {
        $this->partnershipHeroSectionRepository = $partnershipHeroSectionRepository;
    }
    public function index( $noLimit = false ): LengthAwarePaginator
    {
        return $this->partnershipHeroSectionRepository->index($noLimit);
    }
    public function show($id)
    {
        return $this->partnershipHeroSectionRepository->show($id);
    }
    public function store(array $attributes)
    {
        $partnershipHeroSectionsNumber = PartnershipHeroSection::whereIsActive(true)->count();
        $attributes['is_active'] = $partnershipHeroSectionsNumber == 0 ? true : false;
        $attributes['video_url'] = upload_file($attributes['video_url'], 'partnership-hero-video');

        return $this->partnershipHeroSectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $partnershipHeroSection = $this->partnershipHeroSectionRepository->show($id);

        if ( isset($attributes['video_url']))
            $attributes['video_url'] = update_file($partnershipHeroSection->video_url, $attributes['video_url'], 'partnership-hero-video');

        return $this->partnershipHeroSectionRepository->update($id,$attributes);
    }

    public function destroy(int $id): int
    {
        return $this->partnershipHeroSectionRepository->destroy($id);
    }
}
