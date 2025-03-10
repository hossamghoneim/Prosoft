<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminPasswordRequest;
use App\Http\Requests\UpdateAdminProfileRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use App\Services\AdminService;
use App\Services\RoleService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    use HttpResponsesTrait;
    private string $resource = AdminResource::class;
    protected AdminService $adminService;
    protected RoleService $roleService;

    public function __construct(AdminService $adminService, RoleService $roleService)
    {
        parent::__construct('admins');
        $this->adminService = $adminService;
        $this->roleService = $roleService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()){

            $admins = $this->adminService->index();
            return $this->resource::collection( $admins )->additional([
                'recordsTotal' => $admins->total(),
                'recordsFiltered' => $admins->total()
            ]);

        }

        return view('dashboard.admins.index');
    }


    public function create(): View
    {
        $this->authorize(PermissionActions::CREATE);
        $roles = $this->roleService->index();

        return view('dashboard.admins.create',compact('roles'));
    }

    public function edit(Admin $admin): View
    {
        $this->authorize(PermissionActions::CREATE);
        $roles = $this->roleService->index();

        return view('dashboard.admins.edit',compact('roles', 'admin'));
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.admins.show', [
            'admin' => new $this->resource($this->adminService->show($id))
        ]);
    }

    public function store(StoreAdminRequest $request): Response
    {
        $admin = $this->adminService->store($request->validated());
        return $this->success("Admin Created Successfully", new $this->resource($admin));
    }

    public function update($id, UpdateAdminRequest $request): Response
    {
        $admin = $this->adminService->update($request->validated(), $id);
        return $this->success("Admin Updated Successfully", new $this->resource($admin));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);
        $deleted = $this->adminService->destroy($id);

        if ( $deleted )
            return $this->success('Admin Deleted Successfully');
        else
            return $this->notFoundError('Admin doesn\'t exist');
    }

    public function updateProfile(UpdateAdminProfileRequest $request): Response
    {
        auth()->user()->update($request->validated());
        return $this->success('Your Profile Updated Successfully');

    }

    public function updatePassword(UpdateAdminPasswordRequest $request){
        auth()->user()->update($request->validated());
        return $this->success('Your Password Updated Successfully');

    }
}
