<?php

namespace App\Repositories;

use App\Interfaces\ServiceBannerSectionRepositoryInterface;
use App\Models\ServiceBannerSection;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceBannerSectionRepository implements ServiceBannerSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = ServiceBannerSection::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ( $filters['per_page'] ?? 10 );

        return $query->paginate($limit);
    }

    public function store(array $attributes): ServiceBannerSection
    {
        return ServiceBannerSection::create($attributes);
    }

    public function show($id)
    {
        return ServiceBannerSection::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $serviceBannerSection = ServiceBannerSection::findOrFail($id);
        $serviceBannerSection->update($attributes);

        return $serviceBannerSection->fresh();
    }
    public function destroy($id): int
    {
        return ServiceBannerSection::destroy($id);
    }
}
