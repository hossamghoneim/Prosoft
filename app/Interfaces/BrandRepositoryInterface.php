<?php

namespace App\Interfaces;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Brand;

interface BrandRepositoryInterface
{
    public function index(): LengthAwarePaginator;
    public function show($id);
    public function store(array $attributes): Brand;
    public function update($id, array $attributes);
    public function destroy($id): int;
}
