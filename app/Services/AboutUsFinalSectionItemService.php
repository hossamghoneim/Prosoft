<?php

namespace App\Services;

use App\Interfaces\AboutUsFinalSectionItemRepositoryInterface;
use App\Models\AboutUsFinalSectionItem;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsFinalSectionItemService
{
    protected AboutUsFinalSectionItemRepositoryInterface $aboutUsFinalSectionItemRepository;

    public function __construct(AboutUsFinalSectionItemRepositoryInterface $aboutUsFinalSectionItemRepository)
    {
        $this->aboutUsFinalSectionItemRepository = $aboutUsFinalSectionItemRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->aboutUsFinalSectionItemRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->aboutUsFinalSectionItemRepository->show($id);
    }

    public function store(array $attributes)
    {
        // Handle icon upload
        if (isset($attributes['icon'])) {
            $attributes['icon'] = upload_file($attributes['icon'], 'about-us-final-section-items');
        }

        $attributes['is_active'] = true;

        return $this->aboutUsFinalSectionItemRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $aboutUsFinalSectionItem = $this->aboutUsFinalSectionItemRepository->show($id);

        // Handle icon update
        if (isset($attributes['icon'])) {
            $attributes['icon'] = update_file($aboutUsFinalSectionItem->icon, $attributes['icon'], 'about-us-final-section-items');
        }

        return $this->aboutUsFinalSectionItemRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->aboutUsFinalSectionItemRepository->destroy($id);
    }
}
