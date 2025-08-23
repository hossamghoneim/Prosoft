<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTermsConditionHeroSectionRequest;
use App\Http\Requests\UpdateTermsConditionHeroSectionRequest;
use App\Http\Resources\TermsConditionHeroSectionResource;
use App\Models\TermsConditionHeroSection;
use App\Services\TermsConditionHeroSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class TermsConditionHeroSectionController extends Controller
{
    use HttpResponsesTrait;
    private string $resource = TermsConditionHeroSectionResource::class;
    protected TermsConditionHeroSectionService $termsConditionHeroSectionService;

    public function __construct(TermsConditionHeroSectionService $termsConditionHeroSectionService)
    {
        parent::__construct('terms-condition-hero-sections');

        $this->termsConditionHeroSectionService = $termsConditionHeroSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()){
            $termsConditionHeroSections = $this->termsConditionHeroSectionService->index();

            return $this->resource::collection( $termsConditionHeroSections )->additional([
                'recordsTotal' => $termsConditionHeroSections->total(),
                'recordsFiltered' => $termsConditionHeroSections->total()
            ]);
        }

        // Check if a hero section already exists
        $existingHero = TermsConditionHeroSection::first();

        return view('dashboard.terms-condition.hero-section.index', compact('existingHero'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if a hero section already exists
        $existingHero = TermsConditionHeroSection::first();

        if ($existingHero) {
            return redirect()->route('dashboard.terms-condition-hero-sections.index')
                ->with('error', 'You cannot add more content because you can only add 1 terms condition hero section.');
        }

        return view('dashboard.terms-condition.hero-section.create');
    }

    public function edit(TermsConditionHeroSection $termsConditionHeroSection): View
    {
        $this->authorize(PermissionActions::CREATE);

        return view('dashboard.terms-condition.hero-section.edit',compact( 'termsConditionHeroSection'));
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.terms-condition.hero-section.show', [
            'termsConditionHeroSection' => new $this->resource($this->termsConditionHeroSectionService->show($id))
        ]);
    }

    public function store(StoreTermsConditionHeroSectionRequest $request): Response
    {
        $termsConditionHeroSection = $this->termsConditionHeroSectionService->store($request->validated());

        return $this->success("Terms Condition Hero Section Created Successfully", new $this->resource($termsConditionHeroSection));
    }

    public function update($id, UpdateTermsConditionHeroSectionRequest $request): Response
    {
        $termsConditionHeroSection = $this->termsConditionHeroSectionService->update($request->validated(), $id);

        return $this->success("Terms Condition Hero Section Updated Successfully", new $this->resource($termsConditionHeroSection));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->termsConditionHeroSectionService->destroy($id);

        if ( $deleted )
            return $this->success('Terms Condition Hero Section Deleted Successfully');
        else
            return $this->notFoundError('Terms Condition Hero Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if a hero section already exists
        $existingHero = TermsConditionHeroSection::first();

        if ($existingHero) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more content because you can only add 1 terms condition hero section.',
                'heroId' => $existingHero->id
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new terms condition hero section.',
        ], 200);
    }
}
