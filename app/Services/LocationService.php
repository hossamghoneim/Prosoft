<?php

namespace App\Services;

use App\Interfaces\LocationRepositoryInterface;
use App\Models\Location;
use Illuminate\Pagination\LengthAwarePaginator;

class LocationService
{
    protected LocationRepositoryInterface $locationRepository;

    public function __construct(LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->locationRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->locationRepository->show($id);
    }

    public function store(array $attributes)
    {
        return $this->locationRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        return $this->locationRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->locationRepository->destroy($id);
    }
}
