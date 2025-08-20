<?php

namespace App\Services;

use App\Interfaces\ContactUsSectionRepositoryInterface;
use App\Models\ContactUsSection;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactUsSectionService
{
    protected ContactUsSectionRepositoryInterface $contactUsSectionRepository;

    public function __construct(ContactUsSectionRepositoryInterface $contactUsSectionRepository)
    {
        $this->contactUsSectionRepository = $contactUsSectionRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->contactUsSectionRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->contactUsSectionRepository->show($id);
    }

    public function store(array $attributes)
    {
        return $this->contactUsSectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        return $this->contactUsSectionRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->contactUsSectionRepository->destroy($id);
    }
}
