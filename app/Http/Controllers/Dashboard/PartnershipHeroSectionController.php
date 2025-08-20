<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePartnershipHeroSectionRequest;
use App\Http\Requests\UpdatePartnershipHeroSectionRequest;
use App\Http\Resources\PartnershipHeroSectionResource;
use App\Models\PartnershipHeroSection;
use App\Services\PartnershipHeroSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class PartnershipHeroSectionController extends Controller
{
    use HttpResponsesTrait;
    private string $resource = PartnershipHeroSectionResource::class;
    protected PartnershipHeroSectionService $partnershipHeroSectionService;

    public function __construct(PartnershipHeroSectionService $partnershipHeroSectionService)
    {
        parent::__construct('partnership-hero-sections');

        $this->partnershipHeroSectionService = $partnershipHeroSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()){
            $partnershipHeroSections = $this->partnershipHeroSectionService->index();

            return $this->resource::collection( $partnershipHeroSections )->additional([
                'recordsTotal' => $partnershipHeroSections->total(),
                'recordsFiltered' => $partnershipHeroSections->total()
            ]);
        }

        // Check if a hero section already exists
        $existingHero = PartnershipHeroSection::first();

        return view('dashboard.partnerships.hero-section.index', compact('existingHero'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if a hero section already exists
        $existingHero = PartnershipHeroSection::first();

        if ($existingHero) {
            return redirect()->route('dashboard.partnership-hero-sections.index')
                ->with('error', 'You cannot add more content because you can only add 1 partnership hero section.');
        }

        return view('dashboard.partnerships.hero-section.create');
    }

    public function edit(PartnershipHeroSection $partnershipHeroSection): View
    {
        $this->authorize(PermissionActions::CREATE);

        return view('dashboard.partnerships.hero-section.edit',compact( 'partnershipHeroSection'));
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.partnerships.hero-section.show', [
            'partnershipHeroSection' => new $this->resource($this->partnershipHeroSectionService->show($id))
        ]);
    }

    public function store(StorePartnershipHeroSectionRequest $request): Response
    {
        $partnershipHeroSection = $this->partnershipHeroSectionService->store($request->validated());

        return $this->success("Partnership Hero Section Created Successfully", new $this->resource($partnershipHeroSection));
    }
    public function update($id, UpdatePartnershipHeroSectionRequest $request): Response
    {
        $partnershipHeroSection = $this->partnershipHeroSectionService->update($request->validated(), $id);

        return $this->success("Partnership Hero Section Updated Successfully", new $this->resource($partnershipHeroSection));
    }
    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->partnershipHeroSectionService->destroy($id);

        if ( $deleted )
            return $this->success('Partnership Hero Section Deleted Successfully');
        else
            return $this->notFoundError('Partnership Hero Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if a hero section already exists
        $existingHero = PartnershipHeroSection::first();

        if ($existingHero) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more content because you can only add 1 partnership hero section.',
                'heroId' => $existingHero->id
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new partnership hero section.',
        ], 200);
    }
}
