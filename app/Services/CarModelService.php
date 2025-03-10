<?php

namespace App\Services;

use App\Interfaces\CarModelRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CarModelService
{
    protected CarModelRepositoryInterface $carModelRepository;
    public function __construct(CarModelRepositoryInterface $carModelRepository)
    {
        $this->carModelRepository = $carModelRepository;
    }
    public function index( $noLimit = false ): LengthAwarePaginator
    {
        return $this->carModelRepository->index($noLimit);
    }
    public function show($id)
    {
        return $this->carModelRepository->show($id);
    }
    public function store(array $attributes)
    {
        return $this->carModelRepository->store($attributes);
    }
    public function update(array $attributes, int $id)
    {
        return $this->carModelRepository->update($id,$attributes);
    }
    public function destroy(int $id): int
    {
        return $this->carModelRepository->destroy($id);
    }

}
