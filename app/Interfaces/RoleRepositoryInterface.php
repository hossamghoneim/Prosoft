<?php

namespace App\Interfaces;

use App\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;
interface RoleRepositoryInterface
{
    public function index(): LengthAwarePaginator;
    public function show($id);
    public function update($id,array $attributes);
    public function store(array $attributes): Role;
    public function destroy($id): int;
    public function findByName($name);
}
