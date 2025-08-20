<?php

namespace App\Repositories;

use App\Interfaces\PartnershipSectionRepositoryInterface;
use App\Models\PartnershipSection;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnershipSectionRepository implements PartnershipSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = PartnershipSection::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ($filters['per_page'] ?? 10);

        return $query->paginate($limit);
    }

    public function store(array $attributes): PartnershipSection
    {
        return PartnershipSection::create($attributes);
    }

    public function show($id)
    {
        return PartnershipSection::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $partnershipSection = PartnershipSection::findOrFail($id);
        $partnershipSection->update($attributes);

        return $partnershipSection->fresh();
    }

    public function destroy($id): int
    {
        return PartnershipSection::destroy($id);
    }
}
