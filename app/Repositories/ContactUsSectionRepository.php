<?php

namespace App\Repositories;

use App\Interfaces\ContactUsSectionRepositoryInterface;
use App\Models\ContactUsSection;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactUsSectionRepository implements ContactUsSectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = ContactUsSection::with('contactUsContent');

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

    public function store(array $attributes): ContactUsSection
    {
        return ContactUsSection::create($attributes);
    }

    public function show($id)
    {
        return ContactUsSection::with('contactUsContent')->findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $contactUsSection = ContactUsSection::findOrFail($id);
        $contactUsSection->update($attributes);

        return $contactUsSection->fresh();
    }

    public function destroy($id): int
    {
        return ContactUsSection::destroy($id);
    }
}
