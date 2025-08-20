<?php

namespace App\Services;

use App\Interfaces\ServiceSectionRepositoryInterface;
use App\Models\ServiceSection;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceSectionService
{
    protected ServiceSectionRepositoryInterface $serviceSectionRepository;

    public function __construct(ServiceSectionRepositoryInterface $serviceSectionRepository)
    {
        $this->serviceSectionRepository = $serviceSectionRepository;
    }
    public function index( $noLimit = false ): LengthAwarePaginator
    {
        return $this->serviceSectionRepository->index($noLimit);
    }
    public function show($id)
    {
        return $this->serviceSectionRepository->show($id);
    }
    public function store(array $attributes)
    {
        // Set default order if not provided
        if (!isset($attributes['order'])) {
            $maxOrder = ServiceSection::max('order') ?? 0;
            $attributes['order'] = $maxOrder + 1;
        }

        $attributes['is_active'] = true;

        return $this->serviceSectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        return $this->serviceSectionRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->serviceSectionRepository->destroy($id);
    }
}
