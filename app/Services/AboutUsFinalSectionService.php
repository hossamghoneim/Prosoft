<?php

namespace App\Services;

use App\Interfaces\AboutUsFinalSectionRepositoryInterface;
use App\Models\AboutUsFinalSection;
use Illuminate\Pagination\LengthAwarePaginator;

class AboutUsFinalSectionService
{
    protected AboutUsFinalSectionRepositoryInterface $aboutUsFinalSectionRepository;

    public function __construct(AboutUsFinalSectionRepositoryInterface $aboutUsFinalSectionRepository)
    {
        $this->aboutUsFinalSectionRepository = $aboutUsFinalSectionRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->aboutUsFinalSectionRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->aboutUsFinalSectionRepository->show($id);
    }

    public function store(array $attributes)
    {
        // Set is_active to true for the first record, false for others
        $aboutUsFinalSectionsNumber = AboutUsFinalSection::whereIsActive(true)->count();
        $attributes['is_active'] = $aboutUsFinalSectionsNumber == 0 ? true : false;

        return $this->aboutUsFinalSectionRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        return $this->aboutUsFinalSectionRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->aboutUsFinalSectionRepository->destroy($id);
    }
}
