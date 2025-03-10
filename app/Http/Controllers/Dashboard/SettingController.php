<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingRequest;
use App\Http\Resources\SettingResource;
use App\Services\SettingService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class SettingController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = SettingResource::class;
    protected SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        parent::__construct('settings');
        $this->settingService = $settingService;
    }

    public function index(): View
    {
        $this->authorize(PermissionActions::LIST_VIEW);
        $settings = $this->settingService->index()->pluck('value', 'key');
        return view('dashboard.settings', compact('settings'));
    }
    public function update(UpdateSettingRequest $request): Response
    {
        $this->settingService->update($request->validated());
        return $this->success('Setting Updated Successfully');
    }

}
