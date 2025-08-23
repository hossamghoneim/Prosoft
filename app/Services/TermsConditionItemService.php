<?php

namespace App\Services;

use App\Interfaces\TermsConditionItemRepositoryInterface;
use App\Models\TermsConditionItem;
use Illuminate\Pagination\LengthAwarePaginator;

class TermsConditionItemService
{
    protected TermsConditionItemRepositoryInterface $termsConditionItemRepository;

    public function __construct(TermsConditionItemRepositoryInterface $termsConditionItemRepository)
    {
        $this->termsConditionItemRepository = $termsConditionItemRepository;
    }

    public function index( $noLimit = false ): LengthAwarePaginator
    {
        return $this->termsConditionItemRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->termsConditionItemRepository->show($id);
    }

    public function store(array $attributes)
    {
        // Set default order if not provided
        if (!isset($attributes['order'])) {
            $maxOrder = TermsConditionItem::max('order') ?? 0;
            $attributes['order'] = $maxOrder + 1;
        }

        return $this->termsConditionItemRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        return $this->termsConditionItemRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->termsConditionItemRepository->destroy($id);
    }
}
