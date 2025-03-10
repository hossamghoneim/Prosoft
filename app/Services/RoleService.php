<?php

namespace App\Services;

use App\Interfaces\RoleRepositoryInterface;

class RoleService
{
    protected RoleRepositoryInterface $roleRepository;
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
    public function index()
    {
        return $this->roleRepository->index();
    }

    public function show($id)
    {
        return $this->roleRepository->show($id);
    }

    public function store(array $attributes)
    {
        return $this->roleRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        return $this->roleRepository->update($id,$attributes);
    }

    public function destroy(int $id): int
    {
        return $this->roleRepository->destroy($id);
    }
    public function findByName($name)
    {
        return $this->roleRepository->findByName($name);
    }
}
