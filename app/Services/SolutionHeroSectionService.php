<?php

namespace App\Services;

use App\Interfaces\SolutionHeroSectionRepositoryInterface;
use App\Models\SolutionHeroSection;
use Illuminate\Pagination\LengthAwarePaginator;

class SolutionHeroSectionService
{
    protected SolutionHeroSectionRepositoryInterface $solutionHeroSectionRepository;

    public function __construct(SolutionHeroSectionRepositoryInterface $solutionHeroSectionRepository)
    {
        $this->solutionHeroSectionRepository = $solutionHeroSectionRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->solutionHeroSectionRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->solutionHeroSectionRepository->show($id);
    }

    public function store(array $attributes)
    {
        // Check if a hero section already exists for this specific solution
        $existingHero = SolutionHeroSection::where('solution_id', $attributes['solution_id'])->first();

        if ($existingHero) {
            throw new \Exception('A hero section already exists for this solution.');
        }

        // Handle video upload
        if (isset($attributes['video_url'])) {
            $attributes['video_url'] = upload_file($attributes['video_url'], 'solution-hero-video');
        }

        // Set is_active to true
        $attributes['is_active'] = true;

        return $this->solutionHeroSectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $solutionHeroSection = $this->solutionHeroSectionRepository->show($id);

        // Handle video update
        if (isset($attributes['video_url'])) {
            $attributes['video_url'] = update_file($solutionHeroSection->video_url, $attributes['video_url'], 'solution-hero-video');
        }

        return $this->solutionHeroSectionRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->solutionHeroSectionRepository->destroy($id);
    }
}
