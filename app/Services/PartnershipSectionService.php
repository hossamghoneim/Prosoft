<?php

namespace App\Services;

use App\Interfaces\PartnershipSectionRepositoryInterface;
use App\Models\PartnershipSection;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnershipSectionService
{
    protected PartnershipSectionRepositoryInterface $partnershipSectionRepository;

    public function __construct(PartnershipSectionRepositoryInterface $partnershipSectionRepository)
    {
        $this->partnershipSectionRepository = $partnershipSectionRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->partnershipSectionRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->partnershipSectionRepository->show($id);
    }

    public function store(array $attributes)
    {
        // Set is_active to true for the first record, false for others
        $partnershipSectionsNumber = PartnershipSection::whereIsActive(true)->count();
        $attributes['is_active'] = $partnershipSectionsNumber == 0 ? true : false;

        // Handle image upload
        if (isset($attributes['image'])) {
            $attributes['image'] = upload_file($attributes['image'], 'partnership-sections');
        }

        return $this->partnershipSectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $partnershipSection = $this->partnershipSectionRepository->show($id);

        // Handle image update
        if (isset($attributes['image'])) {
            $attributes['image'] = update_file($partnershipSection->image, $attributes['image'], 'partnership-sections');
        }

        return $this->partnershipSectionRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->partnershipSectionRepository->destroy($id);
    }
}
