<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceBannerSectionRequest;
use App\Http\Requests\UpdateServiceBannerSectionRequest;
use App\Http\Resources\ServiceBannerSectionResource;
use App\Models\ServiceBannerSection;
use App\Services\ServiceBannerSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class ServiceBannerSectionController extends Controller
{
    use HttpResponsesTrait;
    private string $resource = ServiceBannerSectionResource::class;
    protected ServiceBannerSectionService $serviceBannerSectionService;

    public function __construct(ServiceBannerSectionService $serviceBannerSectionService)
    {
        parent::__construct('service-banner-sections');

        $this->serviceBannerSectionService = $serviceBannerSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()){
            $serviceBannerSections = $this->serviceBannerSectionService->index();

            return $this->resource::collection( $serviceBannerSections )->additional([
                'recordsTotal' => $serviceBannerSections->total(),
                'recordsFiltered' => $serviceBannerSections->total()
            ]);
        }

        // Check if a banner section already exists
        $existingBanner = ServiceBannerSection::first();

        return view('dashboard.services.banner-section.index', compact('existingBanner'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if a banner section already exists
        $existingBanner = ServiceBannerSection::first();
        if ($existingBanner) {
            return redirect()->route('dashboard.service-banner-sections.index')
                ->with('error', 'You cannot add new content because you can only add 1 banner');
        }

        return view('dashboard.services.banner-section.create');
    }

    public function edit(ServiceBannerSection $serviceBannerSection): View
    {
        $this->authorize(PermissionActions::CREATE);

        return view('dashboard.services.banner-section.edit',compact( 'serviceBannerSection'));
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.services.banner-section.show', [
            'serviceBannerSection' => new $this->resource($this->serviceBannerSectionService->show($id))
        ]);
    }

    public function store(StoreServiceBannerSectionRequest $request): Response
    {
        $serviceBannerSection = $this->serviceBannerSectionService->store($request->validated());

        return $this->success("Service Banner Section Created Successfully", new $this->resource($serviceBannerSection))
            ->withHeaders(['X-Redirect' => route('dashboard.service-banner-sections.index')]);
    }
    public function update($id, UpdateServiceBannerSectionRequest $request): Response
    {
        $serviceBannerSection = $this->serviceBannerSectionService->update($request->validated(), $id);

        return $this->success("Service Banner Section Updated Successfully", new $this->resource($serviceBannerSection));
    }
    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->serviceBannerSectionService->destroy($id);

        if ( $deleted )
            return $this->success('Service Banner Section Deleted Successfully');
        else
            return $this->notFoundError('Service Banner Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        $existingBanner = ServiceBannerSection::first();

        if ($existingBanner) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add new content because you can only add 1 banner'
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'No banner exists, you can add one'
        ], 200);
    }
}
