<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceSectionRequest;
use App\Http\Requests\UpdateServiceSectionRequest;
use App\Http\Resources\ServiceSectionResource;
use App\Models\ServiceSection;
use App\Services\ServiceSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class ServiceSectionController extends Controller
{
    use HttpResponsesTrait;
    private string $resource = ServiceSectionResource::class;
    protected ServiceSectionService $serviceSectionService;

    public function __construct(ServiceSectionService $serviceSectionService)
    {
        parent::__construct('service-sections');

        $this->serviceSectionService = $serviceSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()){
            $serviceSections = $this->serviceSectionService->index();

            return $this->resource::collection( $serviceSections )->additional([
                'recordsTotal' => $serviceSections->total(),
                'recordsFiltered' => $serviceSections->total()
            ]);
        }

        // Check if service sections already exist
        $existingSections = ServiceSection::count();

        return view('dashboard.services.section.index', compact('existingSections'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if service sections already exist (limit to 2)
        $existingSections = ServiceSection::count();
        if ($existingSections >= 2) {
            return redirect()->route('dashboard.service-sections.index')
                ->with('error', 'You cannot add new content because you can only add 2 service sections');
        }

        return view('dashboard.services.section.create');
    }

    public function edit(ServiceSection $serviceSection): View
    {
        $this->authorize(PermissionActions::CREATE);

        return view('dashboard.services.section.edit',compact( 'serviceSection'));
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.services.section.show', [
            'serviceSection' => new $this->resource($this->serviceSectionService->show($id))
        ]);
    }

    public function store(StoreServiceSectionRequest $request): Response
    {
        $serviceSection = $this->serviceSectionService->store($request->validated());

        return $this->success("Service Section Created Successfully", new $this->resource($serviceSection))
            ->withHeaders(['X-Redirect' => route('dashboard.service-sections.index')]);
    }
    public function update($id, UpdateServiceSectionRequest $request): Response
    {
        $serviceSection = $this->serviceSectionService->update($request->validated(), $id);

        return $this->success("Service Section Updated Successfully", new $this->resource($serviceSection));
    }
    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->serviceSectionService->destroy($id);

        if ( $deleted )
            return $this->success('Service Section Deleted Successfully');
        else
            return $this->notFoundError('Service Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        $existingSections = ServiceSection::count();

        if ($existingSections >= 2) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add new content because you can only add 2 service sections'
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add service sections'
        ], 200);
    }
}
