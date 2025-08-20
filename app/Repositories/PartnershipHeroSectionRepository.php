<?php

namespace App\Repositories;

use App\Interfaces\PartnershipHeroSectionRepositoryInterface;
use App\Models\PartnershipHeroSection;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnershipHeroSectionRepository implements PartnershipHeroSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = PartnershipHeroSection::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('button_text', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ( $filters['per_page'] ?? 10 );

        return $query->paginate($limit);
    }

    public function store(array $attributes): PartnershipHeroSection
    {
        return PartnershipHeroSection::create($attributes);
    }

    public function show($id)
    {
        return PartnershipHeroSection::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $partnershipHeroSection = PartnershipHeroSection::findOrFail($id);
        $partnershipHeroSection->update($attributes);

        return $partnershipHeroSection->fresh();
    }
    public function destroy($id): int
    {
        return PartnershipHeroSection::destroy($id);
    }
}
