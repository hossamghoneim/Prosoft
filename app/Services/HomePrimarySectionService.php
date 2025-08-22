<?php

namespace App\Services;

use App\Interfaces\HomePrimarySectionRepositoryInterface;
use App\Models\HomePrimarySection;
use Illuminate\Pagination\LengthAwarePaginator;

class HomePrimarySectionService
{
    protected HomePrimarySectionRepositoryInterface $homePrimarySectionRepository;

    public function __construct(HomePrimarySectionRepositoryInterface $homePrimarySectionRepository)
    {
        $this->homePrimarySectionRepository = $homePrimarySectionRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->homePrimarySectionRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->homePrimarySectionRepository->show($id);
    }

    public function store(array $attributes)
    {
        $homePrimarySectionsNumber = HomePrimarySection::whereIsActive(true)->count();
        $attributes['is_active'] = $homePrimarySectionsNumber == 0 ? true : false;

        if (isset($attributes['image'])) {
            $attributes['image'] = upload_file($attributes['image'], 'home-primary-images');
        }

        return $this->homePrimarySectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $homePrimarySection = $this->homePrimarySectionRepository->show($id);

        if (isset($attributes['image'])) {
            $attributes['image'] = update_file($homePrimarySection->image, $attributes['image'], 'home-primary-images');
        }

        return $this->homePrimarySectionRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->homePrimarySectionRepository->destroy($id);
    }
}
