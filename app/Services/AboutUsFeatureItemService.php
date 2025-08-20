<?php

namespace App\Services;

use App\Interfaces\AboutUsFeatureItemRepositoryInterface;
use App\Models\AboutUsFeatureItem;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsFeatureItemService
{
    protected AboutUsFeatureItemRepositoryInterface $aboutUsFeatureItemRepository;

    public function __construct(AboutUsFeatureItemRepositoryInterface $aboutUsFeatureItemRepository)
    {
        $this->aboutUsFeatureItemRepository = $aboutUsFeatureItemRepository;
    }
    public function index( $noLimit = false ): LengthAwarePaginator
    {
        return $this->aboutUsFeatureItemRepository->index($noLimit);
    }
    public function show($id)
    {
        return $this->aboutUsFeatureItemRepository->show($id);
    }
    public function store(array $attributes)
    {
        // Handle icon upload
        if (isset($attributes['icon'])) {
            $attributes['icon'] = upload_file($attributes['icon'], 'about-us-feature-items');
        }

        $attributes['is_active'] = true;

        return $this->aboutUsFeatureItemRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $aboutUsFeatureItem = $this->aboutUsFeatureItemRepository->show($id);

        // Handle icon upload
        if (isset($attributes['icon'])) {
            $attributes['icon'] = update_file($aboutUsFeatureItem->icon, $attributes['icon'], 'about-us-feature-items');
        }

        return $this->aboutUsFeatureItemRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->aboutUsFeatureItemRepository->destroy($id);
    }
}
