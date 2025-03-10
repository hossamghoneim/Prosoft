<?php

namespace App\Interfaces;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Admin;

interface AdminRepositoryInterface
{
    public function index(): LengthAwarePaginator;
    public function show($id);
    public function update($id, array $attributes);
    public function store(array $attributes): Admin;
    public function destroy($id): int;
}
