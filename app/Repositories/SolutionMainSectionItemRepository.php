<?php

namespace App\Repositories;

use App\Interfaces\SolutionMainSectionItemRepositoryInterface;
use App\Models\SolutionMainSectionItem;

class SolutionMainSectionItemRepository implements SolutionMainSectionItemRepositoryInterface
{
    public function all()
    {
        return SolutionMainSectionItem::with(['solutionMainSection', 'solutionMainSectionItemContent'])->get();
    }

    public function find($id)
    {
        return SolutionMainSectionItem::with(['solutionMainSection', 'solutionMainSectionItemContent'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return SolutionMainSectionItem::create($data);
    }

    public function update($id, array $data)
    {
        $item = $this->find($id);
        $item->update($data);
        return $item;
    }

    public function delete($id)
    {
        $item = $this->find($id);
        return $item->delete();
    }

    public function count()
    {
        return SolutionMainSectionItem::count();
    }

    public function countBySection($sectionId)
    {
        return SolutionMainSectionItem::where('solution_main_section_id', $sectionId)->count();
    }

    public function findByItem($itemId)
    {
        return SolutionMainSectionItem::where('id', $itemId)->first();
    }
}
