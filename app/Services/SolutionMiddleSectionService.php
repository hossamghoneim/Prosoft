<?php

namespace App\Services;

use App\Interfaces\SolutionMiddleSectionRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class SolutionMiddleSectionService
{
    protected $repository;

    public function __construct(SolutionMiddleSectionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->all();
    }

    public function index($noLimit = false)
    {
        return $this->repository->index($noLimit);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        // Check if a section already exists for this specific solution
        $existingSection = \App\Models\SolutionMiddleSection::where('solution_id', $data['solution_id'])->first();

        if ($existingSection) {
            throw new \Exception('A middle section already exists for this solution.');
        }

        // Set is_active to true for the first record
        $data['is_active'] = true;

        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function count()
    {
        return $this->repository->count();
    }
}
