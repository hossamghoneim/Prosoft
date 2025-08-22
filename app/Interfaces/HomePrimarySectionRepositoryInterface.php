<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\HomePrimarySection;

interface HomePrimarySectionRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator;
    public function show($id);
    public function store(array $attributes): HomePrimarySection;
    public function update($id, array $attributes);
    public function destroy($id): int;
}
