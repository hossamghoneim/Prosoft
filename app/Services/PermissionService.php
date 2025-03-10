<?php

namespace App\Services;

class PermissionService
{

    static array $actions = [
        'list_view',
        'detailed_view',
        'create',
        'update',
        'delete',
    ];

    static array $modules = [
        'admins',
        'vendors',
        'roles',
        'settings',
        'reports',
        'brands',
        'car-models',
        'products',
        'orders',
        'categories',
        'tags',
        'users',
        'coupons',
        'recycle_bin'
    ];
    static public function getSuperAdminPermissions(): array
    {

        $excludedModules = [];

        $modules = array_filter(self::$modules, function ($module) use ($excludedModules) {
            return !in_array($module, $excludedModules); // Exclude modules in the given array
        });

        // Define exceptions for specific modules
        $exceptions = [
            'settings' => [
                'unused_actions' => ['create','detailed_view','delete'], // Actions to exclude
                'extra_actions' => []  // Additional actions to include
            ],
            'tags' => [
                'unused_actions' => ['detailed_view'], // Actions to exclude
                'extra_actions' => []  // Additional actions to include
            ],
            'users' => [
                'unused_actions' => ['create', 'update', 'detailed_view'], // Actions to exclude
                'extra_actions' => []  // Additional actions to include
            ],
            'recycle_bin' => [
                'unused_actions' => ['create','delete', 'update', 'detailed_view'], // Actions to exclude
                'extra_actions' => ['restore']  // Additional actions to include
            ],
        ];

        $permissions = [];

        foreach ($modules as $module) {
            // Combine actions and any extra actions for the module
            $usedActions = array_merge(self::$actions, $exceptions[$module]['extra_actions'] ?? []);

            // Filter out unused actions for the module
            $usedActions = array_filter($usedActions, fn($action) => !in_array($action, $exceptions[$module]['unused_actions'] ?? []));

            $permissions[$module] = array_values($usedActions);
        }

        return $permissions;
    }

    static public function getVendorPermissions(): array
    {

        $excludedModules = [
            'vendors',
            'brands',
            'car-models',
            'categories',
            'recycle_bin',
            'tags',
        ];

        $modules = array_filter(self::$modules, function ($module) use ($excludedModules) {
            return !in_array($module, $excludedModules); // Exclude modules in the given array
        });

        // Define exceptions for specific modules
        $exceptions = [
            'settings' => [
                'unused_actions' => ['create','detailed_view','delete'], // Actions to exclude
                'extra_actions' => []  // Additional actions to include
            ],
            'tags' => [
                'unused_actions' => ['detailed_view'], // Actions to exclude
                'extra_actions' => []  // Additional actions to include
            ],
            'users' => [
                'unused_actions' => ['create', 'update', 'detailed_view'], // Actions to exclude
                'extra_actions' => []  // Additional actions to include
            ],
            'recycle_bin' => [
                'unused_actions' => ['create','delete', 'update', 'detailed_view'], // Actions to exclude
                'extra_actions' => ['restore']  // Additional actions to include
            ],
        ];

        $permissions = [];

        foreach ($modules as $module) {
            // Combine actions and any extra actions for the module
            $usedActions = array_merge(self::$actions, $exceptions[$module]['extra_actions'] ?? []);

            // Filter out unused actions for the module
            $usedActions = array_filter($usedActions, fn($action) => !in_array($action, $exceptions[$module]['unused_actions'] ?? []));

            $permissions[$module] = array_values($usedActions);
        }

        return $permissions;
    }

}
