<?php

namespace App\Repositories;

use App\Interfaces\ContactInquiryRepositoryInterface;
use App\Models\ContactInquiry;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactInquiryRepository implements ContactInquiryRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator
    {
        $filters = request()->only('per_page', 'page', 'search');

        $query = ContactInquiry::query();

        // Apply search filter
        $query->when(isset($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('company', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('inquiry_type', 'LIKE', "%{$search}%")
                    ->orWhere('message', 'LIKE', "%{$search}%");
            });
        });

        $limit = $noLimit ? 1000000000 : ($filters['per_page'] ?? 10);

        return $query->orderBy('created_at', 'desc')->paginate($limit);
    }

    public function store(array $attributes): ContactInquiry
    {
        return ContactInquiry::create($attributes);
    }

    public function show($id)
    {
        return ContactInquiry::findOrFail($id);
    }

    public function update($id, array $attributes)
    {
        $contactInquiry = ContactInquiry::findOrFail($id);
        $contactInquiry->update($attributes);

        return $contactInquiry->fresh();
    }

    public function destroy($id): int
    {
        return ContactInquiry::destroy($id);
    }
}
