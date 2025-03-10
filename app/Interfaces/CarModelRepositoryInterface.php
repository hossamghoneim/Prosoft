<?php

namespace App\Interfaces;

use App\Models\CarModel;
use Illuminate\Pagination\LengthAwarePaginator;
interface CarModelRepositoryInterface
{
    public function index(): LengthAwarePaginator;
    public function show($id);
    public function store(array $attributes): CarModel;
    public function update($id, array $attributes);
    public function destroy($id): int;
}
