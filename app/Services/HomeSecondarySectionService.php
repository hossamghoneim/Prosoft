<?php

namespace App\Services;

use App\Interfaces\HomeSecondarySectionRepositoryInterface;
use App\Models\HomeSecondarySection;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeSecondarySectionService
{
    protected HomeSecondarySectionRepositoryInterface $homeSecondarySectionRepository;

    public function __construct(HomeSecondarySectionRepositoryInterface $homeSecondarySectionRepository)
    {
        $this->homeSecondarySectionRepository = $homeSecondarySectionRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->homeSecondarySectionRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->homeSecondarySectionRepository->show($id);
    }

    public function store(array $attributes)
    {
        $homeSecondarySectionsNumber = HomeSecondarySection::count();
        // Only allow 1 secondary section
        if ($homeSecondarySectionsNumber > 0) {
            throw new \Exception('You can only add 1 home secondary section.');
        }

        // Handle file uploads
        if (isset($attributes['background_image'])) {
            $attributes['background_image'] = upload_file($attributes['background_image'], 'home-secondary-backgrounds');
        }

        if (isset($attributes['first_card_logo'])) {
            $attributes['first_card_logo'] = upload_file($attributes['first_card_logo'], 'home-secondary-logos');
        }

        if (isset($attributes['second_card_logo'])) {
            $attributes['second_card_logo'] = upload_file($attributes['second_card_logo'], 'home-secondary-logos');
        }

        if (isset($attributes['third_card_logo'])) {
            $attributes['third_card_logo'] = upload_file($attributes['third_card_logo'], 'home-secondary-logos');
        }

        return $this->homeSecondarySectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $homeSecondarySection = $this->homeSecondarySectionRepository->show($id);

        // Handle file uploads
        if (isset($attributes['background_image'])) {
            $attributes['background_image'] = update_file($homeSecondarySection->background_image, $attributes['background_image'], 'home-secondary-backgrounds');
        }

        if (isset($attributes['first_card_logo'])) {
            $attributes['first_card_logo'] = update_file($homeSecondarySection->first_card_logo, $attributes['first_card_logo'], 'home-secondary-logos');
        }

        if (isset($attributes['second_card_logo'])) {
            $attributes['second_card_logo'] = update_file($homeSecondarySection->second_card_logo, $attributes['second_card_logo'], 'home-secondary-logos');
        }

        if (isset($attributes['third_card_logo'])) {
            $attributes['third_card_logo'] = update_file($homeSecondarySection->third_card_logo, $attributes['third_card_logo'], 'home-secondary-logos');
        }

        return $this->homeSecondarySectionRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->homeSecondarySectionRepository->destroy($id);
    }
}
