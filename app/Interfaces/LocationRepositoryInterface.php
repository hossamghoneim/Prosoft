<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Location;

interface LocationRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator;
    public function show($id);
    public function store(array $attributes): Location;
    public function update($id, array $attributes);
    public function destroy($id): int;
}
