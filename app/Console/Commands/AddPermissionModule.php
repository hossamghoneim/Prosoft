<?php

namespace App\Console\Commands;

use App\Services\PermissionService;
use Illuminate\Console\Command;
use App\Models\Role;

class AddPermissionModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions-module:add {module} {role_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a permission module to the permissions JSON column for specific roles or all roles if no role_id is provided';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $module = $this->argument('module');
        $roleId = $this->argument('role_id');

        // Define the default permissions
        $defaultPermissions = PermissionService::$actions;

        $roles = Role::query()->withoutGlobalScopes()
            ->when($roleId, function ($query, $roleId) {
                return $query->where('id', $roleId);
            })
            ->get();

        if ($roles->isEmpty()) {
            $this->error('No roles found.');
            return 1;
        }

        foreach ($roles as $role) {
            $permissions = $role->permissions ?? [];

            // Add the new module with default permissions if it doesn't exist
//            if (!isset($permissions[$module])) {
                $permissions[$module] = $defaultPermissions;

                // Update the role's permissions
                $role->update(['permissions' => $permissions]);

                $this->info("Module '{$module}' added to role '{$role->name}' (ID: {$role->id}).");
//            } else {
//                $this->info("Module '{$module}' already exists for role '{$role->name}' (ID: {$role->id}).");
//            }
        }

        return 0;
    }
}
