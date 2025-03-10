<?php

namespace Database\Seeders;

use App\Enums\AdminTypes;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(int $roleId = 1): void
    {
        Admin::updateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => 12345678,
            'role_id' => $roleId
        ]);
    }
}
