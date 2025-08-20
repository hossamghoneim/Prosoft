<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceHeroSectionRequest;
use App\Http\Requests\UpdateServiceHeroSectionRequest;
use App\Http\Resources\ServiceHeroSectionResource;
use App\Models\ServiceHeroSection;
use App\Services\ServiceHeroSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ServiceHeroSectionController extends Controller
{
    use HttpResponsesTrait;
    private string $resource = ServiceHeroSectionResource::class;
    protected ServiceHeroSectionService $serviceHeroSectionService;

    public function __construct(ServiceHeroSectionService $serviceHeroSectionService)
    {
        parent::__construct('service-hero-sections');

        $this->serviceHeroSectionService = $serviceHeroSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()){
            $serviceHeroSections = $this->serviceHeroSectionService->index();

            return $this->resource::collection( $serviceHeroSections )->additional([
                'recordsTotal' => $serviceHeroSections->total(),
                'recordsFiltered' => $serviceHeroSections->total()
            ]);
        }

        return view('dashboard.services.hero-section.index');
    }

    public function create(): View
    {
        $this->authorize(PermissionActions::CREATE);

        return view('dashboard.services.hero-section.create');
    }

    public function edit(ServiceHeroSection $serviceHeroSection): View
    {
        $this->authorize(PermissionActions::CREATE);

        return view('dashboard.services.hero-section.edit',compact( 'serviceHeroSection'));
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.services.hero-section.show', [
            'serviceHeroSection' => new $this->resource($this->serviceHeroSectionService->show($id))
        ]);
    }

    public function store(StoreServiceHeroSectionRequest $request): Response
    {
        $serviceHeroSection = $this->serviceHeroSectionService->store($request->validated());

        return $this->success("Service Hero Section Created Successfully", new $this->resource($serviceHeroSection));
    }
    public function update($id, UpdateServiceHeroSectionRequest $request): Response
    {
        $serviceHeroSection = $this->serviceHeroSectionService->update($request->validated(), $id);

        return $this->success("Service Hero Section Updated Successfully", new $this->resource($serviceHeroSection));
    }
    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->serviceHeroSectionService->destroy($id);

        if ( $deleted )
            return $this->success('Service Hero Section Deleted Successfully');
        else
            return $this->notFoundError('Service Hero Section doesn\'t exist');
    }
}
