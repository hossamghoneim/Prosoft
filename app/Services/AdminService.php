<?php

namespace App\Services;

use App\Interfaces\AdminRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminService
{
    protected AdminRepositoryInterface $adminRepository;
    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }
    public function index(): LengthAwarePaginator
    {
        return $this->adminRepository->index();
    }

    public function show($id)
    {
        return $this->adminRepository->show($id);
    }

    public function store(array $attributes)
    {
        if (isset($attributes['image']))
            $attributes['image'] = upload_file($attributes['image'], 'admin');

        return $this->adminRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $admin = $this->adminRepository->show($id);

        if (isset($attributes['image']))
            $attributes['image'] = update_file($admin->image, $attributes['image'], 'admin');

        return $this->adminRepository->update($id,$attributes);
    }

    public function destroy(int $id): int
    {
        return $this->adminRepository->destroy($id);
    }
}
