<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHomeHeroSectionRequest;
use App\Http\Requests\UpdateHomeHeroSectionRequest;
use App\Http\Resources\HomeHeroSectionResource;
use App\Models\HomeHeroSection;
use App\Services\HomeHeroSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class HomeHeroSectionController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = HomeHeroSectionResource::class;
    protected HomeHeroSectionService $homeHeroSectionService;

    public function __construct(HomeHeroSectionService $homeHeroSectionService)
    {
        parent::__construct('home-hero-sections');

        $this->homeHeroSectionService = $homeHeroSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $homeHeroSections = $this->homeHeroSectionService->index();

            return $this->resource::collection($homeHeroSections)->additional([
                'recordsTotal' => $homeHeroSections->total(),
                'recordsFiltered' => $homeHeroSections->total()
            ]);
        }

        // Check if hero section already exists
        $existingHero = HomeHeroSection::first();

        return view('dashboard.home.hero-section.index', compact('existingHero'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if hero section already exists
        $existingHero = HomeHeroSection::first();

        if ($existingHero) {
            return redirect()->route('dashboard.home-hero-sections.index')
                ->with('error', 'You cannot add more content because you can only add 1 home hero section.');
        }

        return view('dashboard.home.hero-section.create');
    }

    public function store(StoreHomeHeroSectionRequest $request): Response
    {
        $homeHeroSection = $this->homeHeroSectionService->store($request->validated());

        return $this->success("Home Hero Section Created Successfully", new $this->resource($homeHeroSection))
            ->withHeaders(['X-Redirect' => route('dashboard.home-hero-sections.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.home.hero-section.show', [
            'homeHeroSection' => new $this->resource($this->homeHeroSectionService->show($id))
        ]);
    }

    public function edit(HomeHeroSection $homeHeroSection): View
    {
        $this->authorize(PermissionActions::UPDATE);

        return view('dashboard.home.hero-section.edit', compact('homeHeroSection'));
    }

    public function update($id, UpdateHomeHeroSectionRequest $request): Response
    {
        $homeHeroSection = $this->homeHeroSectionService->update($request->validated(), $id);

        return $this->success("Home Hero Section Updated Successfully", new $this->resource($homeHeroSection));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->homeHeroSectionService->destroy($id);

        if ($deleted)
            return $this->success('Home Hero Section Deleted Successfully');
        else
            return $this->notFoundError('Home Hero Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if hero section already exists
        $existingHero = HomeHeroSection::first();

        if ($existingHero) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more content because you can only add 1 home hero section.',
                'heroId' => $existingHero->id
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new home hero section.'
        ], 200);
    }
}
