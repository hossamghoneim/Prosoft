<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingRequest;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
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

        // Get footer settings
        $footerSetting = Setting::where('key', 'footer')->first();
        $footerSettings = $footerSetting ? json_decode($footerSetting->value, true) : [];

        // Get header settings
        $headerSetting = Setting::where('key', 'header')->first();
        $headerSettings = $headerSetting ? json_decode($headerSetting->value, true) : [];

        return view('dashboard.settings', compact('settings', 'footerSettings', 'headerSettings'));
    }
    public function update(UpdateSettingRequest $request): Response
    {
        $this->settingService->update($request->validated());
        return $this->success('Setting Updated Successfully');
    }

}
