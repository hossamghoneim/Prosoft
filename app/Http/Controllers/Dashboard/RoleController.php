<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Requests\StoreAdminRoleRequest;
use App\Http\Requests\UpdateAdminRoleRequest;
use App\Http\Resources\RoleResource;
use App\Http\Controllers\Controller;
use App\Services\PermissionService;
use App\Services\RoleService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    use HttpResponsesTrait;
    private string $resource = RoleResource::class;
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        parent::__construct('roles');
        $this->roleService = $roleService;
    }

    public function index(): View
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        $roles = $this->roleService->index();
        $permissions = PermissionService::getSuperAdminPermissions();
        return view('dashboard.roles.index',[ 'roles' => $roles , 'permissions' => $permissions ]);
    }

    public function show($id,Request $request): View|Response
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        $role = $this->roleService->show($id);
        $permissions = PermissionService::getSuperAdminPermissions();


        if ( ! $request->ajax() )
            return view('dashboard.roles.show',[ 'role' => new $this->resource($role) , 'permissions' => $permissions]);
        else
            return $this->success("Role Details", new $this->resource($this->roleService->show($id)));

    }

    public function store(StoreAdminRoleRequest $request)
    {
        $role = $this->roleService->store($request->validated());
        return $this->success("Role Created Successfully", new $this->resource($role));
    }

    public function update($id, UpdateAdminRoleRequest $request): Response
    {
        $role = $this->roleService->update($request->validated(), $id);
        return $this->success("Role Updated Successfully", new $this->resource($role));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);
        $deleted = $this->roleService->destroy($id);

        if ( $deleted )
            return $this->success('Role Deleted Successfully');
        else
            return $this->notFoundError('Role doesn\'t exist or cannot be deleted');
    }
}
