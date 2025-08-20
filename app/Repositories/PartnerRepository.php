<?php

namespace App\Repositories;

use App\Interfaces\PartnerRepositoryInterface;
use App\Models\Partner;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnerRepository implements PartnerRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = Partner::with('partnershipSection');

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('button_text', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ($filters['per_page'] ?? 10);

        return $query->paginate($limit);
    }

    public function store(array $attributes): Partner
    {
        return Partner::create($attributes);
    }

    public function show($id)
    {
        return Partner::with('partnershipSection')->findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $partner = Partner::findOrFail($id);
        $partner->update($attributes);

        return $partner->fresh(['partnershipSection']);
    }

    public function destroy($id): int
    {
        return Partner::destroy($id);
    }
}
