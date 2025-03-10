<?php

namespace Database\Seeders;


use App\Enums\PermissionActions;
use App\Models\Role;
use App\Services\PermissionService;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    protected PermissionService $permissionService;
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $permissions = $this->permissionService->getSuperAdminPermissions();

         $superAdminRole = Role::create([
             'name_ar' => 'مدير تنفيذي',
             'name_en' => 'super admin',
             'permissions' => $permissions,
             'is_system_role' => true
         ]);

         (new AdminSeeder)->run($superAdminRole->id);
    }
}
