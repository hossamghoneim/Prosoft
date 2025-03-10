<?php

namespace App\Services;

use App\Interfaces\BrandRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandService
{
    protected BrandRepositoryInterface $brandRepository;
    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }
    public function index( $noLimit = false ): LengthAwarePaginator
    {
        return $this->brandRepository->index($noLimit);
    }
    public function show($id)
    {
        return $this->brandRepository->show($id);
    }
    public function store(array $attributes)
    {
        $attributes['image'] = upload_file($attributes['image'], 'brand');
        return $this->brandRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $brand = $this->brandRepository->show($id);

        if ( isset($attributes['image']))
            $attributes['image'] = update_file($brand->image, $attributes['image'], 'brand');

        return $this->brandRepository->update($id,$attributes);
    }

    public function destroy(int $id): int
    {
        return $this->brandRepository->destroy($id);
    }
}
