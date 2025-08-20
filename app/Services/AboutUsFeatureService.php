<?php

namespace App\Services;

use App\Interfaces\AboutUsFeatureRepositoryInterface;
use App\Models\AboutUsFeature;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsFeatureService
{
    protected AboutUsFeatureRepositoryInterface $aboutUsFeatureRepository;

    public function __construct(AboutUsFeatureRepositoryInterface $aboutUsFeatureRepository)
    {
        $this->aboutUsFeatureRepository = $aboutUsFeatureRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->aboutUsFeatureRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->aboutUsFeatureRepository->show($id);
    }

    public function store(array $attributes)
    {
        $attributes['is_active'] = true;

        return $this->aboutUsFeatureRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        return $this->aboutUsFeatureRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->aboutUsFeatureRepository->destroy($id);
    }
}
