<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\PermissionService;
use App\Traits\HttpResponsesTrait;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    use HttpResponsesTrait;
    public function __construct()
    {
        parent::__construct('roles');
    }
    public function index()
    {
        return $this->success("Permission List", PermissionService::getSuperAdminPermissions() );
    }
}
