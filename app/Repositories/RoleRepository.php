<?php

namespace App\Repositories;

use App\Interfaces\RoleRepositoryInterface;
use App\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleRepository implements RoleRepositoryInterface
{
    public function index(): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = Role::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('name_ar', 'LIKE', "%{$search}%")
                    ->orWhere('name_en', 'LIKE', "%{$search}%");
            });
        });

        $limit = $filters['per_page'] ?? 6; // Default to 10 if no limit is specified

        return $query->paginate($limit);
    }

    public function show($id): Role
    {
        return Role::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $role = Role::findOrFail($id);
        $role->update($attributes);

        return $role->fresh();
    }

    public function store(array $attributes): Role
    {
        return Role::create($attributes);
    }

    public function destroy($id): int
    {
        $role = $this->show($id);

        if ($role->is_system_role)
            return 0;

        return Role::destroy($id);
    }
    public function findByName($name)
    {
        return Role::where('name_ar', $name)->orWhere('name_en', $name)->first();
    }
}
