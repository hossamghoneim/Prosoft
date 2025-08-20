<?php

namespace App\Interfaces;

interface SolutionMainSectionItemRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function count();
    public function countBySection($sectionId);
    public function findByItem($itemId);
}
