<?php

namespace App\Services;

use App\Interfaces\ServiceSectionItemRepositoryInterface;
use App\Models\ServiceSectionItem;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceSectionItemService
{
    protected ServiceSectionItemRepositoryInterface $serviceSectionItemRepository;

    public function __construct(ServiceSectionItemRepositoryInterface $serviceSectionItemRepository)
    {
        $this->serviceSectionItemRepository = $serviceSectionItemRepository;
    }
    public function index( $noLimit = false ): LengthAwarePaginator
    {
        return $this->serviceSectionItemRepository->index($noLimit);
    }
    public function show($id)
    {
        return $this->serviceSectionItemRepository->show($id);
    }
    public function store(array $attributes)
    {
        // Set default order if not provided
        if (!isset($attributes['order'])) {
            $maxOrder = ServiceSectionItem::where('service_section_id', $attributes['service_section_id'])->max('order') ?? 0;
            $attributes['order'] = $maxOrder + 1;
        }

        // Handle icon upload
        if (isset($attributes['icon'])) {
            $attributes['icon'] = upload_file($attributes['icon'], 'service-item-icons');
        }

        $attributes['is_active'] = true;

        return $this->serviceSectionItemRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $serviceSectionItem = $this->serviceSectionItemRepository->show($id);

        // Handle icon upload
        if (isset($attributes['icon'])) {
            $attributes['icon'] = update_file($serviceSectionItem->icon, $attributes['icon'], 'service-item-icons');
        }

        return $this->serviceSectionItemRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->serviceSectionItemRepository->destroy($id);
    }
}
