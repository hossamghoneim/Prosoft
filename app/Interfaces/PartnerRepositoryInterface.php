<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Partner;

interface PartnerRepositoryInterface
{
    public function index($noLimit = false): LengthAwarePaginator;
    public function show($id);
    public function store(array $attributes): Partner;
    public function update($id, array $attributes);
    public function destroy($id): int;
}
