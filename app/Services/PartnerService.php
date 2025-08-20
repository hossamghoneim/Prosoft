<?php

namespace App\Services;

use App\Interfaces\PartnerRepositoryInterface;
use App\Models\Partner;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnerService
{
    protected PartnerRepositoryInterface $partnerRepository;

    public function __construct(PartnerRepositoryInterface $partnerRepository)
    {
        $this->partnerRepository = $partnerRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->partnerRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->partnerRepository->show($id);
    }

    public function store(array $attributes)
    {
        // Handle image uploads
        if (isset($attributes['inner_logo'])) {
            $attributes['inner_logo'] = upload_file($attributes['inner_logo'], 'partner-logos');
        }

        if (isset($attributes['outer_logo'])) {
            $attributes['outer_logo'] = upload_file($attributes['outer_logo'], 'partner-logos');
        }

        $attributes['is_active'] = true;

        return $this->partnerRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $partner = $this->partnerRepository->show($id);

        // Handle image updates
        if (isset($attributes['inner_logo'])) {
            $attributes['inner_logo'] = update_file($partner->inner_logo, $attributes['inner_logo'], 'partner-logos');
        }

        if (isset($attributes['outer_logo'])) {
            $attributes['outer_logo'] = update_file($partner->outer_logo, $attributes['outer_logo'], 'partner-logos');
        }

        return $this->partnerRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->partnerRepository->destroy($id);
    }
}
