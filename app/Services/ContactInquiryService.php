<?php

namespace App\Services;

use App\Interfaces\ContactInquiryRepositoryInterface;
use App\Models\ContactInquiry;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactInquiryService
{
    protected ContactInquiryRepositoryInterface $contactInquiryRepository;

    public function __construct(ContactInquiryRepositoryInterface $contactInquiryRepository)
    {
        $this->contactInquiryRepository = $contactInquiryRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->contactInquiryRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->contactInquiryRepository->show($id);
    }

    public function store(array $attributes)
    {
        return $this->contactInquiryRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        return $this->contactInquiryRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->contactInquiryRepository->destroy($id);
    }
}
