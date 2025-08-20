<?php

namespace App\Repositories;

use App\Interfaces\SolutionMainSectionItemContentRepositoryInterface;
use App\Models\SolutionMainSectionItemContent;

class SolutionMainSectionItemContentRepository implements SolutionMainSectionItemContentRepositoryInterface
{
    public function all()
    {
        return SolutionMainSectionItemContent::with('solutionMainSectionItem')->get();
    }

    public function find($id)
    {
        return SolutionMainSectionItemContent::with('solutionMainSectionItem')->findOrFail($id);
    }

    public function create(array $data)
    {
        return SolutionMainSectionItemContent::create($data);
    }

    public function update($id, array $data)
    {
        $content = $this->find($id);
        $content->update($data);
        return $content;
    }

    public function delete($id)
    {
        $content = $this->find($id);
        return $content->delete();
    }

    public function count()
    {
        return SolutionMainSectionItemContent::count();
    }

    public function findByItem($itemId)
    {
        return SolutionMainSectionItemContent::where('solution_main_section_item_id', $itemId)->first();
    }
}
