<?php

namespace App\Services;

use App\Interfaces\AboutUsMiddleSectionItemRepositoryInterface;
use App\Models\AboutUsMiddleSectionItem;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsMiddleSectionItemService
{
    protected AboutUsMiddleSectionItemRepositoryInterface $aboutUsMiddleSectionItemRepository;

    public function __construct(AboutUsMiddleSectionItemRepositoryInterface $aboutUsMiddleSectionItemRepository)
    {
        $this->aboutUsMiddleSectionItemRepository = $aboutUsMiddleSectionItemRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->aboutUsMiddleSectionItemRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->aboutUsMiddleSectionItemRepository->show($id);
    }

    public function store(array $attributes)
    {
        // Handle icon upload
        if (isset($attributes['icon'])) {
            $attributes['icon'] = upload_file($attributes['icon'], 'about-us-middle-section-items');
        }

        $attributes['is_active'] = true;

        return $this->aboutUsMiddleSectionItemRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $aboutUsMiddleSectionItem = $this->aboutUsMiddleSectionItemRepository->show($id);

        // Handle icon update
        if (isset($attributes['icon'])) {
            $attributes['icon'] = update_file($aboutUsMiddleSectionItem->icon, $attributes['icon'], 'about-us-middle-section-items');
        }

        return $this->aboutUsMiddleSectionItemRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->aboutUsMiddleSectionItemRepository->destroy($id);
    }
}
