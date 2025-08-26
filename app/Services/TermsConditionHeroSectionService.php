<?php

namespace App\Services;

use App\Interfaces\TermsConditionHeroSectionRepositoryInterface;
use App\Models\TermsConditionHeroSection;
use Illuminate\Pagination\LengthAwarePaginator;

class TermsConditionHeroSectionService
{
    protected TermsConditionHeroSectionRepositoryInterface $termsConditionHeroSectionRepository;

    public function __construct(TermsConditionHeroSectionRepositoryInterface $termsConditionHeroSectionRepository)
    {
        $this->termsConditionHeroSectionRepository = $termsConditionHeroSectionRepository;
    }

    public function index( $noLimit = false ): LengthAwarePaginator
    {
        return $this->termsConditionHeroSectionRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->termsConditionHeroSectionRepository->show($id);
    }

    public function store(array $attributes)
    {
        $termsConditionHeroSectionsNumber = TermsConditionHeroSection::whereIsActive(true)->count();
        $attributes['is_active'] = $termsConditionHeroSectionsNumber == 0 ? true : false;
        $attributes['video_url'] = upload_file($attributes['video_url'], 'terms-condition-hero-video');

        return $this->termsConditionHeroSectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $termsConditionHeroSection = $this->termsConditionHeroSectionRepository->show($id);

        if ( isset($attributes['video_url']))
            $attributes['video_url'] = update_file($termsConditionHeroSection->video_url, $attributes['video_url'], 'terms-condition-hero-video');

        return $this->termsConditionHeroSectionRepository->update($id,$attributes);
    }

    public function destroy(int $id): int
    {
        return $this->termsConditionHeroSectionRepository->destroy($id);
    }
}

