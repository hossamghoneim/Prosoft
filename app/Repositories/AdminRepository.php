<?php

namespace App\Repositories;

use App\Interfaces\AdminRepositoryInterface;
use App\Models\Admin;
use Illuminate\Pagination\LengthAwarePaginator;
class AdminRepository implements AdminRepositoryInterface
{
    public function index(): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'role_id', 'search');

        $query = Admin::query()->with('role');

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        });


        $query->when(isset($filters['role_id']), function ($q) use ($filters) {
            $q->where('role_id', $filters['role_id']);
        });

        $limit = $filters['per_page'] ?? 10; // Default to 10 if no limit is specified

        return $query->paginate($limit);
    }

    public function show($id)
    {
        return Admin::with('role')->findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $admin = Admin::findOrFail($id);
        $admin->update($attributes);

        return $admin->fresh();
    }

    public function store(array $attributes): Admin
    {
        return Admin::create($attributes);
    }

    public function destroy($id): int
    {
        return Admin::destroy($id);
    }
}
