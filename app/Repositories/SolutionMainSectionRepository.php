<?php

namespace App\Repositories;

use App\Interfaces\SolutionMainSectionRepositoryInterface;
use App\Models\SolutionMainSection;

class SolutionMainSectionRepository implements SolutionMainSectionRepositoryInterface
{
    public function all()
    {
        return SolutionMainSection::with('solution')->get();
    }

    public function find($id)
    {
        return SolutionMainSection::with('solution')->findOrFail($id);
    }

    public function create(array $data)
    {
        return SolutionMainSection::create($data);
    }

    public function update($id, array $data)
    {
        $section = $this->find($id);
        $section->update($data);
        return $section;
    }

    public function delete($id)
    {
        $section = $this->find($id);
        return $section->delete();
    }

    public function count()
    {
        return SolutionMainSection::count();
    }
}
