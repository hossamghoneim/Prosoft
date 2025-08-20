<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAboutUsHeroSectionRequest;
use App\Http\Requests\UpdateAboutUsHeroSectionRequest;
use App\Http\Resources\AboutUsHeroSectionResource;
use App\Models\AboutUsHeroSection;
use App\Services\AboutUsHeroSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class AboutUsHeroSectionController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = AboutUsHeroSectionResource::class;
    protected AboutUsHeroSectionService $aboutUsHeroSectionService;

    public function __construct(AboutUsHeroSectionService $aboutUsHeroSectionService)
    {
        parent::__construct('about-us-hero-sections');

        $this->aboutUsHeroSectionService = $aboutUsHeroSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $aboutUsHeroSections = $this->aboutUsHeroSectionService->index();

            return $this->resource::collection($aboutUsHeroSections)->additional([
                'recordsTotal' => $aboutUsHeroSections->total(),
                'recordsFiltered' => $aboutUsHeroSections->total()
            ]);
        }

        // Check if hero section already exists
        $existingHero = AboutUsHeroSection::first();

        return view('dashboard.about-us.hero-section.index', compact('existingHero'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if hero section already exists
        $existingHero = AboutUsHeroSection::first();

        if ($existingHero) {
            return redirect()->route('dashboard.about-us-hero-sections.index')
                ->with('error', 'You cannot add more content because you can only add 1 about us hero section.');
        }

        return view('dashboard.about-us.hero-section.create');
    }

    public function store(StoreAboutUsHeroSectionRequest $request): Response
    {
        $aboutUsHeroSection = $this->aboutUsHeroSectionService->store($request->validated());

        return $this->success("About Us Hero Section Created Successfully", new $this->resource($aboutUsHeroSection))
            ->withHeaders(['X-Redirect' => route('dashboard.about-us-hero-sections.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.about-us.hero-section.show', [
            'aboutUsHeroSection' => new $this->resource($this->aboutUsHeroSectionService->show($id))
        ]);
    }

    public function edit(AboutUsHeroSection $aboutUsHeroSection): View
    {
        $this->authorize(PermissionActions::UPDATE);

        return view('dashboard.about-us.hero-section.edit', compact('aboutUsHeroSection'));
    }

    public function update($id, UpdateAboutUsHeroSectionRequest $request): Response
    {
        $aboutUsHeroSection = $this->aboutUsHeroSectionService->update($request->validated(), $id);

        return $this->success("About Us Hero Section Updated Successfully", new $this->resource($aboutUsHeroSection));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->aboutUsHeroSectionService->destroy($id);

        if ($deleted)
            return $this->success('About Us Hero Section Deleted Successfully');
        else
            return $this->notFoundError('About Us Hero Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if hero section already exists
        $existingHero = AboutUsHeroSection::first();

        if ($existingHero) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more content because you can only add 1 about us hero section.',
                'heroId' => $existingHero->id
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new about us hero section.'
        ], 200);
    }
}
