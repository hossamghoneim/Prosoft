<?php

namespace App\Repositories;

use App\Interfaces\ContactUsContentRepositoryInterface;
use App\Models\ContactUsContent;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactUsContentRepository implements ContactUsContentRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = ContactUsContent::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('contact_email', 'LIKE', "%{$search}%")
                    ->orWhere('contact_phone', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ($filters['per_page'] ?? 10);

        return $query->paginate($limit);
    }

    public function store(array $attributes): ContactUsContent
    {
        return ContactUsContent::create($attributes);
    }

    public function show($id)
    {
        return ContactUsContent::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $contactUsContent = ContactUsContent::findOrFail($id);
        $contactUsContent->update($attributes);

        return $contactUsContent->fresh();
    }

    public function destroy($id): int
    {
        return ContactUsContent::destroy($id);
    }
}
